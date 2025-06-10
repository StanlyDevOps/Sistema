<div id="modal-consultation-avanced" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-search-plus"></i>
                    &nbsp;
                    Busqueda avanzada
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Lista de categorias.</label>
                        <select id="mca-id-category" class="form-control" size="12"></select>
                    </div>
                    <div class="col-lg-6">
                        <label>Buscador.</label>
                        <input type="text" id="mca-search" placeholder="Digite nombre, referencia o valor a buscar" class="input-sm form-control">
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <label>Impuesto.</label>
                        <select id="mca-id-tax" class="form-control chosen-select">
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <label>Unidad.</label>
                        <select id="mca-id-unity" class="form-control chosen-select">
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <br>
                        <label>Bodega.</label>
                        <select id="mca-id-celler" class="form-control chosen-select" onchange="Api.Product.findLocation(this.value, 'mca-id-celler');">
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <br>
                        <label>Locación.</label>
                        <select id="mca-id-location" class="form-control chosen-select">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="Api.Product.avancedConsultation()">Buscar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-upload-image" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-image"></i>
                    &nbsp;
                    Subir imagen de producto
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        @if($op->importar)
                            <form method=POST action="subir-imagen" class="dropzone">
                                <input type="hidden" class="id-product" name="id">
                                <input type="hidden" name="crud" value="true">
                                <input type="hidden" name="carpetaControlador" value="Inventario">
                                <input type="hidden" name="controlador" value="Producto">
                                <input type="hidden" name="funcionesVariables" value="UpdateImage">
                                <input type="hidden" name="file_name" value="imagen">
                                <div class="fallback">
                                    <input name="imagen" type="file" />
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Api.Product.table()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-selected-location" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-thumb-tack"></i>
                    &nbsp;
                    <span id="msl-name-modal"></span> locación del producto
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="msl-form">
                        <div class="col-lg-4">
                            <label><span class="obligatorio">(*)</span> Stock Max.</label>
                            <input type="text" id="msl-stock-max" placeholder="Digite el stock max..." class="input-sm form-control formato-moneda">
                        </div>
                        <div class="col-lg-4">
                            <label><span class="obligatorio">(*)</span> Stock Min.</label>
                            <input type="text" id="msl-stock-min" placeholder="Digite el stock mín.." class="input-sm form-control formato-moneda">
                        </div>
                        <div class="col-lg-4">
                            <label><span class="obligatorio">(*)</span> Stock Existencia.</label>
                            <input type="text" id="msl-existence" placeholder="Digite la existencia" class="input-sm form-control formato-moneda">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="Api.Product.createUpdateLocation()">
                    <i class="fa fa-floppy-o"></i>
                    &nbsp;
                    Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    &nbsp;
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>