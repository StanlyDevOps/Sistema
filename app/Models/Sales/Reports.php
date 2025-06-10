<?php

namespace App\Models\Sales;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reports extends Model
{
    const MODULO = 'Sales';
    const MODELO = 'Reports';


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date_create: 2018/07/22 - 1:18 PM
     * @date_update: 0000-00-00 - 00:00 --
     *
     * Consult report daily collection
     *
     * @param object  $data:         Peticiones.
     * @param integer $idEmpresa:       ID empresa.
     * @param string  $fechaInicial:    Fecha inicial.
     * @param string  $fechaFinal:      Fecha final.
     *
     * @return object
     */
    public static function DailyCollection($data, $idCompany, $date)
    {
        try {
            return DB::select(
                "SELECT fecha_expedicion,
                        id_pedido           AS codigo_pedido,
                        codigo              AS codigo_factura,
                        cantidad            AS cantidad_items,
                        total,
                        total_impuesto,
                        total_general,
                        IF(efectivo IS NULL, 0, efectivo) AS pago_efectivo,
                        IF(
                            id_tipo_tarjeta IS NOT NULL,
                            total_general - IF(efectivo IS NULL, 0, efectivo),
                            0.0
                        )                   AS pago_tarjeta
                
                
                FROM ven_factura
                WHERE DATE_FORMAT(fecha_expedicion, '%Y-%m-%d') = '{$date}'
                AND id_empresa = {$idCompany}
                AND estado = '1'
                ORDER BY fecha_expedicion ASC"
            );

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'DailyCollection', $e, $data);
        }
    }
}