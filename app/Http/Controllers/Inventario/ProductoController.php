<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Bodega;
use App\Models\Inventario\Impuesto;
use App\Models\Inventario\Producto;
use App\Models\Inventario\Unidades;
use Illuminate\Support\Facades\Validator;


class ProductoController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 53, '', 'inv_producto'];
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-02-28 - 11:54 AM
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

        $object = Producto::ConsultAll(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio'],
            $data['id_company']
        );

        if (!is_null($object)) {

            $object = $object->toArray();

            $object['tax']    = Impuesto::FindActive(request(),$data['id_company']);
            $object['unity']  = Unidades::FindActive(request(),$data['id_company']);
            $object['celler'] = Bodega::FindActive(request(),$data['id_company']);
        }

        return is_null($object) ? (object)self::$hs->jsonError : $object;
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/05 - 1:31 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Producto::AvancedConsultationAll.
     *
     * Consult
     *
     * @param array $data: Parameters (buscador, pagina, tamanhio, id_company).
     *
     * @return object
     */
    public function AvancedConsultation($data = null) {

        if (!is_array($data)) {
            $data = request()->all();
            $data['id_company'] = request()->session()->get('idEmpresa');
        }

        $object = Producto::ConsultAll(
            request(),
            $data['buscador'],
            $data['pagina'],
            $data['tamanhio'],
            $data['id_company'],
            $data['id_category'],
            $data['id_tax'],
            $data['id_unity'],
            $data['id_location'],
            $data['id_celler']
        );

        return is_null($object) ? (object)self::$hs->jsonError : $object;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 06:44 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Producto::FindByID.
     *
     * Consult
     *
     * @param array $data: Parameters (id, id_company).
     *
     * @return object
     */
    public function FindByID($data = null) {

        $data = !is_array($data) ? request()->all() : '';

        $objet = Producto::FindByID(request(), $data['id']);

        return is_null($objet) ? (object)self::$hs->jsonError : $objet;
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

        $class = Producto::Find($data['id']);

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

        $class = Producto::Find($data['id']);

        $class->estado = '-1';

        self::$transaccion[0] = request();
        self::$transaccion[2] = 'eliminar';

        return self::$hs->Save($class,self::$hs->mensajeEliminar,self::$transaccion);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/05 - 12:56 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Producto::Find.
     *       2. self::$hs->UploadFile.
     *       3. self::$hs->Save.
     *
     * Update image
     *
     * @param array $data: Parameters.
     *
     * @return array
     */
    public function UpdateImage($data = null)
    {
        $class = Producto::Find(request()->all()['id']);

        $file = self::$hs->UploadFile(
            self::$hs->imagesPR . '/inventory/products',
            $class->imagen
        );

        if (is_null($file)) {
            return self::$hs->jsonError;
        }
        else {
            $class->imagen = $file;

            self::$transaccion[0] = request();
            self::$transaccion[2] = 'actualizar';

            return self::$hs->Save($class,self::$hs->mensajeActualizar,self::$transaccion);
        }
    }


    public function CreateOrUpdate()
    {
        $data = request();

        #0. Parameters
        $data = request()->all();
        $data['id_company'] = request()->session()->get('idEmpresa');


        #1. Data verification
        if($verifyData = $this->DataVerification($data)) {
            return $verifyData;
        };

        #2. If it's not update then find if exists
        if (!$data['id']) {

            $registrationExists = Producto::FindByComCatTaxNamRef(
                request(),
                $data['id_company'],
                $data['id_category'],
                $data['id_tax'],
                $data['name'],
                $data['reference']
            );
        }
        else {
            $registrationExists[] = Producto::find($data['id']);
        }


        #3. If you do not find any error
        if (!is_null($registrationExists)) {

            #3.1. If it exists, it is not deleted and it is not an update
            if (!$data['id'] && $registrationExists->count() && (int)$registrationExists[0]->estado > -1) {

                return response()->json(self::$hs->jsonExiste);
            }
            #3.2. If it's eliminated or it's a update, change status and it update data
            elseif ($data['id'] || $registrationExists->count() && (int)$registrationExists[0]->estado < 0) {

                $class = $this->insertFields(Producto::find($registrationExists[0]->id), $data);

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

                $class = $this->insertFields(new Producto(), $data);

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
     * @date_create: 2018/05/05 - 12:55 PM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Validador de campos.
     *
     * @return object
     */
    private function DataVerification($data) {

        $validator = Validator::make($data, [
            'id_category' => 'required|integer',
            'id_tax' => 'required|integer',
            'id_unity' => 'required|integer',
            'name' => 'required|string|min:3|max:100',
            'reference' => 'required|string|min:1|max:20',
            'value' => 'required|numeric|between:0,9999999999.99',
        ], [
            'id_category.required' => 'El campo Categoria es requerido',
            'id_category.integer' => 'El campo Categoria debe ser númerico',

            'id_tax.required' => 'El campo Impuesto es requerido',
            'id_tax.integer' => 'El campo Impuesto debe ser númerico',

            'id_unity.required' => 'El campo Unidad es requerido',
            'id_unity.integer' => 'El campo Unidad debe ser númerico',

            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El nombre debe tener minimo de :min caracteres',
            'name.max' => 'El nombre debe tener maximo de :max caracteres',

            'reference.required' => 'El campo Referencia es requerido',
            'reference.min' => 'El Referencia debe tener minimo de :min caracteres',
            'reference.max' => 'El Referencia debe tener maximo de :max caracteres',

            'value.required' => 'El campo Valor es requerido',
            'value.numeric' => 'El Valor debe ser númerico',
            'value.between' => 'El Valor digitado es muy extenso'
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
        $class->id_categoria    = $data['id_category'];
        $class->id_impuesto     = $data['id_tax'];
        $class->id_unidades     = $data['id_unity'];
        $class->nombre          = $data['name'];
        $class->referencia      = $data['reference'];
        $class->valor           = $data['value'];
        $class->descripcion     = $data['description'];



        $data['id'] ? null : $class->estado = '1';

        return $class;
    }
}