<?php

namespace App\Models\Prestamo;

use App\Http\Controllers\HerramientaStidsController;
use App\Http\Controllers\Prestamo\PrestamoDetallePagoController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PrestamoDetallePago extends Model
{
    public $timestamps = false;
    protected $table = "p_prestamo_detalle_pago";

    const MODULO = 'Prestamo';
    const MODELO = 'PrestamoDetallePago';


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-04-01 - 11:45 AM
     *
     * Consultar todos con paginación
     *
     * @param string    $buscar:            Texto a buscar.
     * @param integer   $pagina:            Pagina actual.
     * @param integer   $tamanhio:          Tamaño de la pagina.
     * @param integer   $idPrestamoDetalle: ID detalle del prestamo.
     * @param integer   $idEmpresa:         ID empresa.
     *
     * @return object
     */
    public static function ConsultarTodoPorPrestamoDetalle($buscar, $pagina = 1, $tamanhio = 1000000, $idEmpresa, $idPrestamoDetalle) {

        try {
            $currentPage = $pagina;

            // Fuerza a estar en la pagina
            Paginator::currentPageResolver(function() use ($currentPage) {
                return $currentPage;
            });

            return PrestamoDetallePago::select(
                DB::raw("
                    CONCAT(s_usuario.nombres,' ',s_usuario.apellidos) AS usuario_que_registro_el_pago"
                ),
                'p_prestamo_detalle_pago.*',
                's_transacciones.*',
                's_usuario.*',
                'p_estado_pago.descripcion AS estado_pago',
                's_transacciones.fecha_alteracion AS fecha_registro'
            )
                ->join('s_transacciones','p_prestamo_detalle_pago.id','s_transacciones.id_alterado')
                ->join('s_usuario','s_transacciones.id_usuario','s_usuario.id')
                ->join('p_estado_pago','p_prestamo_detalle_pago.id_estado_pago','p_estado_pago.id')

                ->whereRaw(
                    "( s_usuario.nombres like '%$buscar%'
                    OR s_usuario.apellidos like '%$buscar%'
                    OR p_prestamo_detalle_pago.monto_pagado like '%$buscar%'
                    OR p_estado_pago.descripcion like '%$buscar%'
                  )"
                )
                ->where('p_prestamo_detalle_pago.id_empresa',$idEmpresa)
                ->where('p_prestamo_detalle_pago.id_prestamo_detalle',$idPrestamoDetalle)
                ->where('p_prestamo_detalle_pago.monto_pagado','>',0)
                ->where('p_prestamo_detalle_pago.estado',1)
                ->where('s_transacciones.nombre_tabla','p_prestamo_detalle_pago')
                ->where('s_transacciones.id_empresa', $idEmpresa)
                ->where('s_transacciones.id_permiso',1)
                ->where('s_transacciones.id_modulo',32)
                ->orderBy('p_prestamo_detalle_pago.id','desc')
                ->paginate($tamanhio);

        } catch (\Exception $e) {
            $hs = new HerramientaStidsController();
            return $hs->Log(self::MODULO,self::MODELO,'ConsultarTodo', $e, request());
        }
    }


    public static function consultarActivo() {
        try {
            return PrestamoDetallePagoController::select(DB::raw("p_tipo_prestamo.descripcion AS nombre"),'p_tipo_prestamo.*')
                ->where('estado',1)
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return array();
        }
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-11-11 - 02:29 PM
     *
     * Elimina los pagos por id de cuota
     *
     * @param array     $request:    Peticiones realizadas.
     * @param integer   $idPrestamo: Id detalle del prestamo.
     *
     * @return array: Resultado de la eliminación
     */
    public static function eliminarPorDetallePrestamo($request,$idPrestamoDetalle) {
        try {

            $resultado = PrestamoDetallePago::where('id_empresa',$request->session()->get('idEmpresa'))
                ->where('id_prestamo_detalle',$idPrestamoDetalle)
                ->update(['estado' => -1]);

            if ($resultado > 0) {

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
        catch (\Exception $e) {
            return array(
                'resultado' => -2,
                'mensaje'   => 'Grave error: ' . $e,
            );
        }
    }
}