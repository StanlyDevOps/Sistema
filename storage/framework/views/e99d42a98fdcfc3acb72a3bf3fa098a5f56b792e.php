
<form id="formulario-product">
    <div class="col-lg-6">
        <label><span class="obligatorio">(*)</span> Lista de categorias.</label>
        <select id="id-category" class="form-control" size="20"></select>
    </div>
    <div class="col-lg-6">
        <br>
        <label><span class="obligatorio">(*)</span> Nombre.</label>
        <input type="text" id="name" placeholder="Digite el nombre" class="input-sm form-control">
    </div>
    <div class="col-lg-3">
        <br>
        <label><span class="obligatorio">(*)</span> Referencia.</label>
        <input type="text" id="reference" placeholder="Digite la referencia" class="input-sm form-control">
    </div>
    <div class="col-lg-3">
        <br>
        <label><span class="obligatorio">(*)</span> Valor.</label>
        <input type="text" id="value" placeholder="Digite el valor" class="input-sm form-control">
    </div>
    <div class="col-lg-3">
        <br>
        <label><span class="obligatorio">(*)</span> Impuesto.</label>
        <select id="id-tax" class="form-control chosen-select">
        </select>
    </div>
    <div class="col-lg-3">
        <br>
        <label><span class="obligatorio">(*)</span> Unidad.</label>
        <select id="id-unity" class="form-control chosen-select">
        </select>
    </div>
    <div class="col-lg-6">
        <br>
        <label>Descripción.</label>
        <textarea id="id-description" class="form-control" rows="5"></textarea>
    </div>
    <div class="col-lg-6">
        <br>
        <div class="form-group" id="ca-botones-product">
            <?php if($op->guardar): ?>
                <button id="btn-guardar" class="btn btn-primary"
                        type="button"
                        onClick="Api.Product.createUpdate()">
                    <i class="fa fa-floppy-o"></i>&nbsp;
                    Guardar
                </button>
            <?php endif; ?>
            <?php if($op->actualizar): ?>
                <button id="btn-cancelar" class="btn ocultar" type="button"
                        onclick="Api.Herramientas.cancelarCA('product')">
                    <i class="fa fa-times"></i>
                    Cancelar
                </button>
                <button id="btn-actualizar" class="btn btn-success ocultar"
                        type="button"
                        onClick="Api.Product.createUpdate()">
                    <i class="fa fa-pencil-square-o"></i>&nbsp;
                    Actualizar
                </button>
            <?php endif; ?>
        </div>
    </div>
</form>