<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Impuesto extends Model
{
    public $timestamps = false;
    protected $table = "inv_impuesto";

    const MODULO = 'Inventario';
    const MODELO = 'Impuesto';

    # Belongs to
    public function productos() {
        return $this->belongsTo(Producto::class, 'id_impuesto');
    }

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 10:38 AM
     *
     * Consultar todos con paginación
     *
     * @param request   $request:     Peticiones realizadas.
     * @param string    $buscar:      Texto a buscar.
     * @param integer   $pagina:      Pagina actual.
     * @param integer   $tamanhio:    Tamaño de la pagina.
     * @param integer   $idEmpresa:   ID empresa.
     *
     * @return object
     */
    public static function ConsultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idEmpresa) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Impuesto::whereRaw("nombre like '%$buscar%'")
                ->where('estado','>','-1')
                ->where('id_empresa',$idEmpresa)
                ->orderBy('estado','desc')
                ->orderBy('nombre')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'consultarTodo', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-02-20 - 10:38 AM
     *
     * Consultar por tipo de empresa, identificacion, documento, nombres y apellidos
     *
     * @param request $request:     Peticiones realizadas.
     * @param string  $nombre:      Nombre.
     *
     * @return object
     */
    public static function ConsultarPorNombre($request, $idEmpresa, $nombre) {
        try {
            return Impuesto::where('id_empresa',$idEmpresa)
                ->where('nombre',$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorNombre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/07 - 8:27 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Find active
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     *
     * @return object
     */
    public static function FindActive($data, $idCompany) {
        try {
            return Impuesto::where('id_empresa',$idCompany)
                ->where('estado', '1')
                ->orderBy('nombre')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindActive', $e, $data);
        }
    }
}