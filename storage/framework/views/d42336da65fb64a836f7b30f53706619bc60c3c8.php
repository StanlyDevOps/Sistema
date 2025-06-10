<?php $__env->startSection('content'); ?>
    <?php ($idPadre = $_REQUEST['padre']); ?>
    <?php ($idHijo = $_REQUEST['hijo']); ?>
    <?php echo $__env->make('functions.father-son', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('functions.father-son-headboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12 pad-bot-20">
                        <div id="tab-make-payment" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#list"><i class="fa fa-list" aria-hidden="true"></i> Listado</a></li>
                                <li class=""><a data-toggle="tab" href="#create"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="list" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="grid-invoice"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="create" class="tab-pane">
                                    <div class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php echo $__env->make('sales.make-payment.create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/si/sales/invoice.js')); ?>"></script>

    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Invoice.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>