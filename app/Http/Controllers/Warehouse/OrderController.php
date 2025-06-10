<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Producto;
use App\Models\Warehouse\Order;
use App\Models\Warehouse\Table;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 56, '', 'alm_pedido'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/04 - 7:54 AM
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
            'tables' => Table::FindAll(request(), request()->session()->get('idEmpresa')),
            'products' => Producto::GetForSelect(request(), request()->session()->get('idEmpresa'))
        ];

        return response()->json($params);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/02 - 12:57 PM
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

        $object = Order::ConsultAll(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio'],
            $data['id_company']
        );

        return is_null($object) ? (object)self::$hs->jsonError : $object;
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
     * @date_create: 2018/06/04 - 10:04 AM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Create or update
     *
     * @return Object
     */
    public function CreateOrUpdate()
    {
        #0. Parameters
        $data = request()->all();
        $data['id_company'] = request()->session()->get('idEmpresa');

        #1. Data verification
        if($verifyData = $this->DataVerification($data)) {
            return $verifyData;
        };

        #2. If it's not update then find if exists
        if (!$data['id']) {

            $registrationExists = new Order();
        }
        else {
            $registrationExists[] = Order::find($data['id']);
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

                $data['code'] = (int)Order::lastCodeByCompany(request(), $data['id_company']);
                $data['year'] = (int)date('Y');

                $class = $this->insertFields(new Order(), $data);

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

            $data['id_order'] = $class->id;

            $orderDetails = new OrderDetailsController();
            $orderDetails->CreateOrUpdate($data);
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
            'products' => 'required|array|min:1',
        ], [
            'products.required' => 'Debe seleccionar por lo menos un producto',
            'products.min' => 'La cantidad de productos minimos debe ser de :min'
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
        $class->id_mesa     = $data['id_table'];
        $class->descripcion = $data['description'];

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