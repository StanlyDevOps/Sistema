<?php $__env->startSection('content'); ?>
    <?php ($idPadre = $_REQUEST['padre']); ?>
    <?php ($idHijo = $_REQUEST['hijo']); ?>
    <input type="hidden" id="idPadre" value="<?php echo e($idPadre); ?>">
    <input type="hidden" id="idHijo" value="<?php echo e($idHijo); ?>">

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
                    <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                <?php endif; ?>
                <?php if($op->estado): ?>
                    <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                <?php endif; ?>
                <?php if($op->eliminar): ?>
                    <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                <?php endif; ?>
                <?php if($op->exportar): ?>
                    <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                <?php endif; ?>
                <?php if($op->importar): ?>
                    <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de tipos de identificación</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php if($op->guardar): ?>
                                                <input type="hidden" id="id">
                                                <div class="form-group">
                                                    <label>Tipo de identificación.</label>
                                                    <input type="text" id="nombre-identificacion" class="form-control" style="width:300px" placeholder="Digite el nombre para crear" onkeypress="Api.Identificacion.guardarActualizar(event)" maxlength="50">
                                                </div>
                                                <br>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-12" id="identificacion-mensaje"></div>
                                        <div class="col-lg-12" id="tabla-ti"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin contenido de la pagina -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/si/parametrizacion/identificacion.js')); ?>"></script>
    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Identificacion.ie = parseInt('<?php echo e($id_empresa); ?>');
        Api.Identificacion.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>