<div class="row ml-none">
    @if($id_empresa == 1)
        <div class="col-lg-12">
            <div class="alert alert-dismissable alert-info justificado">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <label>
                    Información.
                </label>
                <p>
                    Seleccione los módulos y las sesiones que desea habilitar para esta empresa.
                    Los módulos y sesiones que estén habilitados aparecerán en verde.
                </p>
            </div>
        </div>
    @endif
    <div id="modulos" class="col-lg-12">
        <div class="@if($id_empresa == 1){{'col-lg-5'}}@else{{'col-lg-6'}}@endif">
            <h3 align="center">Módulos</h3>
            <br>
            <div class="row">
                <div class="col-lg-12" id="tabla-modulo"></div>
            </div>
        </div>
        @if($id_empresa == 1)
            <div class="col-lg-2 vertical text-center">
                @if($op->guardar)
                    <div style="padding-top: 150px">
                        <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.ModuloEmpresa.agregar()">
                            <i class="fa fa-plus verde"></i>
                            <span class="bold">Agregar</span>
                        </button>
                    </div>
                @endif
                <br>
                @if($op->eliminar)
                    <div>
                        <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.ModuloEmpresa.quitar()">
                            <i class="fa fa-close rojo"></i>
                            <span class="bold">Elimina</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif
        <div class="@if($id_empresa == 1){{'col-lg-5'}}@else{{'col-lg-6'}}@endif">
            <h3 align="center">Sesiones</h3>
            <br>
            <div class="row">
                <div class="col-lg-12" id="tabla-sesion"></div>
            </div>
        </div>
    </div>
</div>