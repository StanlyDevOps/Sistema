<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class TypeCard extends Model
{
    public $timestamps = false;
    protected $table = "s_tipo_tarjeta";

    const MODULO = 'Parametrizacion';
    const MODELO = 'TypeCard';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/11 - 9:46 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Get all registers
     *
     * @param object    $data:      Request.
     * @param integer   $idCompany: ID company.
     *
     * @return object
     */
    public static function FindAll($data) {
        try {
            return self::where('estado','1')
                ->orderBy('nombre')
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindAll', $e, $data);
        }
    }
}