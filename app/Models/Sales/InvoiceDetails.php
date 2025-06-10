<?php

namespace App\Models\Sales;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class InvoiceDetails extends Model
{
    public $timestamps = false;
    protected $table = "ven_factura_detalle";

    const MODULO = 'Sales';
    const MODELO = 'InvoiceDetails';
}