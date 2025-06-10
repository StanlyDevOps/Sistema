@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    @include('functions.father-son')
    @include('functions.father-son-headboard')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-6" id="impuesto">
                            @include('inventario.configuration.tax')
                        </div>
                        <div class="col-lg-6" id="unidades">
                            @include('inventario.configuration.unity')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/inventario/impuesto.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/inventario/unidades.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Impuesto.constructor();
        Api.Unidades.constructor();
    </script>
@endsection