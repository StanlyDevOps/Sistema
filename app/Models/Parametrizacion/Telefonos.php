<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Telefonos extends Model
{
    public $timestamps = false;
    protected $table = "s_telefono";

    const MODULO = 'Parametrizacion';
    const MODELO = 'Telefonos';


    # Belongs to
    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
}