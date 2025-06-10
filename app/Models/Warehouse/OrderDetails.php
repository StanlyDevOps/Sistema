<?php

namespace App\Models\Warehouse;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class OrderDetails extends Model
{
    public $timestamps = false;
    protected $table = "alm_pedido_detalle";

    const MODULO = 'Warehouse';
    const MODELO = 'OrderDetails';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/26 - 7:16 AM
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
    public static function ConsultAll(
        $data,
        $toSearch = null,
        $page = 1,
        $size = 10,
        $idCompany
    ) {
        try {
            $currentPage = $page;

            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Table::whereIn('estado',['0','1'])
                ->whereRaw("(
                    nombre LIKE '%$toSearch%' OR
                    descripcion LIKE '%$toSearch%'
                )")

                ->where('id_empresa',$idCompany)

                ->orderBy('estado','desc')
                ->orderBy('nombre')
                ->paginate($size);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultAll', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/04 - 1:11 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     * @param string    $name:          Product name.
     *
     * @return object
     */
    public static function FindByOrder($data, $idOrder) {
        try {
            return OrderDetails::where('id_pedido',$idOrder)->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByOrder', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/04 - 1:11 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Remove transaction to db
     *
     * @param object  $data:    Request.
     * @param integer $idOrder: ID order
     *
     * @return integer
     */
    public static function RemoveByOrder($data, $idOrder) {
        try {
            return OrderDetails::where('id_pedido', $idOrder)->delete() ? 1 : 0;
        }
        catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return (int)$hs->Log(self::MODULO,self::MODELO,'EliminarPorId', $e, $data);
        }
    }
}