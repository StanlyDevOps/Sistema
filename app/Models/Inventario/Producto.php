<?php

namespace App\Models\Inventario;

use App\Http\Controllers\HerramientaStidsController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    public $timestamps = false;
    protected $table = "inv_producto";

    const MODULO = 'Inventario';
    const MODELO = 'Producto';

    public function ordenCompraDetalle() {
        return $this->hasMany(OrdenCompraDetalle::class, 'id_producto');
    }
    public function rel_MateriaPrima() {
        return $this->hasMany(ProductoMateriaPrima::class, 'id_producto');
    }

    public function impuesto() {
        return $this->belongsTo(Impuesto::class, 'id_impuesto');
    }
    public function unidad() {
        return $this->belongsTo(Unidades::class, 'id_unidades');
    }
    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 04:35 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:      Request.
     * @param string    $toSearch:  Text to search.
     * @param integer   $page:      Real page.
     * @param integer   $size:      Size page.
     * @param integer   $idCompany: ID company.
     *
     * @return object
     */
    public static function ConsultAll(
        $data,
        $toSearch = null,
        $page = 1,
        $size = 10,
        $idCompany,
        $idCategory = null,
        $idTax = null,
        $idUnity = null,
        $idLocation = null,
        $idCeller = null
    ) {
        try {
            $currentPage = $page;

            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            $product = Producto::select(
            # Transaction date
                DB::raw('MAX(s_transacciones.fecha_alteracion) AS fecha_alteracion'),

                # Products
                'inv_producto.id_categoria',
                'inv_producto.id_impuesto',
                'inv_producto.id_unidades',
                'inv_producto.id',
                'inv_producto.nombre',
                'inv_producto.referencia',
                'inv_producto.valor',
                'inv_producto.descripcion',
                'inv_producto.imagen',
                'inv_producto.estado',

                # Product location
                'inv_producto_locacion.existencia AS existence',
                'inv_producto_locacion.id         AS id_product_location',
                'inv_producto_locacion.estado     AS status_product_location',
                'inv_producto_locacion.stock_max',
                'inv_producto_locacion.stock_min',
                'inv_producto_locacion.id_locacion',

                # Location
                'inv_locacion.nombre        AS locacion',
                'inv_locacion.descripcion   AS locacion_descripcion',
                'inv_locacion.existencia',

                # Cellar
                'inv_bodega.nombre          AS bodega',
                'inv_bodega.descripcion     AS bodega_descripcion',
                'inv_bodega.direccion       AS bodega_direccion',

                # Tax
                'inv_impuesto.nombre        AS impuesto',
                'inv_impuesto.valor         AS impuesto_valor',

                # Unit
                'inv_unidades.unidad        AS unidad',
                'inv_unidades.descripcion   AS unidad_descripcion',

                # Category
                'inv_categoria.nombre   AS categoria',
                'inv_categoria.descripcion   AS categoria_descripcion'
            )

                ->join('s_transacciones','inv_producto.id','s_transacciones.id_alterado')
                ->join('inv_categoria','inv_producto.id_categoria','inv_categoria.id')
                ->join('inv_impuesto','inv_producto.id_impuesto','inv_impuesto.id')
                ->join('inv_unidades','inv_producto.id_unidades','inv_unidades.id')
                ->leftJoin('inv_producto_locacion','inv_producto_locacion.id_producto','inv_producto.id')
                ->leftJoin('inv_locacion','inv_producto_locacion.id_locacion','inv_locacion.id')
                ->leftJoin('inv_bodega','inv_locacion.id_bodega','inv_bodega.id')

                ->whereIn('inv_producto.estado',['0','1'])

                /*
                ->where(function($query){
                    $query->whereNull('inv_producto_locacion.estado')
                        ->orWhere('inv_producto_locacion.estado','1');
                })
                */

                ->whereRaw("(
                    inv_producto.nombre LIKE '%$toSearch%' OR
                    inv_producto.referencia LIKE '%$toSearch%' OR
                    inv_producto.valor LIKE '%$toSearch%'
                )")

                ->where('inv_producto.id_empresa',$idCompany)
                ->where('s_transacciones.nombre_tabla','inv_producto')

                ->whereIn('s_transacciones.id_permiso',[1,3])

                ->groupBy([
                    'inv_producto.id',
                    'inv_producto.id_categoria',
                    'inv_producto.id_impuesto',
                    'inv_producto.id_unidades',
                    'inv_producto.nombre',
                    'inv_producto.referencia',
                    'inv_producto.valor',
                    'inv_producto.descripcion',
                    'inv_producto.imagen',
                    'inv_producto.estado',
                    'inv_producto_locacion.existencia',
                    'inv_producto_locacion.id',
                    'inv_producto_locacion.estado',
                    'inv_producto_locacion.stock_max',
                    'inv_producto_locacion.stock_min',
                    'inv_producto_locacion.id_locacion',
                    'inv_locacion.nombre',
                    'inv_locacion.descripcion',
                    'inv_locacion.existencia',
                    'inv_bodega.nombre',
                    'inv_bodega.descripcion',
                    'inv_bodega.direccion',
                    'inv_impuesto.valor',
                    'inv_unidades.unidad',
                    'inv_unidades.descripcion',
                    'inv_categoria.nombre',
                    'inv_impuesto.nombre',
                    'inv_categoria.descripcion'
                ])

                ->orderBy('inv_producto.estado','desc')
                ->orderBy('inv_producto.nombre')
                ->orderBy('inv_producto_locacion.estado','desc');

            if ($idCategory) {
                $product->where('inv_producto.id_categoria', $idCategory);
            }

            if ($idTax) {
                $product->where('inv_producto.id_impuesto', $idTax);
            }

            if ($idUnity) {
                $product->where('inv_producto.id_unidades', $idUnity);
            }

            if ($idLocation) {
                $product->where('inv_locacion.id', $idLocation);
            }

            if ($idCeller) {
                $product->where('inv_bodega.id', $idCeller);
            }

            return $product->paginate($size);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultAll', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018/06/04 - 8:11 AM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:      Request.
     * @param integer   $idCompany: ID company.
     *
     * @return object
     */
    public static function GetForSelect($data, $idCompany) {
        try {
            return DB::select("
                SELECT  DISTINCT 
                      pl.id AS id,
                      CONCAT('(', b.nombre, '). ', c.nombre ,' - ', p.nombre) AS nombre
                
                FROM inv_producto p
                INNER JOIN inv_producto_locacion pl  ON p.id = pl.id_producto
                INNER JOIN inv_locacion l            ON l.id = pl.id_locacion
                INNER JOIN inv_bodega b              ON l.id_bodega = b.id
                INNER JOIN inv_categoria c           ON c.id = p.id_categoria
                
                WHERE p.estado = '1'
                AND b.estado = '1'
                AND pl.estado = '1'
                AND p.id_empresa = {$idCompany}
                
                ORDER BY b.nombre,
                         c.nombre,
                         p.nombre
            ");

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultAll', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 06:35 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Find by ID
     *
     * @param object    $data:  Request.
     * @param integer   $id:    ID company.
     *
     * @return object
     */
    public static function FindByID($data, $id) {
        try {
            $product = Producto::find($data['id']);

            $product->tax       = $product->impuesto()->first();
            $product->unit      = $product->unidad()->first();
            $product->category  = $product->categoria()->first();
            //$product->location  = $product->localizaciones()->first();
            //$product->cell      = $product->localizaciones()->first()->bodega()->first();

            return $product;

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByID', $e, $data);
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date_create: 2018-04-28 - 04:35 PM
     * @date_update: 0000-00-00 - 00:00 --
     * @see: 1. Paginator::currentPageResolver.
     *       2. $hs->Log.
     *
     * Consult all paged
     *
     * @param object    $data:          Request.
     * @param integer   $idCompany:     ID company.
     * @param integer   $idCategory:    ID category.
     * @param integer   $idTax:         ID tax.
     * @param string    $name:          Product name.
     * @param string    $reference:     Product reference.
     *
     * @return object
     */
    public static function FindByComCatTaxNamRef($data, $idCompany, $idCategory, $idTax, $name, $reference) {
        try {
            return Producto::where('id_empresa',$idCompany)
                ->where('id_categoria', $idCategory)
                ->where('id_impuesto', $idTax)
                ->where('nombre', $name)
                ->where('referencia', $reference)
                ->get();

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'FindByComCatTaxNamRef', $e, $data);
        }
    }
}