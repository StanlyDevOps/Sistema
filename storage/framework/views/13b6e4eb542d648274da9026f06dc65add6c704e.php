<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
        <h2 style="font-weight: 500;"><?php echo e($menuAdministrador['menu'][$idPadre]['nombre']); ?></h2>
        <small><?php echo e($menuAdministrador['menu'][$idPadre]['descripcion']); ?></small>
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
</div>