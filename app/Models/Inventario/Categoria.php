<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table = "inv_categoria";

    const MODULO = 'Inventario';
    const MODELO = 'Categoria';

    # Belongs to
    public function productos() {
        return $this->belongsTo(Producto::class, 'id_categoria');
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     *
     * Consultar padres
     *
     * @param request   $request:     Peticiones realizadas.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultarTodo($request, $idEmpresa) {
        try {
            return Categoria::where('estado','>','-1')
                ->where('id_empresa',$idEmpresa)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPadre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     *
     * Consult by company and name
     *
     * @param array     $data
     * @param integer   $idCompany
     * @param string    $name
     *
     * @return object
     */
    public static function ConsultByName($data, $idCompany, $name) {
        try {
            return Categoria::where('id_empresa',$idCompany)
                ->where('nombre',$name)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultByName', $e, $data);
        }
    }
}