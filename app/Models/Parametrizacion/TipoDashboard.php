<?php

namespace App\Models\Parametrizacion;

use App\Http\Controllers\HerramientaStidsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TipoDashboard extends Model
{
    public $timestamps = false;
    protected $table = "s_tipo_dashboard_usuario";

    const MODULO = 'Parametrizacion';
    const MODELO = 'TipoDashboard';


    # Belongs to
    public function usuarios() {
        return $this->belongsTo(Usuario::class, 'id_tipo_dashboard_usuario');
    }
}