<div class="row ml-none">
    <?php if($id_empresa == 1): ?>
        <div class="col-lg-12">
            <div class="alert alert-dismissable alert-info justificado">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <label>
                    Información.
                </label>
                <p>
                    Seleccione los módulos y las sesiones que desea habilitar para esta empresa.
                    Los módulos y sesiones que estén habilitados aparecerán en verde.
                </p>
            </div>
        </div>
    <?php endif; ?>
    <div id="modulos" class="col-lg-12">
        <div class="<?php if($id_empresa == 1): ?><?php echo e('col-lg-5'); ?><?php else: ?><?php echo e('col-lg-6'); ?><?php endif; ?>">
            <h3 align="center">Módulos</h3>
            <br>
            <div class="row">
                <div class="col-lg-12" id="tabla-modulo"></div>
            </div>
        </div>
        <?php if($id_empresa == 1): ?>
            <div class="col-lg-2 vertical text-center">
                <?php if($op->guardar): ?>
                    <div style="padding-top: 150px">
                        <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.ModuloEmpresa.agregar()">
                            <i class="fa fa-plus verde"></i>
                            <span class="bold">Agregar</span>
                        </button>
                    </div>
                <?php endif; ?>
                <br>
                <?php if($op->eliminar): ?>
                    <div>
                        <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.ModuloEmpresa.quitar()">
                            <i class="fa fa-close rojo"></i>
                            <span class="bold">Elimina</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="<?php if($id_empresa == 1): ?><?php echo e('col-lg-5'); ?><?php else: ?><?php echo e('col-lg-6'); ?><?php endif; ?>">
            <h3 align="center">Sesiones</h3>
            <br>
            <div class="row">
                <div class="col-lg-12" id="tabla-sesion"></div>
            </div>
        </div>
    </div>
</div>