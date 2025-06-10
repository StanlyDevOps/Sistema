<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CategoriaOrden extends Model
{
    public $timestamps = false;
    protected $table = "inv_categoria_orden";

    const MODULO = 'Inventario';
    const MODELO = 'CategoriaOrden';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     *
     * Consultar todo
     *
     * @param request   $request:     Peticiones realizadas.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultAll($request, $idEmpresa) {
        try {
            return CategoriaOrden::where('id_empresa',$idEmpresa)->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodo', $e, $request);
        }
    }
}