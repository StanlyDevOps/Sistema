<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Http\Request;

use App\Models\Inventario\Impuesto;


class ImpuestoController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 66, '', 'inv_impuesto'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Banco::consultarTodo.
     *
     * Consultar
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function Consultar(Request $request) {

        $objeto = Impuesto::ConsultarTodo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. self::$hs->verificationDatas.
     *       2. Cliente::ConsultarPorEmpTipIdeNomApe.
     *       3. Cliente::find.
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
            'nombre' => 'Debe digitar el nombre para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si no es actualización consultamos si existe
        if (!$id) {
            $existeRegistro = Impuesto::ConsultarPorNombre(
                $request,
                $idEmpresa,
                $request->get('nombre')
            );
        }
        else {
            $existeRegistro[] = Impuesto::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($existeRegistro)) {

            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $existeRegistro->count() && $existeRegistro[0]->estado > -1) {
                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $existeRegistro->count() && $existeRegistro[0]->estado < 0) {

                $clase = $this->insertarCampos(Impuesto::find($existeRegistro[0]->id), $request);

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

                $clase = $this->insertarCampos(new Impuesto(), $request);

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

        $clase->id_empresa  = $request->session()->get('idEmpresa');
        $clase->nombre      = $request->get('nombre');
        $clase->valor       = $request->get('valor');

        $request->get('id') ? null : $clase->estado = '1';

        return $clase;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Cliente::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function CambiarEstado(Request $request) {

        $clase  = Impuesto::Find((int)$request->get('id'));

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
     * @see: 1. Cliente::find.
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
        $clase = Impuesto::Find((int)$request->get('id'));

        $clase->estado = '-1';

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
    }
}