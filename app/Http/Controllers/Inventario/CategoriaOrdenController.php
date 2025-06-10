<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Inventario\Categoria;
use App\Models\Inventario\CategoriaOrden;
use Illuminate\Http\Request;

use App\Models\Inventario\Bodega;
use Illuminate\Support\Facades\Validator;


class CategoriaOrdenController extends Controller
{
    public static $hs;
    public static $transaccion;


    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 65, '', 'inv_categoria_orden'];
    }


    public function Consult($idEmpresa = null) {

        $idEmpresa = is_integer($idEmpresa) ?
            $idEmpresa
                :
            request()->session()->get('idEmpresa')
        ;

        $orden = CategoriaOrden::ConsultAll(
            request(),
            $idEmpresa
        );

        return $orden->first();
    }


    /**
     * @autor: Jeremy Reyes B.
     *
     * Create or update this model
     *
     * @param array $data: ['id_empresa' => (int), 'orden' => (string)];
     *
     * @return object
     */
    public function CreateOrUpdate($data = null)
    {
        #0. Parameters
        if (!isset($data['id_empresa'])) {
            $data = request()->all();
            $data['id_empresa'] = request()->session()->get('idEmpresa');

            #1. Verificación de los datos obligatorios con los enviados
            if($verifyData = $this->Validator($data)) {
                return $verifyData;
            };

            #2. Si no es actualización consultamos si existe
            $registrationExists = $this->Consult((int)$data['id_empresa']);

            #3. Si existe registro se actualiza
            if (!is_null($registrationExists)) {

                $class = $this->insertFields($registrationExists, $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'actualizar';

                return self::$hs->Save($class, self::$hs->mensajeActualizar, self::$transaccion);
            }
            #4. Si no existe registro se crea
            else {

                $class = $this->insertFields(new CategoriaOrden(), $data);

                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                return self::$hs->Save($class, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
        else {

            if ($data['id']) {

                $registrationExists = $this->Consult((int)$data['id_empresa']);

                if ((isset($registrationExists->orden) && $registrationExists->orden === '[]') || !isset($registrationExists->orden)) {

                    $registrationExists = new CategoriaOrden();

                    $registrationExists->id_empresa = (int)$data['id_empresa'];
                    $registrationExists->orden = '[{"id":' . $data['id'] . '}]';
                }
                else {
                    $registrationExists->orden = substr($registrationExists->orden, 0, -1) . ',{"id":' . $data['id'] . '}]';
                }


                self::$transaccion[0] = request();
                self::$transaccion[2] = 'crear';

                return self::$hs->Save($registrationExists, self::$hs->mensajeGuardar, self::$transaccion);
            }
        }
    }


    private function Validator($data) {

        $validator = Validator::make($data, [
            'orden' => 'string|max:1000',
        ], [
            'orden.max' => 'Se ha excedido del tamaño maximo de ordenamiento'
        ]);

        if ($validator->fails()) {

            return collect([
                'resultado' => 0,
                'titulo' => 'Advertencia',
                'mensaje' => $validator->messages()->first()
            ]);
        }

        return null;
    }


    private function insertFields($class, $data) {

        $class->id_empresa   = $data['id_empresa'];
        $class->orden        = $data['orden'];

        return $class;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 11:56 AM
     * @date_modify: 0000-00-00 - 00:00 --
     * @see: 1. $this->Consult.
     *
     * Delete an ID inside JSON
     *
     * @return object
     */
    public function Destroy($id = null) {

        if ($id) {

            $categoryOrder = $this->Consult();

            #1. First replace - normal value
            $replace = str_replace('{"id":' . $id . '}','', $categoryOrder->orden);

            #2. First replace - Father
            $replace = str_replace('{"id":' . $id . ',','', $replace);

            #2. First replace - init commas in array
            $replace = str_replace('[,','[', $replace);

            #2. First replace - end commas in array
            $replace = str_replace(',]',']', $replace);

            #3. First replace - double commas
            $replace = str_replace(',,',',', $replace);

            #3. First replace - array of childrens
            $replace = str_replace('["','[{"', $replace);

            #3. First replace - position initial
            $categoryOrder->orden = str_replace('["children":[]},','[', $replace);

            self::$transaccion[0] = request();
            self::$transaccion[2] = 'actualizar';

            return self::$hs->Save($categoryOrder, self::$hs->mensajeActualizar, self::$transaccion);
        }
    }
}