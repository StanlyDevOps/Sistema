<div id="clone-row-product" class="ocultar">
    <div class="row-product remove-row">
        <div class="col-lg-9 col-sm-8 col-xs-7">
            <div class="form-group">
                <select id="products-clone" type="text" class="form-control m-b select-products"
                        data-id-product=""
                        data-id-previous=""
                        onchange="Api.Order.AddOrRemoveProducts(this.value)">
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-5">
            <div class="form-group">
                <input type="text" class="form-control m-b quantity" placeholder="000" maxlength="10" data-id-quantity="">
            </div>
        </div>
    </div>
</div>