
Api.Impuesto = {
    id: null,
    uri: null,
    carpeta: 'Inventario',
    controlador: 'Impuesto',
    nombreTabla: 'tabla-impuesto',
    idMensaje: 'mensaje',

    $ajaxC: Api.Ajax.constructor,
    $ajaxT: Api.Ajax.ajaxTabla,
    $ajaxS: Api.Ajax.ajaxSimple,
    $mJS: Api.Mensaje.jsonSuperior,
    $mensajeS: Api.Mensaje.superior,
    $uriCrudObjecto: Api.Uri.crudObjecto,
    $funcionalidadesT: Api.Elementos.funcionalidadesTabla(),
    $oTB: Api.Elementos.opcionesTablaBasica,

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
                opciones: this.$oTB(this.controlador),
                checkbox: false,
                columnas: [
                    {nombre: 'nombre',  edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'valor',   edicion: false,	formato: 'porcentaje', alineacion:'centrado'},
                    {nombre: 'estado',  edicion: false,	formato: '', alineacion:'centrado'}
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
                        Api.Impuesto.constructor();

                        AH.cancelarCA('impuesto');
                    }
                }
            );
        }
    },

    editar: function(id, $informacion) {

        var contenedor = '#impuesto';
        this.id = id;

        $(contenedor).find('#nombre').val($informacion.nombre).focus();
        $(contenedor).find('#valor').val($informacion.valor);

        Api.Herramientas.mostrarBotonesActualizar('impuesto');
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

    verificarFormulario: function(parametros) {

        var contenedor = '#impuesto ';

        parametros['nombre'] = $(contenedor + '#nombre').val();
        parametros['valor']  = $(contenedor + '#valor').val();
        parametros['id']     = this.id;

        if (!parametros['nombre']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar un nombre para continuar');
            return false;
        }

        if (!parametros['valor']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar el porcentaje para continuar');
            return false;
        }

        return parametros;
    }
};