<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Locacion;
use App\Models\Inventario\ProductoLocacion;
use Illuminate\Http\Request;


class LocacionController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 69, '', 'inv_locacion'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Unidades::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = Locacion::ConsultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('id_bodega')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/14 - 3:47 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Locacion::FindAvaliableByCeller.
     *
     * Consult data
     *
     * @param array $data: Parameters.
     *
     * @return Object
     */
    public function FindAvaliableByCeller($data = null) {

        $data = !is_array($data) ? request()->all() : $data;

        $objet = Locacion::FindAvaliableByCeller(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio'],
            $data['id_celler']
        );

        return is_null($objet) ? (object)self::$hs->jsonError : $objet;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Locacion::ConsultarPorEmpTipIdeNomApe.
     *       3. Locacion::find.
     *       4. self::$hs->ejecutarSave.
     *
     * Crea o actualiza los datos.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CrearActualizar(Request $request)
    {
        #1. Verificamos los datos enviados
        $id             = $request->get('id');
        $idEmpresa      = $request->session()->get('idEmpresa');

        #1.1. Datos obligatorios
        $datos = [
            'nombre' => 'Debe digitar el nombre para poder guardar los cambios'
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si no es actualización consultamos si existe
        if (!$id) {
            $existeRegistro = Locacion::ConsultarPorBodegaNombre(
                $request,
                $request->get('id_bodega'),
                $request->get('nombre')
            );
        }
        else {
            $existeRegistro[] = Locacion::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = $this->insertarCampos(Locacion::find($existeRegistro[0]->id), $request);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'actualizar';

                return self::$hs->ejecutarSave(
                    $clase,
                    $id ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. Si no existe entonces se crea
            else {

                $clase = $this->insertarCampos(new Locacion(), $request);

                self::$transaccion[0] = $request;
                self::$transaccion[2] = 'crear';

                return self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     *
     * Insertar campos.
     *
     * @param object  $clase:   Clase a llenar.
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    private function insertarCampos($clase,$request) {

        $clase->id_bodega   = $request->get('id_bodega');
        $clase->nombre      = $request->get('nombre');
        $clase->descripcion = $request->get('descripcion');
        $clase->existencia  = (int)str_replace(',', '', $request->get('existencia'));
        $clase->stock_min   = (int)str_replace(',', '', $request->get('stock_min'));
        $clase->stock_max   = (int)str_replace(',', '', $request->get('stock_max'));

        $request->get('id') ? null : $clase->estado = '1';

        return $clase;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Locacion::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Locacion::Find((int)$request->get('id'));

        if ($clase->estado === '1') {
            $clase->estado = '0';
        }
        elseif ($clase->estado === '0') {
            $clase->estado = '1';
        }

        self::$transaccion[0] = $request;
        self::$transaccion[2] = self::$hs->estados[$clase->estado];

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEstado,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Locacion::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Eliminar($request)
    {
        $clase = Locacion::Find((int)$request->get('id'));

        $clase->estado = '-1';

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Locacion::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Update existence
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function UpdateExistence($id) {

        $class = Locacion::Find($id);

        $class->existencia = ProductoLocacion::ExistenceByLocation(request(), $id);

        self::$transaccion[0] = request();
        self::$transaccion[2] = self::$hs->estados[$class->estado];

        return self::$hs->Save($class, self::$hs->mensajeEstado, self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/07 - 8:48 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Locacion::FindActiveByCeller.
     *
     * Find active by celler
     *
     * @param array $data: Parameters (id_celler).
     *
     * @return object
     */
    public function FindActiveByCeller($data = null) {

        if (!is_array($data)) {
            $data = request()->all();
        }

        $object = Locacion::FindActive(request(), $data['id_celler']);

        return is_null($object) ? (object)self::$hs->jsonError : $object;
    }
}