<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\TypeCard;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDetails;
use App\Models\Warehouse\Order;
use App\Models\Warehouse\OrderDetails;
use Illuminate\Support\Facades\Validator;


class InvoiceController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 75, '', 'ven_factura'];
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/11 - 11:28 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Order::ConsultAll.
     *
     * Load parameters
     *
     * @param array $data: Parameters (buscador, pagina, tamanhio, id_company).
     *
     * @return object
     */
    public function LoadParameters() {

        $params = [
            'type_card' => TypeCard::FindAll(request()),
            'order' => Order::FindAllUnipaid(request(), request()->session()->get('idEmpresa'))
        ];

        return response()->json($params);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/10 - 12:13 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Order::ConsultAll.
     *
     * Consult
     *
     * @param array $data: Parameters (buscador, pagina, tamanhio, id_company).
     *
     * @return object
     */
    public function Consult($data = null) {

        if (!is_array($data)) {
            $data = request()->all();
            $data['id_company'] = request()->session()->get('idEmpresa');
        }

        $object = Invoice::ConsultAll(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio'],
            $data['id_company']
        );

        return is_null($object) ? collect(self::$hs->jsonError) : $object;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 08:44 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Producto::Find.
     *       2. self::$hs->Save.
     *
     * Change status to -1 by id
     *
     * @param array $data: Parameters (id).
     *
     * @return object
     */
    public function Delete($data = null)
    {
        $data = !is_array($data) ? request()->all() : '';

        $class = Order::Find($data['id']);

        $class->estado = '-1';

        self::$transaccion[0] = request();
        self::$transaccion[2] = 'eliminar';

        return self::$hs->Save($class,self::$hs->mensajeEliminar,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/11 - 11:28 AM
     * @date_update: 2018/07/22 - 9:35 AM
     *
     * Create or update
     *
     * @return Object
     */
    public function CreateOrUpdate() {

        #0. Parameters
        $data = request()->all();
        $data['id_company'] = request()->session()->get('idEmpresa');

        #1. Data verification
        if($verifyData = $this->DataVerification($data)) {
            return $verifyData;
        };

        #2. If it's not update then find if exists
        if (!$data['id']) {

            $registrationExists = new Invoice();
        }
        else {
            $registrationExists[] = Invoice::find($data['id']);
        }

        #3. If you do not find any error
        if (!is_null($registrationExists)) {

            #3.1. If it's eliminated or it's a update, change status and it update data
            if ($data['id']) {

                $class = $this->insertFields(Order::find($registrationExists[0]->id), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'actualizar';

                $result = self::$hs->Save(
                    $class,
                    $data['id'] ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.2. If it doesn't exist, we create the transaction
            else {

                $data['code'] = (int)Invoice::all()->max('codigo') + 1;
                $data['year'] = (int)date('Y');

                $orderDetails = OrderDetails::FindByOrder(request(), $data['id_order']);

                $data['quantity']       = $orderDetails->count();
                $data['total']          = $orderDetails->sum('total');
                $data['total_tax']      = $orderDetails->sum('total_impuesto');
                $data['total_general']  = $orderDetails->sum('total_general');

                $class = $this->insertFields(new Invoice(), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                $result = self::$hs->Save($class, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }

        #4. If result is succefull add details order
        if ($result->original['resultado'] === 1) {

            foreach ($orderDetails as $od) {

                $invoiceDetails = new InvoiceDetails();

                $invoiceDetails->id_factura = $class->id;

                $invoiceDetails->producto       = $od['producto'];
                $invoiceDetails->unidad         = $od['unidad'];
                $invoiceDetails->cantidad       = $od['cantidad'];
                $invoiceDetails->total          = $od['total'];
                $invoiceDetails->total_impuesto = $od['total_impuesto'];
                $invoiceDetails->total_general  = $od['total_general'];

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';
                self::$transaccion[3] = 'inv_factura_detalle';

                self::$hs->Save($invoiceDetails, self::$hs->mensajeGuardar, self::$transaccion);
            }

            #4.1. Change status of take order
            $order = Order::find($data['id_order']);

            $order->estado = '0';

            self::$transaccion[2] = 'actualizar';
            self::$transaccion[3] = 'alm_pedido';

            self::$hs->Save($order, self::$hs->mensajeGuardar, self::$transaccion);
        }


        return $result;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/26 - 7:46 AM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Validador de campos.
     *
     * @return object
     */
    private function DataVerification($data) {

        $validator = Validator::make($data, [
            'id_order' => 'required|integer|min:1',
        ], [
            'id_order.required' => 'Debe seleccionar por lo menos un pedido',
            'id_order.integer' => 'El tipo de dato es incorrecto',
            'id_order.min' => 'El tipo de dato es incorrecto'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'resultado' => 0,
                'titulo' => 'Advertencia',
                'mensaje' => $validator->messages()->first()
            ]);
        }

        return null;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/05 - 12:56 PM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Insert fields.
     *
     * @param object  $class:   Object to fill.
     * @param array   $data:    Requests.
     *
     * @return object
     */
    private function insertFields($class, $data) {

        $class->id_empresa  = $data['id_company'];
        $class->comentarios = $data['description'];


        $class->id_pedido           = $data['id_order'];
        $class->id_tipo_tarjeta     = $data['id_type_card'];
        $class->codigo              = $data['code'];
        $class->anhio               = $data['year'];
        $class->cantidad            = $data['quantity'];
        $class->total               = $data['total'];
        $class->total_impuesto      = $data['total_tax'];
        $class->total_general       = $data['total_general'];
        $class->efectivo            = (float)str_replace('.', '', $data['cash']);

        if ($data['id']) {
            $class->estado = '1';
        }
        else {
            $class->codigo      = $data['code'];
            $class->anhio       = $data['year'];
        }

        return $class;
    }
}