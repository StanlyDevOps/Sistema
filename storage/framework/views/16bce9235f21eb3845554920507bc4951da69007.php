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

            <div class="col-lg-12" align="center">
                <br>
                <div class="btn-group">
                    <button id="btn-general" class="btn btn-white active" onclick="Api.Permisos.mostrarContenedor(2)">
                        <i class="fa fa-list-alt"></i>
                        General
                    </button>
                    <button id="btn-personal" class="btn btn-white" onclick="Api.Permisos.mostrarContenedor(1)">
                        <i class="fa fa-user-secret "></i>
                        Independiente
                    </button>
                </div>
                <br>
                <br>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-4 permiso-general">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de roles</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12" id="tabla-rol"></div>
                                        <div class="col-lg-12 centrado">
                                            <?php if($op->exportar): ?>
                                                <form id="formulario-reporte-permiso" method=POST action="reportes" target="_blank">
                                                    <?php echo e(csrf_field()); ?>

                                                    <input type="hidden" name="id_empresa" value="<?php echo e($id_empresa); ?>">
                                                    <input type="hidden" name="crud" value="true">
                                                    <input type="hidden" name="controlador" value="Reportes">
                                                    <input type="hidden" name="carpetaControlador" value="Parametrizacion">
                                                    <input type="hidden" name="funcionesVariables" value="PermisosPorEmpresa">
                                                    <button class="btn btn-info" type="submit">
                                                        <i class="fa fa-cloud-download"></i>&nbsp;
                                                        Exportar todos los permisos
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 permiso-general">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Módulos <span id="titulo"></span></h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12" id="tabla-modulos"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 permiso-personal ocultar">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Permisos independiente</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Usuario.</label>
                                                <select id="id-usuario" class="form-control m-b chosen-select"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Módulos.</label>
                                                <select id="id-modulo-empresa" class="form-control m-b chosen-select"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <br>
                                            <div style="margin-top: 4px;">
                                                <button onclick="Api.Permisos.activarBoton(1,'btn-primary','verde')" id="btn-permiso-1" data-activo="0" type="button" class="btn btn-white" title="Crear">
                                                    <i class="fa fa-floppy-o verde"></i>
                                                </button>
                                                <button onclick="Api.Permisos.activarBoton(2,'btn-success','azul')" id="btn-permiso-2" data-activo="0" type="button" class="btn btn-white" title="Actualizar">
                                                    <i class="fa fa-pencil-square-o azul"></i>
                                                </button>
                                                <button onclick="Api.Permisos.activarBoton(3,'btn-warning','naranja')" id="btn-permiso-3" data-activo="0" type="button" class="btn btn-white" title="Activar y desactivar">
                                                    <i class="fa fa-toggle-on naranja"></i>
                                                </button>
                                                <button onclick="Api.Permisos.activarBoton(4,'btn-danger','rojo')" id="btn-permiso-4" data-activo="0" type="button" class="btn btn-white" title="Eliminar">
                                                    <i class="fa fa-trash rojo"></i>
                                                </button>
                                                <button onclick="Api.Permisos.activarBoton(5,'btn-info','azul-claro')" id="btn-permiso-5" data-activo="0" type="button" class="btn btn-white" title="Exportar archivo">
                                                    <i class="fa fa-cloud-download azul-claro"></i>
                                                </button>
                                                <button onclick="Api.Permisos.activarBoton(6,'btn-info','azul-claro')" id="btn-permiso-6" data-activo="0" type="button" class="btn btn-white" title="Importar archivo">
                                                    <i class="fa fa-cloud-upload azul-claro"></i>
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <?php if($op->guardar): ?>
                                                    <button id="btn-guardar" class="btn btn-primary" type="button" onclick="Api.Permisos.crear()">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Guardar
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" id="mensaje-pp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 permiso-personal ocultar">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Consultar permisos por usuario</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Usuario.</label>
                                                <select id="id-usuario-consultar" class="form-control m-b chosen-select" onchange="Api.Permisos.consultarPermisos(this.value)"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                        </div>
                                        <div class="col-lg-12" id="tabla-permiso-personal"></div>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/si/parametrizacion/permisos.js')); ?>"></script>

    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Permisos.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>