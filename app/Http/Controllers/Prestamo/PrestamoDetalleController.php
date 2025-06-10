<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\HerramientaStidsController;

use App\Models\Prestamo\PrestamoDetallePago;
use Illuminate\Http\Request;

use App\Models\Prestamo\PrestamoDetalle;
use App\Models\Prestamo\Prestamo;


class PrestamoDetalleController extends Controller
{
    public static $hs;
    public static $transaccion;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$hs = new HerramientaStidsController();
        self::$transaccion = ['', 32, '', 'p_prestamo_detalle'];
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date_create 2018-01-17 - 05:20 PM
     * @see 1. PrestamoDetalle::consultarTodo.
     *      2. self::$hs->jsonError.
     *
     * Consultamos todos los datos activos del prestamo
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public static function ConsultarPorPrestamo(Request $request) {

        $objeto = PrestamoDetalle::ConsultarTodoPorPrestamo(
            $request,
            $request->get('buscador'),
            $request->get('pagina'),
            $request->get('tamanhio'),
            $request->get('idPrestamo'),
            $request->session()->get('idEmpresa')
        );

        return is_null($objeto) ? (object)self::$hs->jsonError : $objeto;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-18 - 03:41 PM
     *
     * Guardar detalle del prestamo por cadena.
     *
     * @param request $request:         Peticiones realizadas.
     * @param object  $idPrestamo:      ID del prestamo.
     * @param request $cadena:          Cadena de listado de cuotas a guardar.
     * @param request $idCliente:       ID del cliente.
     * @param request $idFormaPago:     ID de la forma de pago.
     * @param request $cuota:           Cuota.
     * @param request $refinanciacion:  Numero de refinanciación.
     *
     * @return array
     */
    public function GuardarPorCadena($request, $idPrestamo, $cadena, $idCliente, $idFormaPago, $cuota = 0, $refinanciacion = 0) {

        $columnas    = array_filter(explode('}',$cadena));
        $jsonResult  = [];


        foreach ($columnas as $columna) {

            $data = array_filter(explode(';',$columna));

            $clase = new PrestamoDetalle();

            $clase->id_empresa          = $request->session()->get('idEmpresa');
            $clase->id_cliente          = $idCliente;
            $clase->id_prestamo         = $idPrestamo;
            $clase->id_forma_pago       = $idFormaPago;
            $clase->id_estado_pago      = $refinanciacion > 0 ? 11 : 4;
            $clase->no_cuota            = $data[0] + $cuota;
            $clase->fecha_pago          = $data[1];
            $clase->saldo_inicial       = $data[2];
            $clase->cuota               = $data[3];
            $clase->intereses           = $data[4];
            $clase->abono_capital       = $data[5];
            $clase->saldo_final         = isset($data[6]) ? $data[6] : 0;
            $clase->no_refinanciacion   = $refinanciacion;

            self::$transaccion[0] = $request;
            self::$transaccion[2] = 'crear';

            $jsonResult[] = self::$hs->ejecutarSave($clase, self::$hs->mensajeGuardar, self::$transaccion)->original;
        }

        return $jsonResult;
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date 2017-11-11 - 11:19 AM
     * @see 1. HerramientaStidsController::verificationDatas.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. PrestamoDetalle::actualizarFechaDesdeCuota.
     *
     * Actualiza la información de un pago
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public function ActualizarFecha(Request $request) {

        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'fecha' => 'Debe seleccionar una fecha poder actualizar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Obtenemos
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->fecha_pago  = $request->get('fecha');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';


        #4. Actualizamos
        $resultado = self::$hs->Guardar($request, $clase, self::$hs->mensajeActualizar, self::$transaccion);


        #5. Actualizamos la fecha de todas las cuotas que sean mayores a la cuota actual
        PrestamoDetalle::ActualizarFechaDesdeCuota($request,$clase->id_prestamo,$clase->no_cuota,$request->get('fecha'));

        return $resultado;
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-21 - 05:15 PM
     * @see: 1. PrestamoDetalle::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function Eliminar($request)
    {
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->estado = -1;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        return self::$hs->ejecutarSave($clase,self::$hs->mensajeEliminar,self::$transaccion);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 2.0
     * @date_create 2018-01-21 - 09:01 AM
     * @date_modify 2018-03-31 - 08:21 AM <Jeremy Reyes B.>     *
     * @see 1. HerramientaStidsController::verificationDatas.
     *      2. PrestamoDetalle::ConsultarSaldoAtrasado.
     *      3. PrestamoDetalle::find.
     *      4. Prestamo::find.
     *
     * Realiza el pago de un prestamo.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarPago(Request $request) {

        #0. Inicializacion de variables
        $idEmpresa   = $request->session()->get('idEmpresa');
        $idPrestamo  = $request->get('id_prestamo');
        $valor       = $request->get('valor');
        $observacion = $request->get('observacion');
        $rPago       = [];
        $valorDeuda  = 0;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'crear';


        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'valor' => 'Debe digitar el valor que desea pagar para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };

        #2. Verificamos si tiene pagos atrasados
        $saldoAtrasado   = PrestamoDetalle::ConsultarSaldoAtrasado($request, $idEmpresa, $idPrestamo)[0];
        $prestamoDetalle = PrestamoDetalle::find($saldoAtrasado->id);
        $saldoAPagar     = $prestamoDetalle->cuota - $prestamoDetalle->valor_pagado;

        #2.1. Asignamos el estado (12: Atrasado; 10: Al día)
        $estado = $valor < $prestamoDetalle->cuota ? 12 : 10;

        $prestamoDetalle->valor_pagado   += $valor;
        $prestamoDetalle->id_estado_pago  = $estado;
        $prestamoDetalle->observacion    .= "\n$observacion";

        #2.2. Guardamos el pago en la cuota.
        $rPago[] = self::$hs->Guardar($request, $prestamoDetalle, self::$hs->mensajeGuardar, self::$transaccion);


        #2.3. Guardamos el pago en la tabla de pagos.
        $PDP = new PrestamoDetallePagoController();

        $rPago[] = $PDP->GuardarPago(
            $request,
            $saldoAtrasado->id,
            $estado,
            $valor,
            $observacion
        );

        Prestamo::ActualizarDatosFinacieros($request, [$idPrestamo], false, date('Y-m-d H:i:s'), $estado, $observacion);

        #3. Si el valor a pagar es mayor que el salgo de debe o tiene que pagar actualiza las cuotas
        if ($valor > $saldoAtrasado->saldo || ($saldoAtrasado->saldo === 0 && $valor > $saldoAPagar)) {

            $prestamo = Prestamo::find($idPrestamo);

            $totales  = PrestamoDetalle::ObtenerTotalesPagado(
                $request,
                $idEmpresa,
                $idPrestamo,
                (int)$prestamoDetalle->no_cuota
            );

            $capital = $prestamo->monto_requerido - ($totales->valor_pagado - $totales->intereses);

            $calculos = $this->Calculos(
                $prestamo->id_tipo_prestamo,
                $capital,
                $prestamo->intereses,
                $prestamo->no_cuotas - (int)$prestamoDetalle->no_cuota
            );

            $this->ActualizarCuotasPrestamo($idEmpresa, $idPrestamo, $prestamoDetalle->id, $calculos->arreglo);
        }

        return response()->json([
            'resultado' => 1,
            'titulo'    => 'Realizado',
            'mensaje'   => 'Se guardó el pago correctamente',
            'datos'     => $rPago
        ]);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date_create 2018-03-31 - 08:15 PM
     * @date_modify 0000-00-00 - 00:00 -- <name>
     * @see 1. PrestamoDetalle::ObtenerCuotasMayores.
     *      2. PrestamoDetalle::find.
     *
     * Actualiza el valor a pagar en las cuotas
     *
     * @param integer $idEmpresa:           ID de la empresa.
     * @param integer $idPrestamo:          ID del prestamo.
     * @param integer $idPrestamoDetalle:   ID del detalle del prestamo.
     * @param array   $valores:             Array de los nuevos valores de la cuota.
     *
     * @return array
     */
    public function ActualizarCuotasPrestamo($idEmpresa, $idPrestamo, $idPrestamoDetalle, $valores){

        $resultado = [];
        $data = request();

        $prestamoDetalle = PrestamoDetalle::ObtenerCuotasMayores(
            $data,
            $idEmpresa,
            $idPrestamo,
            $idPrestamoDetalle
            );

        if ($prestamoDetalle->count()) {

            foreach ($prestamoDetalle as $key => $item) {

                $clase = PrestamoDetalle::find($item->id);

                $clase->saldo_inicial  = $valores[$key]['saldo_inicial'];
                $clase->intereses      = $valores[$key]['interes'];
                $clase->cuota          = $valores[$key]['cuota'];
                $clase->abono_capital  = $valores[$key]['abono_capital'];
                $clase->saldo_final    = $valores[$key]['saldo_final'];

                $resultado[] = self::$hs->Guardar($data, $clase, self::$hs->mensajeActualizar, self::$transaccion);
            }
        }

        return $resultado;
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date_create 2018-03-31 - 06:09 PM
     * @date_modify 0000-00-00 - 00:00 -- <name>
     *
     * Realiza calculos de amortización a saldo y fijo.
     *
     * @param integer $tipo:        Tipo de prestamo.
     * @param integer $monto:       Monto solicitado.
     * @param float   $interes:     Porcentaje de interes.
     * @param integer $cuotas:      Cuotas.
     * @param integer $formaPago:   Forma de pago.
     * @param string  $fechaPago:   Fecha de pago.
     *
     * @return object
     */
    public function Calculos($tipo, $monto, $interes, $cuotas, $formaPago = null, $fechaPago = null) {

        $calculo        = (object)['arreglo' => null, 'cadena' => null];
        $fecha          = null;
        $saldoInicial   = $monto;
        $saldoFinal     = 0;
        $abonoCapital   = 0;
        $abonoInteres   = 0;
        $porcentaje     = $interes / 100;
        $cuota          = round(($porcentaje * pow(1 + $porcentaje, $cuotas) * $monto) / pow(1 + $porcentaje, $cuotas) - 1,0);


        for ($i = 0; $i < $cuotas; $i++) {

            // Calculo fijo
            if ($tipo === 1) {

                $saldoInicial = $i === 0 ? $monto : $saldoFinal;

                // Si es el ultimo pago entonces realiza un calculo diferente
                if ($i + 1 === $cuotas) {

                    $abonoInteres = $cuota - $saldoInicial;
                    $abonoCapital = $cuota - $abonoInteres;
                    $saldoFinal   = 0;
                }
                else {
                    $abonoInteres = round($saldoInicial * $interes / 100,0);
                    $abonoCapital = $cuota - $abonoInteres;
                    $saldoFinal   = $saldoInicial - $abonoCapital;
                }
            }
            // Calculo a capital uniforme
            elseif ($tipo === 2) {

                $saldoInicial = $i === 0 ? $monto : $saldoFinal;

                $abonoCapital   = round($monto / $cuotas,0);
                $abonoInteres   = round($saldoInicial * $interes / 100, 0);
                $cuota          = $abonoCapital + $abonoInteres;

                // Si es el ultimo pago entonces realiza un calculo diferente
                $saldoFinal =  $i + 1 === $cuotas ? 0 : $saldoInicial - $abonoCapital;
            }

            if ($formaPago && $fechaPago) {
                null;
                // $fecha = this.obtenerFecha($prestamo.forma_pago, i - 1, $prestamo.fecha_pago);
            }

            # Asignación de parametros al arreglo
            $calculo->arreglo[$i]['no_cuota']         = $i + 1;
            $calculo->arreglo[$i]['fecha']            = $fecha;
            $calculo->arreglo[$i]['saldo_inicial']    = $saldoInicial;
            $calculo->arreglo[$i]['cuota']            = $cuota;
            $calculo->arreglo[$i]['interes']          = $abonoInteres;
            $calculo->arreglo[$i]['abono_capital']    = $abonoCapital;
            $calculo->arreglo[$i]['saldo_final']      = $saldoFinal;

            # Asignación de parametros a la cadena
            $calculo->cadena .= $i + 1 . ';';
            $calculo->cadena .= $fecha . ';';
            $calculo->cadena .= $saldoInicial . ';';
            $calculo->cadena .= $cuota . ';';
            $calculo->cadena .= $abonoInteres . ';';
            $calculo->cadena .= $abonoCapital . ';';
            $calculo->cadena .= $saldoFinal . ';}';
        }

       return $calculo;
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 1.0
     * @date 2018-01-21 - 09:01 AM
     * @see 1. HerramientaStidsController::verificationDatas.
     *
     * Realiza un pago.
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarPagoCuota(Request $request) {


        #0. Inicializacion de variables
        $idPrestamoDetalle  = $request->get('id_prestamo_detalle');
        $valor              = $request->get('valor');
        $observacion        = $request->get('observacion');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';


        #1. Verificamos los datos enviados

        #1.1. Datos obligatorios
        $datos = [
            'valor' => 'Debe digitar el valor que desea pagar para poder guardar los cambios',
        ];

        #1.2. Verificación de los datos obligatorios con los enviados
        if($respuesta = self::$hs->verificationDatas($request,$datos)) {
            return $respuesta;
        };


        #2. Si el valor a pagar es mayor de 0 entonces guardamos
        if ($valor > 0) {

            $clase  = PrestamoDetalle::find($idPrestamoDetalle);

            $clase->valor_pagado    = $valor;
            $clase->id_estado_pago  = 7;

            if (trim($observacion)) {
                $clase->observacion = $observacion;
            }

            #2.1. Guardamos el pago en la cuota.
            $rPago[] = self::$hs->Guardar($request, $clase, self::$hs->mensajeGuardar, self::$transaccion);


            #2.2. Guardamos el pago en la tabla de pagos.
            $PDP = new PrestamoDetallePagoController();

            $rPago[] = $PDP->GuardarPago(
                $request,
                $idPrestamoDetalle,
                7,
                $valor,
                $observacion
            );

            #2.3. Actualizamos los datos de la tabla prestamo
            Prestamo::ActualizarDatosFinacieros($request, [$clase->id_prestamo], false, date('Y-m-d H:i:s'));

            return response()->json([
                'resultado' => 1,
                'titulo'    => 'Realizado',
                'mensaje'   => 'Se guardó el pago correctamente',
                'datos'     => $rPago
            ]);
        }
        else {

            return response()->json([
                'resultado' => 2,
                'titulo'    => 'Información',
                'mensaje'   => 'El valor a pagar debe ser mayor de 0'
            ]);
        }
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 3.0
     * @date_create 2017-11-11 - 02:23 PM
     * @date_modify 2018-01-21 - 01:58 PM <Jeremy Reyes B.>
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. Prestamo::actualizarDatosFinacieros.
     *
     * Borra el pago realizado
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public function BorrarPago($request){

        $idPrestamoDetalle = $request->get('id');

        #1. Eliminamos por el detalle del prestamo los pagos realizados.
        PrestamoDetallePago::eliminarPorDetallePrestamo($request,$idPrestamoDetalle);

        #2. Obtenemos la cuota seleccionada
        $prestamoDetalle = PrestamoDetalle::find($idPrestamoDetalle);

        $prestamoDetalle->valor_pagado   = 0;
        $prestamoDetalle->id_estado_pago = 4;

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        #3. Actualizamos en 0 el pago realizado
        $rPrestamoDetallePago = self::$hs->Guardar(
            $request,
            $prestamoDetalle,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );


        #4. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::ActualizarDatosFinacieros(
            $request,
            [$prestamoDetalle->id_prestamo],
            false,
            null,
            4
        );


        return response()->json([
            'resultado'             => 1,
            'titulo'                => 'Realiado',
            'mensaje'               => 'Se borró el pago realizado correctamente.',
            'prestamo_detalle_pago' => $rPrestamoDetallePago,
            'datos_financieros'     => $rDatosFinancieros
        ]);
    }


    /**
     * @autor Jeremy Reyes B.
     * @version 3.0
     * @date_create 2017-11-11 - 02:23 PM
     * @date_modify 2018-01-21 - 01:58 PM <Jeremy Reyes B.>
     * @see 1. PrestamoDetallePago::eliminarPorDetallePrestamo.
     *      2. HerramientaStidsController::ejecutarSave.
     *      3. Prestamo::actualizarDatosFinacieros.
     *
     * Borra el pago realizado
     *
     * @param array $request: Peticiones realizadas.
     *
     * @return json
     */
    public function GuardarAmpliacion($request){

        $clase = PrestamoDetalle::find($request->get('id'));

        $clase->mora            += $request->get('valor');
        $clase->cuota            = $clase->abono_capital + $clase->intereses + $clase->mora;
        $clase->id_estado_pago   = 1;


        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'eliminar';

        #3. Actualizamos en 0 el pago realizado
        $rPrestamoDetallePago = self::$hs->Guardar(
            $request,
            $clase,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );

        #4. Actualizamos los datos financieros de este prestamo
        $rDatosFinancieros = Prestamo::ActualizarDatosFinacieros(
            $request,
            [$clase->id_prestamo],
            false,
            null,
            1
        );

        return response()->json([
            'resultado' => 1,
            'titulo'    => 'Realiado',
            'mensaje'   => 'Se realizó la ampliacion de la cuota correctamente.'
        ]);
    }


    /**
     * @autor: Jeremy Reyes B.
     * @version: 1.0
     * @date: 2018-01-22 - 08:26 PM
     * @see: 1. PrestamoDetalle::find.
     *       2. self::$hs->ejecutarSave.
     *
     * Elimina un dato por id.
     *
     * @param request $request: Peticiones realizadas.
     *
     * @return object
     */
    public function GuardarObservacion($request)
    {
        $clase = PrestamoDetalle::Find((int)$request->get('id'));

        $clase->observacion = $request->get('observacion');

        self::$transaccion[0] = $request;
        self::$transaccion[2] = 'actualizar';

        return self::$hs->Guardar(
            $request,
            $clase,
            self::$hs->mensajeGuardar,
            self::$transaccion
        );
    }
}