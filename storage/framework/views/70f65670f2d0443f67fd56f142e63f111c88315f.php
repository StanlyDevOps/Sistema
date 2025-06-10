

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
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Crear Tema</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <form id="formulario-temas">
                                            <div class="col-lg-3 form-group">
                                                <label>Nombre del tema.</label>
                                                <input id="nombre" type="text" class="form-control m-b" placeholder="Digite el nombre" required>
                                            </div>
                                            <div class="col-lg-3 form-group">
                                                <label>Nombre para usuarios.</label>
                                                <input id="nombre-usuario" type="text" class="form-control m-b" placeholder="Digite la sesión de usuario" required>
                                            </div>
                                            <div class="col-lg-3 form-group">
                                                <label>Nombre para administrador.</label>
                                                <input id="nombre-administrador" type="text" class="form-control m-b" placeholder="Digite la sesión de administrador" required>
                                            </div>
                                            <div class="col-lg-3 form-group">
                                                <label>Nombre para ingreso.</label>
                                                <input id="nombre-logueo" type="text" class="form-control m-b" placeholder="Digite la sesión de ingreso" required>
                                            </div>
                                            <div class="col-lg-6" id="ca-botones-temas">
                                                <?php if($op->guardar): ?>
                                                    <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Temas.crear()">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Guardar
                                                    </button>
                                                <?php endif; ?>
                                                <?php if($op->actualizar): ?>
                                                    <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('temas')">
                                                        <i class="fa fa-times"></i>
                                                        Cancelar
                                                    </button>
                                                    <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Temas.actualizar()">
                                                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                        Actualizar
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                        <div id="mensaje" class="col-lg-12"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de temas</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div id="tabla" class="col-lg-12"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->

    <!-- Modal de imagen -->
    <div id="modal-imagen" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="text-align:center">
                        <h3 class="m-t-none m-b">Diseño del tema</h3>
                            <div>
                                <img id="urlImagenTema" src="" width="100%">
                                <button data-dismiss="modal" class="btn btn-sm btn-default m-t-n-xs"><strong>Cerrar</strong></button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del Modal de Eliminar -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?> 

    <script type="text/javascript" src="<?php echo e(asset('js/si/parametrizacion/tema.js')); ?>"></script>

    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Temas.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>