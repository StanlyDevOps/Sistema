<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class OrdenCompraDetalle extends Model
{
    public $timestamps = false;
    protected $table = "inv_orden_compra_detalle";

    const MODULO = 'Inventario';
    const MODELO = 'OrdeCompraDetalle';

    #Has many
    public function ordenCompra() {
        return $this->hasMany(OrdenCompra::class, 'id_orden_compra');
    }
    public function producto() {
        return $this->hasMany(Producto::class, 'id_producto');
    }
}