<div class="row">
    <form id="formulario-table">
        <div class="col-lg-12">
            <div class="form-group">
                <label><span class="obligatorio">(*)</span> Nombre.</label>
                <input id="name" type="text" class="form-control m-b" placeholder="Digite el nombre" maxlength="50">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label>Descripción.</label>
                <textarea id="description" class="form-control m-b" rows="6" placeholder="Digite una descripción..."></textarea>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group" id="ca-botones-table" style="padding-top: 3px;">
                <?php if($op->guardar): ?>
                    <button id="btn-guardar" class="btn btn-primary"
                            type="button"
                            onClick="Api.Tables.createUpdate()">
                        <i class="fa fa-floppy-o"></i>&nbsp;
                        Guardar
                    </button>
                <?php endif; ?>
                <?php if($op->actualizar): ?>
                    <button id="btn-cancelar" class="btn ocultar" type="button"
                            onclick="Api.Herramientas.cancelarCA('table')">
                        <i class="fa fa-times"></i>
                        Cancelar
                    </button>
                    <button id="btn-actualizar" class="btn btn-success ocultar"
                            type="button"
                            onClick="Api.Tables.createUpdate()">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                        Actualizar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>