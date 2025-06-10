<div class="row">
    <form id="formulario-invoice">
        <div class="form-group col-lg-5 col-sm-12 col-xs-12">
            <div class="form-group col-lg-12 col-sm-12 col-xs-12">
                <label>
                    <span class="obligatorio">(*)</span>
                    No. Pedido.
                </label>
                <select id="id-order" class="form-control m-b chosen-select" onchange="Api.Invoice.showPrice(this.value)"></select>
            </div>
            <div class="form-group col-lg-12 col-sm-12 col-xs-12">
                <label>Tarjeta.</label>
                <select id="id-type-card" class="form-control m-b chosen-select"></select>
            </div>
            <div class="form-group col-lg-12 col-sm-12 col-xs-12">
            <label>Efectivo.</label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">$</span>
                <input id="cash" type="text" class="form-control m-b formato-numerico" placeholder="000,000,000" maxlength="10">
                <span class="input-group-addon" id="id-total-pagar">$000,000,000</span>
            </div>
        </div>
        </div>
        <div class="form-group col-lg-7 col-sm-12 col-xs-12">
            <div class="form-group col-lg-12 col-sm-12 col-xs-12">
                <label>Comentarios.</label>
                <textarea id="description" class="form-control m-b" rows="8" placeholder="Digite un comentario..."></textarea>
            </div>
        </div>
        <div class="form-group col-lg-12 col-sm-12 col-xs-12" id="ca-botones-invoice" style="padding-top: 3px;">
            <?php if($op->guardar): ?>
                <button id="btn-guardar" class="btn btn-primary"
                        type="button"
                        onClick="Api.Invoice.createUpdate()">
                    <i class="fa fa-floppy-o"></i>&nbsp;
                    Guardar
                </button>
            <?php endif; ?>
            <?php if($op->actualizar): ?>
                <button id="btn-cancelar" class="btn ocultar" type="button"
                        onclick="Api.Herramientas.cancelarCA('invoice'); Api.Order.cleanProducts()">
                    <i class="fa fa-times"></i>
                    Cancelar
                </button>
                <button id="btn-actualizar" class="btn btn-success ocultar"
                        type="button"
                        onClick="Api.Invoice.createUpdate()">
                    <i class="fa fa-pencil-square-o"></i>&nbsp;
                    Actualizar
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>
