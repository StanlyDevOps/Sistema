

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('temas/stids/librerias/nestable/nestable.css')); ?>">
<?php $__env->stopSection(); ?>

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
                        <div id="tab-category" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#listado"><i class="fa fa-list" aria-hidden="true"></i> Lista de categorias</a></li>
                                <li class=""><a data-toggle="tab" href="#create-update"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crear o Editar</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="listado" class="tab-pane active">
                                    <div class="panel-body">
                                        <?php echo $__env->make('inventario.category.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                </div>
                                <div id="create-update" class="tab-pane">
                                    <div id="listado" class="tab-pane active">
                                        <div class="panel-body">
                                            <?php echo $__env->make('inventario.category.create-update', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
    <script type="text/javascript" src="<?php echo e(asset('temas/stids/librerias/nestable/nestable.js?v1.0')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/si/inventario/categoria.js?v1.0')); ?>"></script>

    <script>
        Api.permisos = [<?php echo e($permisos); ?>];
        Api.Categoria.constructor();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>