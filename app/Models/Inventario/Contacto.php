<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Contacto extends Model
{
    public $timestamps = false;
    protected $table = "inv_contacto";

    const MODULO = 'Inventario';
    const MODELO = 'Contacto';

    # Belongs to
    public function ordenesCompra() {
        return $this->belongsTo(OrdenCompra::class, 'id_contacto');
    }

    #Has many
    public function tipoContacto() {
        return $this->hasMany(TipoContacto::class, 'id_tipo_contacto');
    }
}