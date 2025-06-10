<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ProductoMateriaPrima extends Model
{
    public $timestamps = false;
    protected $table = "inv_producto_materia_prima";

    const MODULO = 'Inventario';
    const MODELO = 'ProductoMateriaPrima';

    #Has many
    public function producto() {
        return $this->hasMany(Producto::class, 'id_producto');
    }
    public function materiaPrima() {
        return $this->hasMany(MateriaPrima::class, 'id_materia_prima');
    }
}