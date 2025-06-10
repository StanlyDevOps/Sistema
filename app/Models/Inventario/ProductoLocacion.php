<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ProductoLocacion extends Model
{
    public $timestamps = false;
    protected $table = "inv_producto_locacion";

    const MODULO = 'Inventario';
    const MODELO = 'ProductoLocacion';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-05 - 08:24 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:      Request.
     * @param string    $toSearch:  Text to search.
     * @param integer   $page:      Real page.
     * @param integer   $size:      Size page.
     * @param integer   $idCompany: ID company.
     *
     * @return object
     */
    public static function ConsultAll($data, $toSearch = null, $page = 1, $size = 10) {
        try {
            $currentPage = $page;

            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return ProductoLocacion::select(
                'inv_producto_locacion.*',
                'inv_producto.nombre    AS producto',
                'inv_bodega.nombre      AS bodega'
            )
                ->join('inv_producto','inv_producto_locacion.id_producto','inv_producto.id')
                ->join('inv_locacion','inv_producto_locacion.id_locacion','inv_locacion.id')
                ->join('inv_bodega','inv_locacion.id_bodega','inv_bodega.id')
                ->where('inv_producto_locacion.estado','1')
                ->where('inv_locacion.estado','1')
                ->whereIn('inv_producto.estado',['0','1'])
                ->whereRaw("(
                    inv_producto.nombre LIKE '%$toSearch%' OR
                    inv_locacion.nombre LIKE '%$toSearch%'
                )")
                ->orderBy('inv_producto_locacion.estado','desc')
                ->orderBy('inv_producto_locacion.id')
                ->paginate($size);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultAll', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 04:25 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Find by producto and location
     *
     * @param object     $data:      Request.
     * @param integer   $product:   ID product.
     * @param integer   $location:  ID location.
     *
     * @return object
     */
    public static function FindByProductLocation($data, $product, $location) {
        try {
            return ProductoLocacion::where('id_producto', $product)
                ->where('id_locacion', $location)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByProductLocation', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 04:25 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Find by producto and location
     *
     * @param object    $data:     Request.
     * @param integer   $product:   ID product.
     * @param integer   $location:  ID location.
     *
     * @return object
     */
    public static function SumExistenceByProductLocation($data, $product, $location) {
        try {
            return ProductoLocacion::where('id_producto', '<>', $product)
                ->where('id_locacion', $location)
                ->where('estado','1')
                ->sum('existencia');

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindAvailableByProductLocation', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-05-01 - 04:25 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Sum existence by location
     *
     * @param object    $data:      Request.
     * @param integer   $location:  ID location.
     *
     * @return object
     */
    public static function ExistenceByLocation($data, $location) {
        try {
            return ProductoLocacion::where('id_locacion', $location)
                ->where('estado','1')
                ->sum('existencia');

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ExistenceByLocation', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/04 - 11:29 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Sum existence by location
     *
     * @param object    $data:      Request.
     * @param integer   $location:  ID location.
     *
     * @return object
     */
    public static function FindByID($data, $location) {
        try {
            return ProductoLocacion::select(
                'inv_producto.*',
                'inv_impuesto.valor  AS impuesto_valor',
                'inv_impuesto.nombre AS impuesto',
                'inv_unidades.unidad'
            )
                ->join('inv_producto', 'inv_producto_locacion.id_producto','inv_producto.id')
                ->join('inv_impuesto', 'inv_producto.id_impuesto', 'inv_impuesto.id')
                ->join('inv_unidades', 'inv_producto.id_unidades', 'inv_unidades.id')

                ->where('inv_producto_locacion.id', $location)
                ->first();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByID', $e, $data);
        }
    }
}