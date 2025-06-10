<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                <tr>
                    <th class="centrado" colspan="4">Información de la bodega</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="10%"><strong>Nombre.</strong></td>
                    <td width="40%" id="detalle-nombre"></td>
                    <td width="10%"><strong>Direccion.</strong></td>
                    <td width="40%" id="detalle-direccion"></td>
                </tr>
                <tr>
                    <td width="10%"><strong>Ciudad.</strong></td>
                    <td width="40%" id="detalle-ciudad"></td>
                    <td width="10%"><strong>Estado.</strong></td>
                    <td width="40%" id="detalle-estado"></td>
                </tr>
                <tr>
                    <td width="10%"><strong>Descripción.</strong></td>
                    <td colspan="3" width="40%" id="detalle-descripcion"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="alert alert-dismissable alert-info justificado">
            <label>
                Información para las localizaciones.
            </label>
            <p>
                Aquí podrá administrar las localizaciones o ubicaciones de sus productos.
                Si desea agregar una nueva localización presione
                <strong onclick="Api.Locacion.mostrarFormulario()" class="apuntar">
                    Aquí.
                </strong>
                Se mostrará un listado de las diferentes localizaciones que tiene la bodega
                seleccionada para llevar el orde de sus productos.
            </p>
        </div>
    </div>
    <div class="col-lg-12" id="tabla-locacion"></div>
</div>