<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <?php if($menuAdministrador['menu'][$idPadre]): ?>
                <?php ($cnt = 0); ?>
                <?php $__currentLoopData = $menuAdministrador['menu'][$idPadre]['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listaMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($cnt++); ?>
                    <?php if($cnt == 1): ?>
                        <div class="col-lg-12">
                            <?php endif; ?>
                            <div class="col-lg-3">
                                <a href="<?php echo e($menuAdministrador['ruta']); ?><?php echo e($listaMenu['enlace_administrador']); ?>?padre=<?php echo e($idPadre); ?>&hijo=<?php echo e($listaMenu['id']); ?>" class="etiqueta">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title text-center">
                                            <i class="fa <?php echo e($listaMenu['icono']); ?> fa-2x"></i>
                                        </div>
                                        <div class="ibox-content ibox-heading text-center">
                                            <h3><?php echo e($listaMenu['nombre']); ?></h3>
                                            <small><?php echo e($listaMenu['descripcion']); ?></small>
                                        </div>
                                        <div class="ibox-content inspinia-timeline"></div>
                                    </div>
                                    <br>
                                    <br>
                                </a>
                            </div>
                            <?php if($cnt == 4): ?>
                        </div>
                        <?php ($cnt=0); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>