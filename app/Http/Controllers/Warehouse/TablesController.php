<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Warehouse\Table;
use Illuminate\Support\Facades\Validator;


class TablesController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 58, '', 'alm_mesa'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/26 - 7:15 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Producto::ConsultAll.
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

        $object = Table::ConsultAll(
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
     * Change status.
     *
     * @param array $data: Parameters (id).
     *
     * @return object
     */
    public function ChangeStatus($data = null) {

        $data = !is_array($data) ? request()->all() : '';

        $class = Table::Find($data['id']);

        if ($class->estado === '1') {
            $class->estado = '0';
        }
        elseif ($class->estado === '0') {
            $class->estado = '1';
        }

        self::$transaccion[0] = request();
        self::$transaccion[2] = self::$hs->estados[$class->estado];

        return self::$hs->Save($class,self::$hs->mensajeEstado,self::$transaccion);
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
     * @date_create: 2018/05/26 - 7:32 AM
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

            $registrationExists = Table::FindByName(
                request(),
                $data['id_company'],
                $data['name']
            );
        }
        else {
            $registrationExists[] = Table::find($data['id']);
        }


        #3. If you do not find any error
        if (!is_null($registrationExists)) {

            #3.1. If it exists, it is not deleted and it is not an update
            if (!$data['id'] && $registrationExists->count() && (int)$registrationExists[0]->estado > -1) {

                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. If it's eliminated or it's a update, change status and it update data
            elseif ($data['id'] || $registrationExists->count() && (int)$registrationExists[0]->estado < 0) {

                $class = $this->insertFields(Table::find($registrationExists[0]->id), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'actualizar';

                return self::$hs->Save(
                    $class,
                    $data['id'] ? self::$hs->mensajeActualizar : self::$hs->mensajeGuardar,
                    self::$transaccion
                );
            }
            #3.3. If it doesn't exist, we create the transaction
            else {

                $class = $this->insertFields(new Table(), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                return self::$hs->Save($class, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {
            return response()->json(self::$hs->jsonError);
        }
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
            'name' => 'required|string|min:3|max:100',
        ], [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El nombre debe tener minimo de :min caracteres',
            'name.max' => 'El nombre debe tener maximo de :max caracteres'
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

        $class->id_empresa      = $data['id_company'];
        $class->nombre          = $data['name'];
        $class->descripcion     = $data['description'];

        $data['id'] ? null : $class->estado = '1';

        return $class;
    }
}