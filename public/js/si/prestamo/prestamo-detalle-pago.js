Api.PrestamoDetallePago = {
    id: null,
    uri: null,
    carpeta: 'Prestamo',
    controlador: 'PrestamoDetallePago',
    nombreTabla: 'tabla-prestamo-detalle-pago',
    idPrestamoDetalle: null,

    $ajaxC: Api.Ajax.constructor,
    $ajaxT: Api.Ajax.ajaxTabla,
    $mensajeS: Api.Mensaje.superior,
    $uriCrud: Api.Uri.crudObjecto,
    $funcionalidadesT: Api.Elementos.funcionalidadesTabla(),

    _Consultar: null,

    constructor: function() {
        this._Consultar = this.$uriCrud('Consultar',this.controlador,this.carpeta);

        str         = this.controlador;
        this.uri    = str.toLowerCase();

        $('#' + this.nombreTabla).html('');

        if (this.idPrestamoDetalle) {
            this.tabla();
        }
    },

    tabla: function(pagina,tamanhio) {


        this.$ajaxC(this.nombreTabla,pagina,tamanhio);

        this._Consultar['id_prestamo_detalle'] = this.idPrestamoDetalle;

        this.$ajaxT(
            this.nombreTabla,
            this.uri,
            this._Consultar,
            {
                objecto: this.controlador,
                metodo: 'tabla',
                funcionalidades: this.$funcionalidadesT,
                opciones: null,
                checkbox: false,
                columnas: [
                    {nombre: 'usuario_que_registro_el_pago', edicion: false, formato: '', alineacion:''},
                    {nombre: 'monto_pagado', edicion: false, formato: 'moneda', alineacion:'centrado'},
                    {nombre: 'estado_pago', edicion: false,	formato: '', alineacion:'centrado'},
                    {nombre: 'fecha_registro', edicion: false, formato: '', alineacion:'centrado'},
                    {nombre: 'observacion', edicion: false,	formato: '', alineacion:''}
                ],
                automatico: false
            }
        );
    }
};