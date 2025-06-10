<?php $__env->startSection('content'); ?>
    <?php ($idPadre = $_REQUEST['padre']); ?>
    <?php ($idHijo = $_REQUEST['hijo']); ?>
    <?php echo $__env->make('functions.father-son', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('functions.father-son-headboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-6" id="impuesto">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Impuesto</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content inspinia-timeline" style="display: block;">
                                    <div class="timeline-item">
                                        <div class="row">
                                            <form id="formulario-impuesto">
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label><span class="obligatorio">(*)</span> Nombre.</label>
                                                        <input id="nombre" type="text" class="form-control m-b" placeholder="Digite el nombre" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label><span class="obligatorio">(*)</span> %</label>
                                                        <input id="valor" type="text" class="form-control m-b formato-porcentaje" placeholder="00.0">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group" id="ca-botones-impuesto" style="padding-top: 3px;">
                                                        <?php if($op->guardar): ?>
                                                            <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Impuesto.crearActualizar()">
                                                                <i class="fa fa-floppy-o"></i>&nbsp;
                                                                Guardar
                                                            </button>
                                                        <?php endif; ?>
                                                        <?php if($op->actualizar): ?>
                                                            <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('impuesto')">
                                                                <i class="fa fa-times"></i>
                                                                Cancelar
                                                            </button>
                                                            <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Impuesto.crearActualizar()">
                                                                <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                                Actualizar
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-lg-12"><br></div>
                                            <div class="col-lg-12" id="tabla-impuesto"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" id="unidades">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Unidades</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content inspinia-timeline" style="display: block;">
                                    <div class="timeline-item">
                                        <div class="row">
                                            <form id="formulario-unidades">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label><span class="obligatorio">(*)</span> Unidad.</label>
                                                        <input id="unidad" type="text" class="form-control m-b" placeholder="Lb" maxlength="5">
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label>Descripción.</label>
                                                        <input id="descripcion" type="text" class="form-control m-b" placeholder="Digite la descripcion">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group" id="ca-botones-unidades" style="padding-top: 3px;">
                                                        <?php if($op->guardar): ?>
                                                            <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Unidades.crearActualizar()">
                                                                <i class="fa fa-floppy-o"></i>&nbsp;
                                                                Guardar
                                                            </button>
                                                        <?php endif; ?>
                                                        <?php if($op->actualizar): ?>
                                                            <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('unidades')">
                                                                <i class="fa fa-times"></i>
                                                                Cancelar
                                                            </button>
                                                            <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Unidades.crearActualizar()">
                                                                <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                                Actualizar
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="col-lg-12"><br></div>
                                            <div class="col-lg-12" id="tabla-unidades"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/si/inventario/impuesto.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/si/inventario/unidades.js')); ?>"></script>

    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Impuesto.constructor();
        Api.Unidades.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>