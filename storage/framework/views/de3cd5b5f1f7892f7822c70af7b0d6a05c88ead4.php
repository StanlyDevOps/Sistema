<?php $__env->startSection('content'); ?>
    <?php ($idPadre = $_REQUEST['padre']); ?>
    <?php ($idHijo = $_REQUEST['hijo']); ?>
    <?php echo $__env->make('functions.father-son', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('functions.father-son-headboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <br>
        <div class="col-lg-12" id="message"></div>

        <div class="col-lg-4">
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
                        <form id="form-daily-collection" method=POST action="reports" onsubmit="return Api.Reports.dailyCollection();" target="_blank">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="crud" value="true">
                            <input type="hidden" name="controlador" value="Reports">
                            <input type="hidden" name="carpetaControlador" value="Sales">
                            <input type="hidden" name="funcionesVariables" value="DailyCollection">
                            <div class="col-lg-12">
                                Reporte de Recaudo por día seleccionado.
                                <br>
                                <br>
                            </div>
                            <div align="center">
                                <div class="form-group w200">
                                    <label>Fecha:</label>
                                    <input type="text" class="form-control datepicker" name="date">
                                </div>
                            </div>
                            <?php if($op->exportar): ?>
                            <div class="form-group col-lg-12">
                                <div class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-cloud-download"></i>
                                        &nbsp;
                                        Generar Reporte
                                    </button>
                                </div>
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
    <script type="text/javascript" src="<?php echo e(asset('js/si/sales/reports.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>