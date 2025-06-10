

<?php $__env->startSection('content'); ?> 
    
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-lg-12">
            <div class="text-center animated fadeInDown">
                <h1>No Existe</h1>
                <h3 class="font-bold">El contenido de la pagina no existe</h3>

                <div class="error-desc">
                    Esta intentando acceder a una sesion la cual no existe en la plataforma. <br>
                    Puede volver a la pagina principal: <br><a href="../inicio" class="btn btn-primary m-t">Inicio Stids Jeal</a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('temas.'.$empresa['nombre_administrador'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>