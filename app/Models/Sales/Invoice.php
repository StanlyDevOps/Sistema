<?php

namespace App\Models\Sales;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    public $timestamps = false;
    protected $table = "ven_factura";

    const MODULO = 'Sales';
    const MODELO = 'Invoice';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/10 - 12:13 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:      Request.
     * @param ?string   $toSearch:  Text to search.
     * @param integer   $page:      Real page.
     * @param integer   $size:      Size page.
     * @param integer   $idCompany: ID company.
     *
     * @return ?object
     */
    public static function ConsultAll(
        $data,
        $toSearch = '',
        $page = 1,
        $size = 10,
        $idCompany
    ) {
        try {
            $currentPage = $page;

            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Invoice::select(
                'ven_factura.*',
                DB::raw('(
                    SELECT nombre
                    FROM s_tipo_tarjeta
                    WHERE id = ven_factura.id_tipo_tarjeta
                    LIMIT 1
                ) AS tarjeta')
            )
                ->where('ven_factura.id_empresa',$idCompany)
                ->where('ven_factura.estado','1')
                ->whereRaw("(
                    ven_factura.codigo LIKE '%$toSearch%' OR
                    ven_factura.anhio LIKE '%$toSearch%' OR
                    ven_factura.comentarios LIKE '%$toSearch%' OR
                    ven_factura.fecha_expedicion LIKE '%$toSearch%'
                )")
                ->orderBy('ven_factura.codigo', 'desc')
                ->paginate($size);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultAll', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/05/26 - 7:48 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     * @param string    $name:          Product name.
     *
     * @return object
     */
    public static function FindByName($data, $idCompany, $name) {
        try {
            return Table::where('id_empresa',$idCompany)
                ->where('nombre', $name)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByName', $e, $data);
        }
    }
}