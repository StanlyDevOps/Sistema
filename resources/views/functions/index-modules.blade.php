<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            @if($menuAdministrador['menu'][$idPadre])
                @php($cnt = 0)
                @foreach($menuAdministrador['menu'][$idPadre]['submenu'] as $listaMenu)
                    @php($cnt++)
                    @if($cnt == 1)
                        <div class="col-lg-12">
                            @endif
                            <div class="col-lg-3">
                                <a href="{{$menuAdministrador['ruta']}}{{$listaMenu['enlace_administrador']}}?padre={{$idPadre}}&hijo={{$listaMenu['id']}}" class="etiqueta">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title text-center">
                                            <i class="fa {{$listaMenu['icono']}} fa-2x"></i>
                                        </div>
                                        <div class="ibox-content ibox-heading text-center">
                                            <h3>{{$listaMenu['nombre']}}</h3>
                                            <small>{{$listaMenu['descripcion']}}</small>
                                        </div>
                                        <div class="ibox-content inspinia-timeline"></div>
                                    </div>
                                    <br>
                                    <br>
                                </a>
                            </div>
                            @if($cnt == 4)
                        </div>
                        @php($cnt=0)
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>