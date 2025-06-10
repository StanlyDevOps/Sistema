
Api.Locacion = {
    id: null,
    idBodega: null,
    uri: null,
    carpeta: 'Inventario',
    controlador: 'Locacion',
    nombreTabla: 'tabla-locacion',
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

        this._Consultar['id_bodega'] = this.idBodega;

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
                    {nombre: 'nombre',      edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'descripcion', edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'existencia',  edicion: false,	formato: 'numerico', alineacion:'centrado'},
                    {nombre: 'stock_min',   edicion: false,	formato: 'numerico', alineacion:'centrado'},
                    {nombre: 'stock_max',   edicion: false,	formato: 'numerico', alineacion:'centrado'},
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

                        $objeto.id = null;
                        Api.Locacion.constructor();

                        $('#modal-localizacion').modal('hide');
                    }
                }
            );
        }
    },

    editar: function(id, $informacion) {

        var contenedor  = '#modal-localizacion';
        var $AHfN       = Api.Herramientas.formatoNumerico;


        this.id = id;

        $(contenedor).find('#l-nombre').val($informacion.nombre).focus();
        $(contenedor).find('#l-existencia').val($AHfN($informacion.existencia));
        $(contenedor).find('#l-stock-minimo').val($AHfN($informacion.stock_min));
        $(contenedor).find('#l-stock-maximo').val($AHfN($informacion.stock_max));
        $(contenedor).find('#l-descripcion').val($informacion.descripcion);

        $(contenedor).modal({backdrop: 'static', keyboard: false});
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

    mostrarFormulario: function() {

        $('#modal-localizacion').modal({backdrop: 'static', keyboard: false});
    },

    verificarFormulario: function(parametros) {

        var contenedor = '#formulario-locacion';

        parametros['nombre']        = $(contenedor).find('#l-nombre').val().trim();
        parametros['descripcion']   = $(contenedor).find('#l-descripcion').val().trim();
        parametros['existencia']    = $(contenedor).find('#l-existencia').val();
        parametros['stock_min']     = $(contenedor).find('#l-stock-minimo').val();
        parametros['stock_max']     = $(contenedor).find('#l-stock-maximo').val();
        parametros['id_bodega']     = this.idBodega;
        parametros['id']            = this.id;

        if (!parametros['nombre']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar un nombre para continuar');
            return false;
        }

        if (!parametros['stock_min']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar el Stock Mínimo para continuar');
            return false;
        }

        if (!parametros['stock_max']) {
            this.$mensajeS('advertencia','Advertencia','Debe digitar el Stock Máximo para continuar');
            return false;
        }

        return parametros;
    }
};