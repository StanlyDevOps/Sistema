<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Categoria;
use App\Models\Inventario\CategoriaOrden;
use Illuminate\Http\Request;

use App\Models\Inventario\Bodega;
use Illuminate\Support\Facades\Validator;


class CategoriaController extends Controller
{
    public static $hs;
    public static $transaccion;
    public static $CategoriaOrden;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$CategoriaOrden = new CategoriaOrdenController();
        self::$transaccion = ['', 65, '', 'inv_categoria'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 11:54 AM
     * @see: 1. Unidades::consultarTodo.
     *
     * Consultar
     *
     * @return object
     */
    public function Consult() {

        $data       = request();
        $idEmpresa  = $data->session()->get('idEmpresa');

        $categorias = Categoria::ConsultarTodo(
            $data,
            $idEmpresa
        );

        return collect([
            'resultado' => 1,
            'categorias' => $this->ConvertirJSONSimple($categorias),
            'orden' => self::$CategoriaOrden->Consult()->orden
        ]);
    }

    private function ConvertirJSONSimple($objecto) {
        $resultado = [];

        foreach ($objecto as $item) {
            $resultado[$item->id]['nombre'] = $item->nombre;
            $resultado[$item->id]['descripcion'] = $item->descripcion;
        }

        return $resultado;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-04-23 - 08:30 AM
     * @see: 1. self::$CategoriaOrden->Consult().
     *       2. self::$hs->ejecutarSave.
     *       3. self::$hs->mensajeActualizar
     *
     * Actualizar orden
     *
     * @return object
     */
    public function ActualizarOrden() {

        $data = request()->all();

        $categoriaOrden = self::$CategoriaOrden->Consult();

        $categoriaOrden->orden = $data['json'];

        self::$transaccion[0] = request();
        self::$transaccion[2] = 'actualizar';
        self::$transaccion[3] = 'inv_categoria_orden';

        return self::$hs->ejecutarSave(
            $categoriaOrden,
            self::$hs->mensajeActualizar,
            self::$transaccion
        );
    }


    /**
     * @autor: Jeremy Reyes B.
     *
     * Crea o actualiza los datos.
     *
     * @return object
     */
    public function CreateOrUpdate()
    {
        #0. Parameters
        $data = request()->all();
        $id   = $data['id'];
        $data['id_company'] = request()->session()->get('idEmpresa');

        #1. Verificación de los datos obligatorios con los enviados
        if($verifyData = $this->Validator($data)) {
            return $verifyData;
        };

        #2. Si no es actualización consultamos si existe
        if (!$id) {
            $registrationExists = Categoria::ConsultByName(
                request(),
                $data['id_company'],
                $data['name']
            );
        }
        else {
            $registrationExists[] = Categoria::find($id);
        }

        #3. Que no se encuentre ningun error
        if (!is_null($registrationExists)) {


            #3.1. Si existe, no esta eliminado y no es una actualización
            if (!$id && $registrationExists->count() && (int)$registrationExists[0]->estado > -1) {

                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. Esta eliminado o es una actualizacion lo vuelve a activar y actualiza todos sus datos
            elseif ($id || $registrationExists->count() && (int)$registrationExists[0]->estado < 0) {

                $class = $this->insertFields(Categoria::find($registrationExists[0]->id), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'actualizar';

                $result = self::$hs->ejecutarSave(
                    $class,
                    $id ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. Si no existe entonces se crea
            else {

                $class = $this->insertFields(new Categoria(), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                $result = self::$hs->ejecutarSave($class, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }

        #2.1 Create categoria_orden json
        if(!$id) {

            $id = isset($result->original['id']) ? $result->original['id'] : $registrationExists[0]->id;

            self::$CategoriaOrden->CreateOrUpdate([
                'id_empresa' => $data['id_company'],
                'id' => $id
            ]);
        }

        return $result;
    }

    /**
     * @autor: Jeremy Reyes B.
     *
     * Validador de campos.
     *
     * @return object
     */
    private function Validator($data) {

        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:255',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El nombre debe tener minimo de 3 caracteres',
            'name.max' => 'El nombre debe tener maximo de 50 caracteres'
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
     *
     * Insert fields campos.
     *
     * @param object  $class:   Objecto to fill.
     * @param request $data:    Requests.
     *
     * @return object
     */
    private function insertFields($class, $data) {

        $class->id_empresa   = $data['id_company'];
        $class->nombre       = $data['name'];
        $class->descripcion  = $data['description'];

        $data['id'] ? null : $class->estado = '1';

        return $class;
    }


    /**
     * @autor: Jeremy Reyes B.
     *
     * Cambia de estado.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function ChangeStatus(Request $request) {

        $class  = Categoria::Find((int)$request->get('id'));

        if ($class->estado === '1') {
            $class->estado = '0';
        }
        elseif ($class->estado === '0') {
            $class->estado = '1';
        }

        self::$transaccion[0] = $request;
        self::$transaccion[2] = self::$hs->estados[$class->estado];

        return self::$hs->ejecutarSave($class,self::$hs->mensajeEstado,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Destroy(Request $request)
    {
        self::$CategoriaOrden->Destroy($request->get('id'));

        $class = Categoria::Find((int)$request->get('id'));

        $class->estado = '-1';

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($class,self::$hs->mensajeEliminar,self::$transaccion);
    }
}