
Api.Bodega = {
    id: null,
    uri: null,
    carpeta: 'Inventario',
    controlador: 'Bodega',
    nombreTabla: 'tabla-bodega',
    idMensaje: 'mensaje',

    $ajaxC: Api.Ajax.constructor,
    $ajaxT: Api.Ajax.ajaxTabla,
    $ajaxS: Api.Ajax.ajaxSimple,
    $mJS: Api.Mensaje.jsonSuperior,
    $mensajeS: Api.Mensaje.superior,
    $uriCrudObjecto: Api.Uri.crudObjecto,
    $funcionalidadesT: Api.Elementos.funcionalidadesTabla(),
    $oT: Api.Elementos.opcionesTabla,

    _Consultar: null,
    _CrearActualizar: null,
    _CambiarEstado: null,
    _Eliminar: null,

    constructor: function() {
        this._Consultar	        = this.$uriCrudObjecto('Consultar',this.controlador,this.carpeta);
        this._CrearActualizar	= this.$uriCrudObjecto('CrearActualizar',this.controlador,this.carpeta);
        this._CambiarEstado     = this.$uriCrudObjecto('CambiarEstado',this.controlador,this.carpeta);
        this._Eliminar          = this.$uriCrudObjecto('Eliminar',this.controlador,this.carpeta);

        str         = this.controlador;
        this.uri    = str.toLowerCase();

        this.tabla();
    },

    tabla: function(pagina,tamanhio) {

        this.$ajaxC(this.nombreTabla,pagina,tamanhio);

        this.$ajaxT(
            this.nombreTabla,
            this.uri,
            this._Consultar,
            {
                objecto: this.controlador,
                metodo: 'tabla',
                funcionalidades: this.$funcionalidadesT,
                opciones: this.$oT(this.controlador),
                checkbox: false,
                columnas: [
                    {nombre: 'nombre',      edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'ciudad',      edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'direccion',   edicion: false,	formato: '', alineacion:'centrado'},
                    {nombre: 'descripcion', edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'estado',      edicion: false,	formato: '', alineacion:'centrado'}
                ],
                automatico: false
            }
        );
    },

    crearActualizar: function() {

        var $objeto = Api[this.controlador];
        var parametros = this.verificarFormulario(this._CrearActualizar);

        if (parametros) {
            this.$ajaxS(
                '',
                this.uri,
                parametros,

                function (json) {

                    Api.Mensaje.jsonSuperior(json);

                    if (json.resultado === 1) {

                        var AH = Api.Herramientas;

                        $objeto.id = null;
                        Api.Bodega.constructor();

                        AH.cancelarCA('bodega');
                        AH.cambiarPestanhia('pestanhia-bodega','listado');
                    }
                }
            );
        }
    },

    editar: function(id, $informacion) {

        var contenedor  = '#crear-editar';
        var AH          = Api.Herramientas;

        this.id = id;

        $(contenedor).find('#nombre').val($informacion.nombre).focus();
        $(contenedor).find('#direccion').val($informacion.direccion);
        $(contenedor).find('#ciudad').val($informacion.ciudad);
        $(contenedor).find('#id-municipio').val($informacion.id_municipio);
        $(contenedor).find('#descripcion').val($informacion.descripcion);

        AH.cambiarPestanhia('pestanhia-bodega','crear-editar');
        AH.mostrarBotonesActualizar('bodega');
    },

    cambiarEstado: function(id) {

        var $objeto = Api[this.controlador];

        this._CambiarEstado['id'] = id;

        this.$ajaxS(
            '',
            this.uri,
            this._CambiarEstado,

            function () {

                $objeto.tabla();
            }
        );
    },

    eliminar: function(id) {

        var $objeto = Api[this.controlador];

        this._Eliminar['id'] = id;

        swal({
            title: "¿Seguro que desea eliminarlo?",
            text: "Después de eliminarlo no podrás recuperar esta información ni revertir los cambios!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, deseo eliminarlo",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        }, function () {

            $objeto.$ajaxS(
                '',
                $objeto.uri,
                $objeto._Eliminar,

                function (json) {

                    if (json.resultado === 1) {

                        swal("Eliminado!", json.mensaje, "success");
                        $objeto.tabla();
                    }
                    else {
                        swal("Error", json.mensaje , "error");
                    }
                }
            );
        });
    },

    detalle: function(id,$informacion) {

        var $AE = Api.Elementos;
        var $AH = Api.Herramientas;
        var contenedor = '#detalle';

        $(contenedor).find('#detalle-nombre').text($informacion.nombre);
        $(contenedor).find('#detalle-direccion').text($informacion.direccion);
        $(contenedor).find('#detalle-ciudad').text($informacion.ciudad);
        $(contenedor).find('#detalle-estado').html($informacion.estado === '1' ? $AE.botonActivo : $AE.botonInactivo);
        $(contenedor).find('#detalle-descripcion').text($informacion.descripcion);

        Api.Locacion.idBodega = id;
        Api.Locacion.constructor();

        $AH.cambiarPestanhia('pestanhia-bodega','detalle');
    },

    verificarFormulario: function(parametros) {

        var contenedor = '#pestanhia-bodega #crear-editar';

        parametros['nombre']        = $(contenedor).find('#nombre').val().trim();
        parametros['direccion']     = $(contenedor).find('#direccion').val().trim();
        parametros['id_municipio']  = $(contenedor).find('#id-municipio').val().trim();
        parametros['descripcion']   = $(contenedor).find('#descripcion').val().trim();
        parametros['id']            = this.id;

        if (!parametros['nombre']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar un nombre para continuar');
            return false;
        }

        if (!parametros['descripcion']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar el porcentaje para continuar');
            return false;
        }

        return parametros;
    }
};