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