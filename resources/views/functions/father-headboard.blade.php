<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
        <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['nombre']}}</h2>
        <small>{{$menuAdministrador['menu'][$idPadre]['descripcion']}}</small>
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
</div>