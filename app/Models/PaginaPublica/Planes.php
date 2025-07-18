<?php

namespace App\Models\PaginaPublica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

use App\Models\PaginaPublica\PlanesCaracteristicas;

class Planes extends Model
{
    public $timestamps = false;
    protected $table = "s_planes";

    public static function consultarTodo($buscar,$pagina,$tamanhioPagina) {
        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return Planes::whereRaw(
                "( nombre like '%$buscar%'
                OR valor like '%$buscar%')")
                ->orderBy('id','desc')
                ->paginate($tamanhioPagina);

        } catch (Exception $e) {
            return array();
        }
    }


    public static function eliminarPorId($id) {
        try {

            PlanesCaracteristicas::eliminarPorPlan($id);

            if (Planes::destroy($id)) {
                return array(
                    'resultado' => 1,
                    'mensaje'   => 'Se eliminó correctamente',
                );
            }
            else {
                return array(
                    'resultado' => 0,
                    'mensaje'   => 'Se encontraron problemas al eliminar',
                );
            }
        }
        catch (Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }
}