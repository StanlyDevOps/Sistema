@extends('temas.'.$empresa['nombre_administrador'])

@section('css')
    <link rel="stylesheet" href="{{asset('temas/stids/librerias/nestable/nestable.css')}}">
@endsection

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
                        <div id="tab-category" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#listado"><i class="fa fa-list" aria-hidden="true"></i> Lista de categorias</a></li>
                                <li class=""><a data-toggle="tab" href="#create-update"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear o Editar</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="listado" class="tab-pane active">
                                    <div class="panel-body">
                                        @include('inventario.category.list')
                                    </div>
                                </div>
                                <div id="create-update" class="tab-pane">
                                    <div id="listado" class="tab-pane active">
                                        <div class="panel-body">
                                            @include('inventario.category.create-update')
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
    <script type="text/javascript" src="{{asset('temas/stids/librerias/nestable/nestable.js?v1.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/inventario/categoria.js?v1.0')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Categoria.constructor();
    </script>
@endsection