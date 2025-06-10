<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class OrdenCompra extends Model
{
    public $timestamps = false;
    protected $table = "inv_orden_compra";

    const MODULO = 'Inventario';
    const MODELO = 'OrdenCompra';

    # Belongs to
    public function detalles() {
        return $this->belongsTo(OrdenCompraDetalle::class, 'id_orden_compra');
    }

    #Has many
    public function locacion() {
        return $this->hasMany(Locacion::class, 'id_locacion');
    }
    public function contacto() {
        return $this->hasMany(Contacto::class, 'id_contacto');
    }
}