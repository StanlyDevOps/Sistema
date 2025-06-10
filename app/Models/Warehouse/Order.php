<?php

namespace App\Models\Warehouse;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public $timestamps = false;
    protected $table = "alm_pedido";

    const MODULO = 'Warehouse';
    const MODELO = 'Order';


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
    public static function ConsultAll($data, $toSearch = null, $page = 1, $size = 10, $idCompany) {
        try {
            $currentPage = $page;

            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Order::select(
                'alm_pedido.*',
                'alm_pedido.anhio                        AS año',
                'alm_mesa.nombre                         AS mesa',
                'alm_pedido.descripcion',
                'v_transactions_created.usuario          As usuario_creador',
                'v_transactions_created.nombres',
                'v_transactions_created.apellidos',
                'v_transactions_created.fecha_alteracion AS fecha_creacion',
                's_empresa.nombre                        AS empresa',
                's_sucursal.direccion',
                's_sucursal.telefono',

                DB::raw(
                    '(
                        SELECT COUNT(pd.id)
                        FROM alm_pedido_detalle pd
                        WHERE alm_pedido.id = pd.id_pedido   
                    ) AS cantidad'
                ),

                DB::raw(
                    "IF(s_sucursal.id_municipio <> null OR s_sucursal.id_municipio <> '',
                           (
                              SELECT CONCAT(sp.nombre,', ',sd.nombre,', ',sm.nombre)
                              FROM s_municipio sm
                              INNER JOIN s_departamento sd ON sd.id = sm.id_departamento
                              INNER JOIN s_pais         sp ON sp.id = sd.id_pais
                              WHERE sm.id = s_sucursal.id_municipio
                           ),
                          ''
                        ) AS ciudad
                    "
                )
            )

                ->leftJoin('alm_mesa', function($lj){
                    $lj->on('alm_pedido.id_mesa','alm_mesa.id')
                        ->whereIn('alm_mesa.estado',['1','0']);
                })

                ->leftJoin('v_transactions_created', function($lj) {
                    $lj->on('alm_pedido.id','v_transactions_created.id_alterado')
                        ->where('v_transactions_created.nombre_tabla','alm_pedido');
                })

                ->join('s_empresa','alm_pedido.id_empresa','s_empresa.id')
                ->join('s_sucursal','s_empresa.id','s_sucursal.id_empresa')

                ->whereIn('alm_pedido.estado',['0','1'])
                ->whereRaw("(
                    alm_pedido.codigo LIKE '%$toSearch%' OR
                    alm_mesa.nombre LIKE '%$toSearch%' OR
                    alm_pedido.descripcion LIKE '%$toSearch%' OR
                    v_transactions_created.usuario LIKE '%$toSearch%'
                )")

                ->where('alm_pedido.id_empresa',$idCompany)

                ->orderBy('alm_pedido.estado', 'desc')
                ->orderBy('alm_pedido.codigo', 'desc')
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
     * Consult all unipaid orders
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     *
     * @return object
     */
    public static function FindAllUnipaid($data, $idCompany) {
        try {
            return self::select(
                'alm_pedido.id',
                DB::raw("
                    CONCAT(alm_pedido.codigo, IF(alm_mesa.nombre IS NULL, '', CONCAT(' - ', alm_mesa.nombre))) AS nombre
                "),
                DB::raw("(
                    SELECT SUM(d.total_general)
                    FROM alm_pedido_detalle d 
                    WHERE d.id_pedido = alm_pedido.id
                ) AS total")
            )
                ->leftJoin('alm_mesa','alm_pedido.id_mesa','alm_mesa.id')

                ->where('alm_pedido.id_empresa',$idCompany)
                ->where('alm_pedido.estado','1')
                ->whereRaw(
                    "alm_pedido.id NOT IN(
                        SELECT id_pedido
                        FROM ven_factura
                        WHERE estado = '1'
                    )"
                )
                ->orderBy('alm_pedido.codigo', 'desc')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindAllUnipaid', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/07/22 - 9:27 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all unipaid orders
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     *
     * @return object
     */
    public static function lastCodeByCompany($data, $idCompany) {
        try {
            return self::all()
                ->where('id_empresa', $idCompany)
                ->max('codigo') + 1;

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindAllUnipaid', $e, $data);
        }
    }
}