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
                        <div id="tab-take-order" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#list"><i class="fa fa-list" aria-hidden="true"></i> Listado</a></li>
                                <li class=""><a data-toggle="tab" href="#create-update"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear o Editar</a></li>
                                <li class=""><a data-toggle="tab" href="#preview"><i class="fa fa-file-text-o" aria-hidden="true"></i> Previzualización</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="list" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="grid-orders"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="create-update" class="tab-pane">
                                    <div class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('warehouse.take-order.create-update')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="preview" class="tab-pane">
                                    <div class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('warehouse.take-order.preview')
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
        </div>
    </div>

    @include('warehouse.take-order.clone')
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/warehouse/take-order.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Order.constructor();
    </script>
@endsection