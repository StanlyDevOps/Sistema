

<?php $__env->startSection('content'); ?>
    <?php ($idPadre = $_REQUEST['padre']); ?>
	<?php echo $__env->make('functions.father', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('functions.father-headboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('functions.index-modules', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>