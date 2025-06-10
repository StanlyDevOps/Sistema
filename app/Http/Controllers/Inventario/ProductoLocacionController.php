<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Locacion;
use App\Models\Inventario\ProductoLocacion;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;


class ProductoLocacionController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 53, '', 'inv_producto_locacion'];
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/05 - 9:29 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. ProductoLocacion::ConsultAll.
     *
     * Consult data
     *
     * @param array $data: Parameters. (buscador, pagina, tamanhio, id_company).
     *
     * @return Object
     */
    public function Consult($data = null) {

        $data = !is_array($data) ? request()->all() : $data;

        $objet = ProductoLocacion::ConsultAll(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio']
        );

        return is_null($objet) ? (object)self::$hs->jsonError : $objet;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 04:57 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. ProductoLocacion::Find.
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

        $class = ProductoLocacion::Find($data['id']);

        $class->estado = '-1';

        self::$transaccion[0] = request();
        self::$transaccion[2] = 'eliminar';

        $result = self::$hs->Save($class,self::$hs->mensajeEliminar,self::$transaccion);

        $location = new LocacionController();

        $location->UpdateExistence($class->id_locacion);

        return $result;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 01:19 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. self::$hs->DataVerification.
     *       2. Cliente::ConsultarPorEmpTipIdeNomApe.
     *       3. Cliente::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Create or update data
     *
     * @return object
     */
    public function CreateOrUpdate()
    {
        #0. Parameters
        $data = request()->all();

        #1. Data verification
        if($verifyData = $this->DataVerification($data)) {
            return $verifyData;
        };

        #2. If it's not update then find if exists
        if (!$data['id']) {

            $registrationExists = ProductoLocacion::FindByProductLocation(
                request(),
                $data['id_product'],
                $data['id_location']
            );
        }
        else {
            $registrationExists[] = ProductoLocacion::find($data['id']);
        }

        #2.1. Find stock of a warehouse
        $stockMax = (int)Locacion::find($data['id_location'])->stock_max;

        $existence = ProductoLocacion::SumExistenceByProductLocation(
            request(),
            $data['id_product'],
            $data['id_location']
        );

        if ($stockMax - ($existence + $data['existence']) < 0) {
            return response()->json([
                'resultado' => 0,
                'titulo'    => 'Se excede del limite',
                'mensaje'   => 'La máxima cantidad que permite la locación es ' . number_format($stockMax - $existence)
            ]);
        }

        #3. If you do not find any error
        if (!is_null($registrationExists)) {

            #3.1. If it exists, it is not deleted and it is not an update
            if (!$data['id'] && $registrationExists->count() && (int)$registrationExists[0]->estado > -1) {

                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. If it's eliminated or it's a update, change status and it update data
            elseif ($data['id'] || $registrationExists->count() && (int)$registrationExists[0]->estado < 0) {

                $class = $this->insertFields(ProductoLocacion::find($registrationExists[0]->id), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'actualizar';

                $result = self::$hs->ejecutarSave(
                    $class,
                    $data['id'] ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. If it doesn't exist, we create the transaction
            else {

                $class = $this->insertFields(new ProductoLocacion(), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                $result = self::$hs->ejecutarSave($class, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }


        $location = new LocacionController();

        $location->UpdateExistence($data['id_location']);

        return $result;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 01:19 PM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Data verification.
     *
     * @param array $data: Parameters
     *
     * @return object
     */
    private function DataVerification($data) {

        $validator = Validator::make($data, [
            'id_product'    => 'required|integer',
            'id_location'   => 'required|integer',
            'existence'     => 'required|integer',
            'stock_min'     => 'required|integer',
            'stock_max'     => 'required|integer'
        ], [
            'id_product.required' => 'El campo :attribute es requerido',
            'id_product.integer' => 'El campo :attribute debe ser númerico',

            'id_location.required' => 'El campo :attribute es requerido',
            'id_location.integer' => 'El campo :attribute debe ser númerico',

            'existence.required' => 'El campo :attribute es requerido',
            'existence.integer' => 'El campo :attribute debe ser númerico',

            'stock_min.required' => 'El campo :attribute es requerido',
            'stock_min.integer' => 'El campo :attribute debe ser númerico',

            'stock_max.required' => 'El campo :attribute es requerido',
            'stock_max.integer' => 'El campo :attribute debe ser númerico',
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
     * @date_create: 2018-05-01 - 04:44 PM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Insert fields.
     *
     * @param object  $class:   Objecto to fill.
     * @param array   $data:    Requests.
     *
     * @return object
     */
    private function insertFields($class, $data) {

        $class->id_producto = $data['id_product'];
        $class->id_locacion = $data['id_location'];
        $class->existencia  = $data['existence'];
        $class->stock_min   = $data['stock_min'];
        $class->stock_max   = $data['stock_max'];

        $data['id'] ? null : $class->estado = '1';

        return $class;
    }
}