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
                        <div id="tab-make-payment" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#list"><i class="fa fa-list" aria-hidden="true"></i> Listado</a></li>
                                <li class=""><a data-toggle="tab" href="#create"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="list" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="grid-invoice"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="create" class="tab-pane">
                                    <div class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('sales.make-payment.create')
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

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/sales/invoice.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Invoice.constructor();
    </script>
@endsection