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
        <br>
        <div class="col-lg-12" id="mensaje"></div>

        <div class="col-lg-4" id="contenedor-prestamos-finalizados">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Prestamos finalizados</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form id="form-prestamos-finalizados" method=POST action="reportes" onsubmit="return Api.Reportes.prestamosFinalizados();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="PrestamosFinalizados">
                            <div class="col-lg-12">
                                Reporte de prestamos finalizados por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            <?php if($op->exportar): ?>
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-relacion-prestamo">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Relación de Prestamo</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form id="form-relacion-prestamo" method=POST action="reportes" onsubmit="return Api.Reportes.relacionPrestamo();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="RelacionPrestamo">
                            <div class="col-lg-12">
                                Reporte de relación de prestamo por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            <?php if($op->exportar): ?>
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-prestamo-sin-completar">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Prestamos sin completar</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form id="form-prestamos-sin-completar" method=POST action="reportes" onsubmit="return Api.Reportes.prestamosSinCompletar();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="PrestamosSinCompletar">
                            <div class="col-lg-12">
                                Reporte de prestamos que no han sido completados por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            <?php if($op->exportar): ?>
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-recaudo-diario">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Recaudo Diario</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form id="form-recaudo-diario" method=POST action="reportes" onsubmit="return Api.Reportes.recaudoDiario();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="RecaudoDiario">
                            <div class="col-lg-12">
                                Reporte de Recaudo por día.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="form-group w200">
                                    <label>Fecha:</label>
                                    <input type="text" class="form-control datepicker" id="fecha" name="fecha">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <?php if($op->exportar): ?>
                                    <div class="text-center">
                                        <button class="btn btn-info">
                                            <i class="fa fa-cloud-download"></i>
                                            &nbsp;
                                            Generar Reporte
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="contenedor-prestamo-sin-completar">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-pdf-o fa-1x azul"></i> &nbsp;Total recaudado</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form id="form-prestamos-total-recaudado" method=POST action="reportes" onsubmit="return Api.Reportes.prestamosTotalRecaudado();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reportes">
                            <input type="hidden" name="carpetaControlador" value="Prestamo">
                            <input type="hidden" name="funcionesVariables" value="TotalRecaudado">
                            <div class="col-lg-12">
                                Reporte del total de recaudos por rango de fecha.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="col-lg-6">
                                    <label>Fecha Inicial</label>
                                </div>
                                <div class="col-lg-5">
                                    <label>Fecha Final</label>
                                </div>
                                <div class="rangedatepicker input-group col-lg-10" id="datepicker" align="center">
                                    <input type="text" class="form-control fecha-inicio" name="fecha_inicio" id="fecha-inicio">
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="form-control fecha-fin" name="fecha_fin" id="fecha-fin">
                                </div>
                            </div>
                            <br>
                            <?php if($op->exportar): ?>
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <br><br>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/si/prestamo/reportes.js')); ?>"></script>
    <script>_verificarPermisos()</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>