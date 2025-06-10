

<?php $__env->startSection('content'); ?>	
	<?php ($idPadre = $_REQUEST['padre']); ?>
    <input type="hidden" id="idPadre" value="<?php echo e($idPadre); ?>">
    <input type="hidden" id="rutaImagen" value="../../../temas/<?php echo e($empresa['tema_nombre']); ?>">
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
                                    <div class="ibox-title">
                                        <center><i class="fa <?php echo e($listaMenu['icono']); ?> fa-2x"></i></center>
                                    </div>
                                    <div class="ibox-content ibox-heading">
                                        <center>
                                            <span>
                                                <h3><?php echo e($listaMenu['nombre']); ?></h3>
                                                <small><?php echo e($listaMenu['descripcion']); ?></small>
                                            </span>
                                        </center>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>