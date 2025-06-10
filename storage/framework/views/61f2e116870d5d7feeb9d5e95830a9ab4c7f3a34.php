<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-8">
        <h2 style="font-weight: 500;"><?php echo e($menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']); ?></h2>
        <small><?php echo e($menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']); ?></small>
        <br><br>
        <ol class="breadcrumb">
            <li>
                <a href="../inicio"><i class="fa fa-home"></i> Inicio</a>
            </li>
            <?php if(isset($navegacion['padre'])): ?>
                <?php if(!isset($navegacion['hijo'])): ?>
                    <li class="active">
                        <strong><?php echo e($navegacion['padre']['nombre']); ?></strong>
                    </li>
                <?php else: ?>
                    <li><a href="../<?php echo e($navegacion['padre']['enlace']); ?>"><?php echo e($navegacion['padre']['nombre']); ?></a></li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(isset($navegacion['hijo'])): ?>
                <li class="active">
                    <strong><?php echo e($navegacion['hijo']['nombre']); ?></strong>
                </li>
            <?php endif; ?>
        </ol>
    </div>
    <div class="col-sm-4">
        <div class="float-right">
            <?php if($op->guardar): ?>
                <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
            <?php endif; ?>
            <?php if($op->actualizar): ?>
                <button type="button" class="btn btn-success" title="Actualizar"><i
                            class="fa fa-pencil-square-o"></i></button>
            <?php endif; ?>
            <?php if($op->estado): ?>
                <button type="button" class="btn btn-warning" title="Activar y desactivar"><i
                            class="fa fa-toggle-on"></i></button>
            <?php endif; ?>
            <?php if($op->eliminar): ?>
                <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
            <?php endif; ?>
            <?php if($op->exportar): ?>
                <button type="button" class="btn btn-info" title="Exportar archivo"><i
                            class="fa fa-cloud-download"></i></button>
            <?php endif; ?>
            <?php if($op->importar): ?>
                <button type="button" class="btn btn-info" title="Importar archivo"><i
                            class="fa fa-cloud-upload"></i></button>
            <?php endif; ?>
        </div>
    </div>
</div>