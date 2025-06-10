<div class="row">
    <form id="formulario-category">
        <div class="col-lg-3">
            <div class="form-group">
                <label><span class="obligatorio">(*)</span> Nombre.</label>
                <input id="name" type="text" class="form-control m-b"
                       placeholder="Digite el nombre" maxlength="50">
            </div>
        </div>
        <div class="col-lg-9">
            <div class="form-group">
                <label>Descripción.</label>
                <input id="description" type="text" class="form-control m-b"
                       placeholder="Digite el nombre" maxlength="255">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group" id="ca-botones-category"
                 style="padding-top: 3px;">
                @if($op->guardar)
                    <button id="btn-guardar" class="btn btn-primary"
                            type="button"
                            onClick="Api.Categoria.createUpdate()">
                        <i class="fa fa-floppy-o"></i>&nbsp;
                        Guardar
                    </button>
                @endif
                @if($op->actualizar)
                    <button id="btn-cancelar" class="btn ocultar" type="button"
                            onclick="Api.Herramientas.cancelarCA('category')">
                        <i class="fa fa-times"></i>
                        Cancelar
                    </button>
                    <button id="btn-actualizar" class="btn btn-success ocultar"
                            type="button"
                            onClick="Api.Categoria.createUpdate()">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                        Actualizar
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>