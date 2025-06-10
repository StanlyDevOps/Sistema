<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Parametrizacion\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Bodega extends Model
{
    public $timestamps = false;
    protected $table = "inv_bodega";

    const MODULO = 'Inventario';
    const MODELO = 'Bodega';

    # Belongs to
    public function localizaciones() {
        return $this->belongsTo(Locacion::class, 'id_bodega');
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

            return Bodega::select(
                DB::raw(
                    "IF(inv_bodega.id_municipio <> null OR inv_bodega.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = inv_bodega.id_municipio
                           ),
                          ''
                        ) AS ciudad,
                        inv_bodega.*
                    "
                )
            )
            ->whereRaw("   
                (
                    nombre LIKE '%$buscar%' OR
                    direccion LIKE '%$buscar%'
                )")
                ->where('estado','>','-1')
                ->where('id_empresa',$idEmpresa)
                ->orderBy('estado','desc')
                ->orderBy('ciudad')
                ->orderBy('nombre')
                ->orderBy('direccion')
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
     * @param string  $direccion:   Direccion.
     *
     * @return object
     */
    public static function ConsultarPorNombreDireccion($request, $idEmpresa, $nombre, $direccion) {
        try {
            return Bodega::where('id_empresa',$idEmpresa)
                ->where('nombre',$nombre)
                ->where('direccion',$direccion)
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
            return Bodega::where('id_empresa',$idCompany)
                ->where('estado', '1')
                ->orderBy('nombre')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindActive', $e, $data);
        }
    }
}