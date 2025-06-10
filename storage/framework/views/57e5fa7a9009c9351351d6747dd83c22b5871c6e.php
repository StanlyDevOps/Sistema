<div class="row">
    <form id="formulario-take-order">
        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label>Mesa.</label>
                <select id="table" type="text" class="form-control m-b chosen-select">
                </select>
            </div>
            <div class="form-group">
                <label>Comentarios.</label>
                <textarea id="description" class="form-control m-b" rows="6" placeholder="Digite una descripción..."></textarea>
            </div>
            <div class="form-group" id="ca-botones-take-order" style="padding-top: 3px;">
                <?php if($op->guardar): ?>
                    <button id="btn-guardar" class="btn btn-primary"
                            type="button"
                            onClick="Api.Order.createUpdate()">
                        <i class="fa fa-floppy-o"></i>&nbsp;
                        Guardar
                    </button>
                <?php endif; ?>
                <?php if($op->actualizar): ?>
                    <button id="btn-cancelar" class="btn ocultar" type="button"
                            onclick="Api.Herramientas.cancelarCA('take-order'); Api.Order.cleanProducts()">
                        <i class="fa fa-times"></i>
                        Cancelar
                    </button>
                    <button id="btn-actualizar" class="btn btn-success ocultar"
                            type="button"
                            onClick="Api.Order.createUpdate()">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                        Actualizar
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-8 col-sm-8 col-xs-12" id="content-products">
            <div class="col-lg-9 col-sm-8 col-xs-7">
                <label>
                    <span class="obligatorio">(*)</span>
                    Productos.
                </label>
            </div>
            <div class="col-lg-3 col-sm-4 col-xs-5">
                <label>
                    <span class="obligatorio">(*)</span>
                    Cantidad.
                </label>
            </div>
            <div class="row-product">
                <div class="col-lg-9 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select id="products-init" type="text" class="form-control m-b chosen-select select-products"
                                data-id-product=""
                                data-id-previous=""
                                onchange="Api.Order.AddOrRemoveProducts(this.value)">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 col-xs-5">
                    <div class="form-group">
                        <input type="text" class="form-control m-b quantity numerico formato-solo-numeros" placeholder="000" maxlength="10" data-id-quantity="">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>