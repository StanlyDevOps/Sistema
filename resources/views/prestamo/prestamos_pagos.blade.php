@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-8">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
            <br><br>
            <ol class="breadcrumb">
                <li>
                    <a href="../inicio"><i class="fa fa-home"></i> Inicio</a>
                </li>
                @if(isset($navegacion['padre']))
                    @if(!isset($navegacion['hijo']))
                        <li class="active">
                            <strong>{{$navegacion['padre']['nombre']}}</strong>
                        </li>
                    @else
                        <li><a href="../{{$navegacion['padre']['enlace']}}">{{$navegacion['padre']['nombre']}}</a></li>
                    @endif
                @endif
                @if(isset($navegacion['hijo']))
                    <li class="active">
                        <strong>{{$navegacion['hijo']['nombre']}}</strong>
                    </li>
                @endif
            </ol>
        </div>
        <div class="col-sm-4">
            <div class="float-right">
                @if($op->guardar)
                    <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
                @endif
                @if($op->actualizar)
                    <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                @endif
                @if($op->estado)
                    <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                @endif
                @if($op->eliminar)
                    <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                @endif
                @if($op->exportar)
                    <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                @endif
                @if($op->importar)
                    <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Crear un prestamo</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <form id="formulario-prestamo">
                                        <div class="row">
                                            <div class="col-lg-6 form-group">
                                                <label>Clientes.</label>
                                                <select id="id-cliente" class="form-control m-b chosen-select"></select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Forma de pago.</label>
                                                <select id="id-forma-pago" class="form-control m-b chosen-select"></select>
                                            </div>
                                            <div class="col-lg-3 form-group">
                                                <label>Fecha del pago inicial.</label>
                                                <div class="input-group">
                                                    <input id="fecha-pago-inicial" type="text" class="form-control m-b datepicker" maxlength="10" placeholder="Seleccione una fecha">
                                                    <span class="input-group-addon icono-calendario"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 form-group">
                                                <label>Tipo prestamo.</label>
                                                <select id="id-tipo-prestamo" class="form-control m-b chosen-select" onchange="Api.Prestamo.calcularPrestamo()"></select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Monto solicitado.</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">$</span>
                                                    <input id="monto-requerido" type="text" class="form-control formato-moneda" placeholder="000,000,000" onkeyup="Api.Prestamo.calcularPrestamo()">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <label>Interes.</label>
                                                <div class="input-group">
                                                    <input id="intereses" type="text" class="form-control m-b" placeholder="00.00" onkeyup="Api.Prestamo.calcularPrestamo()">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <label>Cuotas.</label>
                                                <input id="no-cuotas" type="text" class="form-control m-b centrado" maxlength="2" placeholder="00" onkeyup="Api.Prestamo.calcularPrestamo()">
                                            </div>
                                            <div class="col-lg-2 centrado">
                                                <label>Total Intereses.</label>
                                                <div id="total-intereses" style="line-height: 30px;">$0</div>
                                            </div>
                                            <div class="col-lg-2 centrado">
                                                <label>Total.</label>
                                                <div id="total-general" style="line-height: 30px;">$0</div>
                                            </div>

                                            <div class="col-lg-12">
                                                <button id="btn-simular" class="btn btn-success" type="button" onclick="Api.Prestamo.simularPrestamo()">
                                                    <i class="fa fa-list-alt"></i>&nbsp;
                                                    Simular prestamo
                                                </button>
                                                @if($op->guardar)
                                                    <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Prestamo.crear()">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Crear prestamo
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div id="pestanhia-prestamo" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lista-prestamos">Lista de prestamos</a></li>
                                <li class=""><a data-toggle="tab" href="#detalle-prestamo">Detalle del prestamo</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="lista-prestamos" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="prestamo-tabla"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="detalle-prestamo" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div id="informacion-prestamo-detalle" class="ocultar">
                                                <div class="col-lg-4">
                                                    <strong>No. Prestamo.</strong>
                                                    <span id="detalle-no-prestamo"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Cliente.</strong>
                                                    <span id="detalle-cliente"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Tipo de prestamo.</strong>
                                                    <span id="detalle-tipo-prestamo"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Forma de pago.</strong>
                                                    <span id="detalle-forma-pago"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Estado de pago.</strong>
                                                    <span id="detalle-estado-pago"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Intereses.</strong>
                                                    <span id="detalle-intereses"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>No. Cuotas.</strong>
                                                    <span id="detalle-no-cuotas"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Monto solicitado.</strong>
                                                    <span id="detalle-monto"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Total intereses.</strong>
                                                    <span id="detalle-total-intereses"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Total mora.</strong>
                                                    <span id="detalle-total-mora"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Total.</strong>
                                                    <span id="detalle-total"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Total saldo pagado.</strong>
                                                    <span id="total-saldo-pagado"></span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <strong>Total a pagar.</strong>
                                                    <span id="total-a-pagar"></span>
                                                </div>
                                                <div class="col-lg-12">&nbsp;</div>
                                            </div>
                                            <div class="col-lg-12" id="prestamo-detalle-tabla"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- Fin contenido de la pagina -->

    <!-- Modals -->
    <!-- Simular prestamo -->
    <div id="modal-simular" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Simulador de prestamo</h3>
                </div>
                <div class="modal-body gray-bg">
                    <div class="row">
                        <div class="col-lg-12 ibox-content">
                            <div class="col-lg-4">
                                <strong>Cliente. </strong>
                                <span id="simulacion-nombre-cliente"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Forma de pago. </strong>
                                <span id="simulacion-forma-pago"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Tipo de prestamo. </strong>
                                <span id="simulacion-tipo-prestamo"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Monto. </strong>
                                <span id="simulacion-monto"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Interes. </strong>
                                <span id="simulacion-intereses"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>No. Cuotas. </strong>
                                <span id="simulacion-cuotas"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Total interes. </strong>
                                <span id="simulacion-total-interes"></span>
                            </div>
                            <div class="col-lg-4">
                                <strong>Total general. </strong>
                                <span id="simulacion-total-general"></span>
                            </div>

                            <div class="col-lg-12">
                                <br>
                                @if($op->exportar)
                                    <form id="formulario-exportar-simulacion" method=POST action="pdf" target="_blank">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="crud" value="true">
                                        <input type="hidden" name="controlador" value="Reportes">
                                        <input type="hidden" name="carpetaControlador" value="Prestamo">
                                        <input type="hidden" name="funcionesVariables" value="DescargarSimulacion">
                                        <input type="hidden" id="encabezado" name="encabezado" value="">
                                        <input type="hidden" id="tabla" name="tabla" value="">
                                    </form>
                                    <button class="btn btn-info float-right" onclick="Api.Prestamo.descargarSimulacion()">
                                    <i class="fa fa-cloud-download"></i>
                                    &nbsp;
                                    Descargar
                                </button>
                                @endif
                                <br>
                                <br>
                                <div class="table-responsive" id="tabla-simulacion">
                                    <table class="table table-bordered table-hover table-striped tablesorter">
                                        <thead>
                                            <tr>
                                                <th class="centrado">Periodo</th>
                                                <th class="centrado">Fecha pago</th>
                                                <th class="centrado">Saldo inicial</th>
                                                <th class="centrado">Cuota</th>
                                                <th class="centrado">Interes</th>
                                                <th class="centrado">Abono a capital</th>
                                                <th class="centrado">Saldo final</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin simular prestamo -->

    <!-- Realizar pagos -->
    <div id="modal-pagos" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Realizar pago</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label>Valor a pagar.</label>
                        <div class="input-group">
                            <span class="input-group-addon icono-calendario">$</span>
                            <input id="pagos-valor" type="text" class="form-control m-b formato-moneda" placeholder="000,000,000">
                        </div>
                        <br>
                        <label>Observación.</label>
                        <div>
                            <textarea id="pagos-observacion" class="form-control" rows="5" placeholder="Digite una observación para este pago."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gray-bg centrado">
                    @if($op->guardar)
                        <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.PrestamoDetalle.guardarPago()">
                            <i class="fa fa-floppy-o"></i>&nbsp;
                            Guardar pago
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Fin realizar pagos -->

    <!-- Refinanciación -->
    <div id="modal-refinanciar" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Refinanciar prestamo <span id="refinanciar-no-prestamo"></span></h3>
                </div>
                <div class="modal-body blanco-oscuro">
                    <div class="row">
                        <div class="col-lg-4">
                            <strong>Cliente. </strong>
                            <span id="refinanciar-nombre-cliente"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Forma de pago. </strong>
                            <span id="refinanciar-forma-pago"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Tipo de prestamo. </strong>
                            <span id="refinanciar-tipo-prestamo"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Monto. </strong>
                            <span id="refinanciar-monto"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Interes. </strong>
                            <span id="refinanciar-intereses"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>No. Cuotas. </strong>
                            <span id="refinanciar-cuotas"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Total interes. </strong>
                            <span id="refinanciar-total-interes"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Total general. </strong>
                            <span id="refinanciar-total-general"></span>
                        </div>
                        <div class="col-lg-4">
                            <strong>Total deuda. </strong>
                            <span id="refinanciar-total-deuda"></span>
                        </div>
                        <div class="col-lg-12">
                            <br><br>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label>Valor a refinanciar.</label>
                            <input type="text" id="refinanciar-valor-refinanciar" class="form-control m-b" disabled="disabled">
                        </div>
                        <div class="col-lg-3 form-group">
                            <label>Fecha pago inicial.</label>
                            <div class="input-group">
                                <input type="text" id="refinanciar-fecha-inicial" class="form-control m-b datepicker" value="{{date('Y-m-d')}}" maxlength="10">
                                <span class="input-group-addon icono-calendario"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-2 form-group">
                            <label>Cuotas.</label>
                            <input type="text" id="refinanciacion-cuotas" data-numero-minimo="" class="form-control m-b numerico" value="1" readonly>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-success " type="button" onClick="Api.Prestamo.simularRefinanciacion()">
                                        <i class="fa fa-list-alt"></i>&nbsp;
                                        Generar Refinanciación
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-lg-12">
                        <div class="table-responsive" id="tabla-simulacion-refinanciar">
                            <table class="table table-bordered table-hover table-striped tablesorter">
                                <thead>
                                <tr>
                                    <th class="centrado">Periodo</th>
                                    <th class="centrado">Fecha pago</th>
                                    <th class="centrado">Saldo inicial</th>
                                    <th class="centrado">Cuota</th>
                                    <th class="centrado">Interes</th>
                                    <th class="centrado">Abono a capital</th>
                                    <th class="centrado">Saldo final</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                            <br>
                            <div class="form-group">
                                <label>Observación.</label>
                                <div>
                                    <textarea id="refinanciar-observacion" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            @if($op->guardar)
                                <button id="btn-guardar-refinanciacion" class="btn btn-primary btn-guardar" type="button" onclick="Api.Prestamo.guardarRefinanciacion();">
                                    <i class="fa fa-refresh"></i>&nbsp;
                                    Guardar Refinanciación
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Refinanciación -->

    <!-- Ampliacion -->
    <div id="modal-ampliar" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Ampliar cuota No. <span id="ampliar-no-cuota"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label>Interes.</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input id="ampliar-saldo" type="text" class="form-control m-b formato-moneda" placeholder="000,000,000">
                        </div>
                        <br>
                        <label>Días a ampliar.</label>
                        <div class="input-group">
                            <input type="text" id="ampliar-dias" class="form-control m-b numerico" min="1" max="999" value="1">
                        </div>
                        <br>
                        <label>Valor a pagar.</label>
                        <div class="input-group">
                            <span class="input-group-addon icono-calendario apuntar" onclick="Api.PrestamoDetalle.calcularAmpliacion()"><i class="fa fa-calculator"></i></span>
                            <input id="ampliar-total" type="text" class="form-control m-b formato-moneda" placeholder="000,000,000" readonly>
                        </div>
                        <br>
                        <div class="alert alert-dismissable alert-info centrado" style="position: absolute;">
                            <p>
                                Ampliación para los días retrasados
                                <br>
                                <strong>(interes / 30 * días)</strong>
                            </p>
                        </div>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="modal-footer gray-bg centrado">
                    @if($op->guardar)
                        <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.PrestamoDetalle.guardarAmpliacion()">
                            <i class="fa fa-floppy-o"></i>&nbsp;
                            Guardar ampliación
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Fin ampliacion -->

    <!-- Cambio de fecha -->
    <div id="modal-cambiar-fecha" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Fecha de la cuota No. <span id="cambiar-fecha-no-cuota"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label>Nueva fecha.</label>
                        <div class="input-group">
                            <input id="cambiar-fecha" type="text" class="form-control m-b datepicker">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gray-bg centrado">
                    @if($op->actualizar)
                        <button id="btn-guardar" class="btn btn-success" type="button" onClick="Api.PrestamoDetalle.guardarFecha()">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;
                            Actualizar fecha
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Fin cambio de fecha -->

    <!-- Observacion -->
    <div id="modal-observacion" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Observaciones</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <textarea id="observacion" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer gray-bg centrado">
                    @if($op->actualizar)
                        <button id="btn-guardar-observacion" class="btn btn-success" type="button" onClick="">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;
                            Guardar observación
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Fin observacion -->

    <!-- Detalle del prestamo -->
    <div id="modal-detalle-prestamo" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Detalle de la cuota No. <span class="cuota"></span></h3>
                </div>
                <div class="modal-body blanco-oscuro">
                    <div class="row text-center">
                        <div class="col-lg-2">
                            <strong>Fecha de pago. </strong>
                            <br>
                            <span class="fecha"></span>
                        </div>
                        <div class="col-lg-2">
                            <strong>Saldo inicial. </strong>
                            <br>
                            <span class="saldo-inicial"></span>
                        </div>
                        <div class="col-lg-1">
                            <strong>Cuota. </strong>
                            <br>
                            <span class="cuota-pagar"></span>
                        </div>
                        <div class="col-lg-1">
                            <strong>Interes. </strong>
                            <br>
                            <span class="interes"></span>
                        </div>
                        <div class="col-lg-2">
                            <strong>Abono capital. </strong>
                            <br>
                            <span class="abono-capital"></span>
                        </div>
                        <div class="col-lg-2">
                            <strong>Valor pagado. </strong>
                            <br>
                            <span class="valor-pagado"></span>
                        </div>
                        <div class="col-lg-2">
                            <strong>Estado. </strong>
                            <br>
                            <span class="estado"></span>
                        </div>
                        <div class="col-lg-12">
                            <br><br>
                        </div>
                        <div class="col-lg-12" id="tabla-prestamo-detalle-pago"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin detalle prestamo -->

    <!-- Fin Modals -->

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/prestamo/calculos.js?v1.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo.js?v1.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo-detalle.js?v1.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo-detalle-pago.js?v1.0')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Prestamo.constructor();
    </script>
@endsection