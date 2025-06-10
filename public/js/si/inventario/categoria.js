
Api.Categoria = {
    id: null,
    idBodega: null,
    uri: null,
    carpeta: 'Inventario',
    controlador: 'Categoria',
    idMensaje: 'mensaje',
    Json: null,

    $ajaxC: Api.Ajax.constructor,
    $ajaxT: Api.Ajax.ajaxTabla,
    $ajaxS: Api.Ajax.ajaxSimple,
    $mJS: Api.Mensaje.jsonSuperior,
    $mensajeS: Api.Mensaje.superior,
    $uriCrudObjecto: Api.Uri.crudObjecto,
    $funcionalidadesT: Api.Elementos.funcionalidadesTabla(),
    $oTB: Api.Elementos.opcionesTablaBasica,

    _Consult: null,
    _CreateOrUpdate: null,
    _ActualizarOrden: null,
    _CambiarEstado: null,
    _Eliminar: null,

    constructor: function(saveJSON) {
        this._Consult	        = this.$uriCrudObjecto('Consult',this.controlador,this.carpeta);
        this._CreateOrUpdate	= this.$uriCrudObjecto('CreateOrUpdate',this.controlador,this.carpeta);
        this._ActualizarOrden	= this.$uriCrudObjecto('ActualizarOrden',this.controlador,this.carpeta);
        this._CambiarEstado     = this.$uriCrudObjecto('CambiarEstado',this.controlador,this.carpeta);
        this._Eliminar          = this.$uriCrudObjecto('Destroy',this.controlador,this.carpeta);

        str         = this.controlador;
        this.uri    = str.toLowerCase();

        this.lista(saveJSON);
    },

    lista: function(saveJSON) {

        this.$ajaxS(
            '',
            this.uri,
            this._Consult,

            function (json) {

                if (json.orden === null) {
                    console.log(json.categorias,'entró');
                }
                else {

                    if (saveJSON) {
                        Api.Categoria.Json = json;
                    }
                    else {
                        Api.Elementos.listaCategorias(
                            json.categorias,
                            json.orden,
                            'lista-categoria',
                            'listado',
                            5,
                            Api.Categoria.guardarOrden,
                            {
                                editar: {
                                    habilitado: true,
                                    metodo: 'Api.Categoria.editar'
                                },
                                eliminar: {
                                    habilitado: true,
                                    metodo: 'Api.Categoria.destroy'
                                }
                            }
                        );
                    }
                }
            }
        );
    },

    guardarOrden: function() {

        var $objeto = Api.Categoria;

        $objeto._ActualizarOrden['json'] = $('#nestable-output').val();

        $objeto.$ajaxS(
            '',
            $objeto.uri,
            $objeto._ActualizarOrden,

            function (json) {

                Api.Mensaje.jsonSuperior(json);
            }
        );
    },

    createUpdate: function() {

        var $objet = Api[this.controlador];
        var parameters = this.verifyForm(this._CreateOrUpdate);

        if (parameters) {
            this.$ajaxS(
                '',
                this.uri,
                parameters,

                function (json) {

                    Api.Mensaje.jsonSuperior(json);

                    if (json.resultado === 1) {

                        var AH = Api.Herramientas;

                        $objet.constructor();

                        AH.cancelarCA('category');

                        $('#formulario-category').find('#name').focus();

                        if(Api.Categoria.id) {
                            setTimeout(function () {
                                AH.cambiarPestanhia('tab-category', 'listado');
                            }, 1000);

                            Api.Categoria.id = null;
                        }
                    }
                }
            );
        }
    },

    editar: function(id, $informacion) {

        var container = '#formulario-category',
            $AH = Api.Herramientas;

        this.id = id;

        $(container).find('#name').val($informacion.nombre).focus();
        $(container).find('#description').val($informacion.descripcion);

        $AH.mostrarBotonesActualizar('category');
        $AH.cambiarPestanhia('tab-category','create-update');

    },

    destroy: function(id) {

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
                        $objeto.lista();
                    }
                    else {
                        swal("Error", json.mensaje , "error");
                    }
                }
            );
        });
    },

    verifyForm: function(parameters) {

        var contenedor = '#formulario-category';

        parameters['name']          = $(contenedor).find('#name').val().trim();
        parameters['description']   = $(contenedor).find('#description').val().trim();
        parameters['id']            = this.id;

        if (!parameters['name']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar un nombre para continuar');
            return false;
        }

        return parameters;
    }
};