<div class="row">
    <div class="col-lg-12">
        <div id="message-info" class="alert alert-dismissable alert-info justificado">
            <label>
                Información.
            </label>
            <p>
                Debe llenar todos los campos que sean obligatorios <strong>(*)</strong> para poder guardar su producto.
            </p>
        </div>
    </div>
    <br>
    <div class="col-lg-12 ocultar">
        <div class="input-group" style="width: 43%;">
            <input type="text" id="search-celler" placeholder="Search" class="input-sm form-control" onkeypress="Api.Product.enterSearch(event)">
            <span class="input-group-btn">
                <button type="button" class="btn btn-sm btn-primary" onclick="Api.Product.table()">Buscar</button>
            </span>
        </div>
        <br>
        <br>
    </div>
    <div id="bd-list-cellar"></div>
    <div class="col-lg-12">
        <br>
        <br>
    </div>
    <div class="col-lg-12" id="table-location-available"></div>
</div>