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
                        <div id="tab-product" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#listado"><i class="fa fa-list" aria-hidden="true"></i> Listado</a></li>
                                <li class=""><a data-toggle="tab" href="#create-update"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear o Editar</a></li>
                                <li class=""><a data-toggle="tab" href="#details"><i class="fa fa-file-text-o" aria-hidden="true"></i> Detalle</a></li>
                                <li class=""><a data-toggle="tab" href="#celler-location"><i class="fa fa-map-marker" aria-hidden="true"></i> Bodega & Localización</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="listado" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @include('inventario.products.list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="create-update" class="tab-pane">
                                    <div class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('inventario.products.create-update')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="details" class="tab-pane">
                                    <div class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('inventario.products.detail')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="celler-location" class="tab-pane">
                                    <div class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    @include('inventario.products.celler-location')
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

    @include('inventario.products.modals')

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/inventario/categoria.js?v1.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/inventario/product.js?v1.0')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Product.assetImages = '{{asset('recursos/imagenes/inventory/products')}}/';
        Api.Product.assetTheme = '{{asset('temas/stids/img')}}/';
        Api.Product.constructor();
    </script>
@endsection