<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TipoContacto extends Model
{
    public $timestamps = false;
    protected $table = "inv_tipo_contacto";

    const MODULO = 'Inventario';
    const MODELO = 'TipoContacto';

    # Belongs to
    public function contactos() {
        return $this->belongsTo(Contacto::class, 'id_tipo_contacto');
    }
}