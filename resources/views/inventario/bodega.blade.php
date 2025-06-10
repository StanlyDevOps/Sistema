@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    @include('functions.father-son')
    @include('functions.father-son-headboard')


    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12 pad-bot-20">
                        <div id="pestanhia-bodega" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#listado"> Lista de bodegas</a></li>
                                <li class=""><a data-toggle="tab" href="#crear-editar">Crear o Editar</a></li>
                                <li class=""><a data-toggle="tab" href="#detalle">Detalle</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="listado" class="tab-pane active">
                                    <div class="panel-body ">
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-bodega"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="crear-editar" class="tab-pane">
                                    <div class="panel-body">
                                        @include('inventario.wineries.create-edit')
                                    </div>
                                </div>
                                <div id="detalle" class="tab-pane">
                                    <div class="panel-body ">
                                        @include('inventario.wineries.detail')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->

    <!-- Modals -->
    <!-- Formulario localizacion -->
    <div id="modal-localizacion" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Localización en la bodega</h3>
                </div>
                <div class="modal-body gray-bg">
                    <div class="row">
                        <form id="formulario-locacion">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><span class="obligatorio">(*)</span> Nombre.</label>
                                    <input id="l-nombre" type="text" class="form-control m-b" placeholder="Digite el nombre" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label><span class="obligatorio">(*)</span> Existencia.</label>
                                    <input id="l-existencia" type="text" class="form-control m-b formato-moneda" placeholder="0.000" value="0" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label><span class="obligatorio">(*)</span> Stock Minimo.</label>
                                    <input id="l-stock-minimo" type="text" class="form-control m-b formato-moneda" placeholder="0.000" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label><span class="obligatorio">(*)</span> Stock Máximo.</label>
                                    <input id="l-stock-maximo" type="text" class="form-control m-b formato-moneda" placeholder="0.000" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Descripción.</label>
                                    <textarea rows="5" id="l-descripcion" class="form-control m-b" placeholder="Digite una breve descripción" required></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer gray-bg centrado">
                    <div class="col-lg-12">
                        <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Locacion.crearActualizar()">
                            <i class="fa fa-floppy-o"></i>&nbsp;
                            Guardar información
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin formulario localizacion -->
    <!-- Fin Modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/inventario/bodega.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/inventario/locacion.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Bodega.constructor();
    </script>
@endsection