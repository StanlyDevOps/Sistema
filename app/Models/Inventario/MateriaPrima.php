<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class MateriaPrima extends Model
{
    public $timestamps = false;
    protected $table = "inv_materia_prima";

    const MODULO = 'Inventario';
    const MODELO = 'MateriaPrima';

    # Belongs to
    public function rel_Producto() {
        return $this->belongsTo(ProductoMateriaPrima::class, 'id_materia_prima');
    }
}