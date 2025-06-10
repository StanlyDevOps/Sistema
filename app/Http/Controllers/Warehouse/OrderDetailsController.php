<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Producto;
use App\Models\Inventario\ProductoLocacion;
use App\Models\Warehouse\Order;
use App\Models\Warehouse\OrderDetails;
use App\Models\Warehouse\Table;
use Illuminate\Support\Facades\Validator;


class OrderDetailsController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 56, '', 'alm_pedido_detalle'];
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
    public function FindByOrder() {

        return OrderDetails::FindByOrder(request(), request()->all()['id_order']);
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

        $class = Table::Find($data['id']);

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
     * @param array $params: [
     *      id_company,
     *      id_order,
     *      products = [
     *          [id_product_location, quantity]
     *      ]
     * ]
     *
     * @return Object
     */
    public function CreateOrUpdate($params)
    {
        #0. Parameters
        $data = $params ? $params : request()->all();
        $data['id_company'] = request()->session()->get('idEmpresa');

        #1. Data verification
        if($verifyData = $this->DataVerification($data)) {
            return $verifyData;
        };

        #2. If it's not update then find if exists
        if ($data['id']) {
            OrderDetails::RemoveByOrder(request(), $data['id']);
        }

        $registrationExists = new OrderDetails();

        #3. create the transaction
        foreach ($data['products'] as $product) {

            $productLocation = ProductoLocacion::FindByID(request(), $product['id_product_location']);

            if ($productLocation->impuesto_valor > 0) {
                $impuesto = ($productLocation->valor * $product['quantity']) * $productLocation->impuesto_valor / 100;
            }
            else {
                $impuesto = 0;
            }

            $product['id_order']        = $data['id_order'];
            $product['name']            = $productLocation->nombre;
            $product['id']              = '';
            $product['id_product']      = $productLocation->id;
            $product['value']           = (int)$productLocation->valor;
            $product['unity']           = $productLocation->unidad;
            $product['total']           = (int)$productLocation->valor * $product['quantity'];
            $product['total_tax']       = $impuesto;
            $product['total_general']   = $impuesto + (int)$productLocation->valor * $product['quantity'];

            $class = $this->insertFields(new OrderDetails(), $product);

            self::$transaccion[0] = request();
            self::$transaccion[2] = $data['id'] ? 'actualizar' : 'crear';

            $result = self::$hs->Save($class, self::$hs->mensajeGuardar, self::$transaccion);
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

        $class->id_pedido            = $data['id_order'];
        $class->id_producto_locacion = (int)$data['id_product_location'];
        $class->producto             = $data['name'];
        $class->cantidad             = $data['quantity'];
        $class->valor                = $data['value'];
        $class->unidad               = $data['unity'];
        $class->total                = $data['total'];
        $class->total_impuesto       = $data['total_tax'];
        $class->total_general        = $data['total_general'];

        $data['id'] ? null : $class->estado = '1';

        return $class;
    }
}