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
                <button type="button" class="btn btn-success" title="Actualizar"><i
                            class="fa fa-pencil-square-o"></i></button>
            @endif
            @if($op->estado)
                <button type="button" class="btn btn-warning" title="Activar y desactivar"><i
                            class="fa fa-toggle-on"></i></button>
            @endif
            @if($op->eliminar)
                <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
            @endif
            @if($op->exportar)
                <button type="button" class="btn btn-info" title="Exportar archivo"><i
                            class="fa fa-cloud-download"></i></button>
            @endif
            @if($op->importar)
                <button type="button" class="btn btn-info" title="Importar archivo"><i
                            class="fa fa-cloud-upload"></i></button>
            @endif
        </div>
    </div>
</div>