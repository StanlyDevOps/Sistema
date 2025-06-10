<div class="project-list">
    <div class="row m-b-sm m-t-sm">
        <div class="col-md-10">
            <div class="input-group">
                <input type="text" id="search" placeholder="Search" class="input-sm form-control" onkeypress="Api.Product.enterSearch(event)">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-sm btn-primary" onclick="Api.Product.table()">Buscar</button>
                </span>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" id="loading-example-btn " class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-consultation-avanced">
                <i class="fa fa-search-plus"></i>
                Busqueda Avanzada
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="table-product" class="table table-hover">
        </table>
    </div>
    <div id="message"></div>
    <div id="pagination-product">
    </div>
</div>