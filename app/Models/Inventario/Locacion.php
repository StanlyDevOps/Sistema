<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Locacion extends Model
{
    public $timestamps = false;
    protected $table = "inv_locacion";

    const MODULO = 'Inventario';
    const MODELO = 'Locacion';


    public function ordenesCompra() {
        return $this->hasMany(OrdenCompra::class, 'id_locacion');
    }


    public function bodega() {
        return $this->belongsTo(Bodega::class, 'id_bodega');
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
     * @param integer   $idBodega:    ID bodega.
     *
     * @return object
     */
    public static function ConsultarTodo($request, $buscar = null, $pagina = 1, $tamanhio = 10, $idBodega) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Locacion::whereRaw("nombre LIKE '%$buscar%'")
                ->where('estado','>','-1')
                ->where('id_bodega',$idBodega)
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
     * @param string  $direccion:   Direccion.
     * @param string  $idBodega:    Bodega.
     *
     * @return object
     */
    public static function ConsultarPorBodegaNombre($request, $idBodega, $nombre) {
        try {
            return Locacion::where('id_bodega',$idBodega)
                ->where('nombre',$nombre)
                ->get();
        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarPorBodegaNombre', $e, $request);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/07 - 8:50 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Find active
     *
     * @param object    $data:      Request.
     * @param integer   $idCeller:  ID celler.
     *
     * @return object
     */
    public static function FindActive($data, $idCeller) {
        try {
            return Locacion::where('id_bodega', $idCeller)
                ->where('estado', '1')
                ->orderBy('nombre')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindActive', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/07 - 8:50 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Find active
     *
     * @param object    $data:      Request.
     * @param integer   $idCeller:  ID celler.
     *
     * @return object
     */
    public static function FindAvaliableByCeller($data, $search = null, $page = 1, $size = 10, $idCeller) {
        try {
            $currentPage = $page;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Locacion::select(
                'inv_locacion.id',
                'inv_locacion.nombre',
                'inv_locacion.stock_max',
                DB::raw(
                    "IF(
                        SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0)) IS NULL,
                         0,
                         SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0))
                    )
                    AS usado"
                ),
                DB::raw(
                    "IF(
                        inv_locacion.stock_max - SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0)) IS NULL,
                        inv_locacion.stock_max,
                        inv_locacion.stock_max - SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0))
                    )
                    AS disponible"
                )
            )
                ->leftJoin('inv_producto_locacion', 'inv_locacion.id', 'inv_producto_locacion.id_locacion')
                ->whereRaw("inv_locacion.nombre LIKE '%$search%'")
                ->where('inv_locacion.id_bodega', $idCeller)
                ->where('inv_locacion.estado','1')

                ->orderBy('inv_locacion.nombre')

                ->groupBy([
                    'inv_locacion.id',
                    'inv_locacion.nombre',
                    'inv_locacion.stock_max'
                ])

                ->havingRaw(
                    "IF(
                        inv_locacion.stock_max - SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0)) IS NULL,
                        inv_locacion.stock_max,
                        inv_locacion.stock_max - SUM(IF(inv_producto_locacion.estado = '1', inv_producto_locacion.stock_max, 0))
                    ) > 0"
                )

                ->paginate($size);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindAvaliableByCeller', $e, $data);
        }
    }
}