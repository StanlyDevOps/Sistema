<div class="row">
    <div class="col-lg-12">
        <form id="formulario-bodega">
            <div class="col-lg-4">
                <div class="form-group">
                    <label><span class="obligatorio">(*)</span> Nombre.</label>
                    <input id="nombre" type="text" class="form-control m-b" placeholder="Digite el nombre" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Direccion.</label>
                    <input id="direccion" type="text" class="form-control m-b" placeholder="Digite la dirección" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Ciudad.</label>
                    <input id="ciudad" type="text" class="form-control autocompletar-ciudades" data-id="id-municipio" data-name="municipio">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label>Descripcion.</label>
                    <textarea rows="3" id="descripcion" class="form-control m-b" placeholder="Digite una breve descripción" required></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group" id="ca-botones-bodega">
                    <br style="">
                    <?php if($op->guardar): ?>
                        <button class="btn btn-primary btn-guardar" type="button" onClick="Api.Bodega.crearActualizar()">
                            <i class="fa fa-floppy-o"></i>&nbsp;
                            Guardar
                        </button>
                    <?php endif; ?>
                    <?php if($op->actualizar): ?>
                        <button class="btn ocultar btn-cancelar" type="button" onclick="Api.Herramientas.cancelarCA('usuario')">
                            <i class="fa fa-times"></i>
                            Cancelar
                        </button>
                        <button class="btn btn-success ocultar btn-actualizar" type="button" onClick="Api.Bodega.crearActualizar()">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;
                            Actualizar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <br>
    </div>
</div>