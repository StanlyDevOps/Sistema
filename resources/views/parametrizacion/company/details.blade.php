<div class="panel-body">
    <div class="row ml-none">
        <div class="col-lg-12">
            <div class="col-lg-2 form-group">
                <label>Código.</label>
                <input id="codigo" type="text" class="form-control" maxlength="10">
            </div>
            <div class="col-lg-4 form-group">
                <label>Ciudad.</label>
                <input id="ciudad" type="text" class="form-control autocompletar-ciudades-2" data-id="id-municipio" data-name="municipio">
            </div>
            <div class="col-lg-6 form-group">
                <label>Nombre Sucursal.</label>
                <input id="nombre" type="text" class="form-control" placeholder="Digite el nombre de la sucursal" maxlength="50">
            </div>
            <div class="col-lg-6 form-group">
                <label>Teléfono.</label>
                <input id="telefono" type="text" class="form-control" placeholder="Digite el teléfono de la sucursal" maxlength="50">
            </div>
            <div class="col-lg-6 form-group">
                <label>Dirección.</label>
                <input id="direccion" type="text" class="form-control" placeholder="Digite el nombre de la sucursal" maxlength="60">
            </div>
            <div class="col-lg-6 form-group">
                <label>¿Quienes somos?</label>
                <textarea id="quienes-somos" class="form-control m-b" placeholder="Digite quienes son?" rows="6"></textarea>
            </div>
            <div class="col-lg-6 form-group">
                <label>¿Que hacemos?</label>
                <textarea id="que-hacemos" class="form-control m-b" placeholder="Digite que hacen?" rows="6"></textarea>
            </div>
            <div class="col-lg-6 form-group">
                <label>Misión</label>
                <textarea id="mision" class="form-control m-b" placeholder="Cuál es su Misión?" rows="6"></textarea>
            </div>
            <div class="col-lg-6 form-group">
                <label>Visión</label>
                <textarea id="vision" class="form-control m-b" placeholder="Cuál es su Visión?" rows="6"></textarea>
            </div>
            <div class="col-lg-5">
                @if($op->guardar)
                    <button id="botonActualizarSucursal" class="btn btn-success" type="button" onclick="Api.Sucursal.actualizar()">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                        Actualizar
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>