<?php
/**
 * Created by PhpStorm.
 * User: Jose Barrios
 * Date: 2017/12/07
 * Time: 10:56 AM
 */

namespace App\Http\Controllers\Parametrizacion;

date_default_timezone_set('America/bogota');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Parametrizacion\Empresa;

class ReportesController extends Controller
{

    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2017-10-23 - 10:10 AM
     * @see: 1. Empresa::Find.
     *       2. App::make.
     *       3. Reportes::ConsultarPrestamosFinalizadosPorFechas
     *
     * Consulta el listado de prestamos finalizados.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return pdf
     */
    public static function PermisosPorEmpresa(Request $request) {

        $idEmpresa  = $request->get('id_empresa');
        $pdf        = App::make('dompdf.wrapper');
        $empresa    = Empresa::Find($request->session()->get('idEmpresa'));
        $eReporte   = Empresa::Find($idEmpresa);

        $tabla = ModuloRolController::ObtenerListaPermisoPorEmpresa($request, $idEmpresa);

        $pdf->loadHTML(
            View('parametrizacion.reportes.permisos',[
                'nombre_empresa'            => $empresa->nombre,
                'fecha'                     => date('Y-m-d h:i:s'),
                'logo_empresa'              => $empresa->imagen_logo,
                'usuario_generador'         => $request->session()->get('nombres'),
                'nombre_permiso_empresa'    => $eReporte->nombre,
                'tabla' => $tabla
            ])
        )
            ->setPaper('A4', 'portrait')
            ->setWarnings(false)
            ->save('Reporte.pdf');

        //return $pdf->download('Reporte de relación de prestamo.pdf');
        return $pdf->stream();
    }
}