
Api.Product = {
    id: null,
    idCeller: null,
    idLocation: null,
    idProductLocation: null,
    uri: null,
    file: 'Inventario',
    controller: 'Producto',
    controllerJs: 'Product',
    tableNameLocation: 'table-location-available',
    assetImages: null,
    assetTheme: null,

    $ajaxC: Api.Ajax.constructor,
    $ajaxT: Api.Ajax.ajaxTabla,
    $ajaxS: Api.Ajax.ajaxSimple,
    $mJS: Api.Mensaje.jsonSuperior,
    $mS: Api.Mensaje.superior,
    $uriCrudObject: Api.Uri.crudObjecto,
    $functionalitiesT: Api.Elementos.funcionalidadesTabla(),

    _Consult: null,
    _CreateOrUpdate: null,
    _ChangeStatus: null,
    _Delete: null,
    _FindActiveByCeller: null,
    _AvancedConsultation: null,
    _FindAvaliableByCeller: null,
    _CreateOrUpdateLocation: null,
    _DeleteLocation: null,

    constructor: function() {
        this._Consult	            = this.$uriCrudObject('Consult',this.controller,this.file);
        this._AvancedConsultation   = this.$uriCrudObject('AvancedConsultation',this.controller,this.file);
        this._CreateOrUpdate  	    = this.$uriCrudObject('CreateOrUpdate',this.controller,this.file);
        this._ChangeStatus          = this.$uriCrudObject('ChangeStatus',this.controller,this.file);
        this._Delete                = this.$uriCrudObject('Delete',this.controller,this.file);

        this._FindActiveByCeller    = this.$uriCrudObject('FindActiveByCeller','Locacion',this.file);
        this._FindAvaliableByCeller = this.$uriCrudObject('FindAvaliableByCeller','Locacion',this.file);

        this._CreateOrUpdateLocation = this.$uriCrudObject('CreateOrUpdate', 'ProductoLocacion',this.file);
        this._DeleteLocation         = this.$uriCrudObject('Delete', 'ProductoLocacion',this.file);

        str         = this.controller;
        this.uri    = str.toLowerCase();

        Api.Categoria.constructor(true);

        this.table();
        this.category();
    },

    table: function(page, size) {

        this._Consult['buscador'] = $('#search').val();
        this._Consult['tamanhio'] = !size ? 10 : size;
        this._Consult['pagina']   = !page ? 1  : page;

        this.$ajaxS(
            '',
            this.uri,
            this._Consult,

            function (Json) {
                Api.Product.createTable(Json, size);
                Api.Product.setFilterFields(Json);
                Api.Product.setCellar(Json.celler);
            }
        );
    },

    avancedConsultation: function(page, size) {

        this._AvancedConsultation['buscador']    = $('#mca-search').val();
        this._AvancedConsultation['id_category'] = $('#mca-id-category').val();
        this._AvancedConsultation['id_tax']      = $('#mca-id-tax').val();
        this._AvancedConsultation['id_unity']    = $('#mca-id-unity').val();
        this._AvancedConsultation['id_location'] = $('#mca-id-location').val();
        this._AvancedConsultation['id_celler']   = $('#mca-id-celler').val();

        this._AvancedConsultation['tamanhio']    = !size ? 10 : size;
        this._AvancedConsultation['pagina']      = !page ? 1  : page;

        this.$ajaxS(
            '',
            this.uri,
            this._AvancedConsultation,

            function (Json) {
                Api.Product.createTable(Json, size);
                Api.Product.setFilterFields(Json);
            }
        );
    },

    createTable: function(json, size) {

        var table = '#table-product',
            $body = $(table).html('').append('<tbody></tbody>').find('tbody');

        $('#message').html('');

        if (json.total) {

            var
                percent = null,
                colorPB = null,
                self    = Api.Product,
                AHfM    = Api.Herramientas.formatoMoneda,
                AHfN    = Api.Herramientas.formatoNumerico,
                AHnNN   = Api.Herramientas.notNullNumeric,
                AHnN    = Api.Herramientas.noNull,
                AEcO    = Api.Elementos.crearOpciones,
                AEcP    = Api.Elementos.crearPaginacion,
                product = null;

            $.each(json.data, function(k, i) {

                if (product !== i.id || (product === i.id && i.status_product_location !== '-1')) {

                    product = i.id;

                    $body.append('<tr></tr>');

                    // Add image
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last').addClass('size-image-product')
                        .append('<img>').find('img')
                        .attr('alt', 'Imagen')
                        .addClass('img-circle')
                        .attr('src', self.assetImages + i.imagen);

                    // Second columm
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last').addClass('project-title').addClass('izquierda')
                        .append('<a></a>').find('a').text(i.nombre).append('<br>').parent()
                        .append('<strong></strong>').find('strong:last').text('Bodega. ').parent().append(AHnN(i.bodega)).append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Locacion. ').parent().append(AHnN(i.locacion));

                    // First columm
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last').addClass('project-title').addClass('izquierda')
                        .append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Referencia. ').parent().append(i.referencia).append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Creación. ').parent().append(i.fecha_alteracion);

                    // Third columm
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last').addClass('project-title').addClass('izquierda')
                        .append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Valor. ').parent().append(AHfM(i.valor)).append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Impuesto. ').parent().append(i.impuesto_valor + '%');

                    // Fourth columm
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last').addClass('izquierda')
                        .append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Stock. ').parent().append(AHfN(AHnNN(i.stock_max))).append('<br>')
                        .append('<strong></strong>').find('strong:last').text('Existencia. ').parent().append(AHfN(AHnNN(i.existence)));

                    // Fifth quater
                    if (i.stock_max === null || i.status_product_location === '-1') {
                        $body.find('tr:last')
                            .append('<td></td>').find('td:last').addClass('text-center')
                            .text('Sin localización.')
                    }
                    else {

                        percent = Math.round(parseInt(i.existence) / parseInt(i.stock_max) * 100);

                        if (parseInt(i.existence) <= parseInt(i.stock_min)) {
                            colorPB = 'progress-bar-red';
                        }
                        else if (percent <= 70.00) {
                            colorPB = 'progress-bar-yellow';
                        }
                        else if (percent > 70) {
                            colorPB = 'progress-bar-green';
                        }

                        $body.find('tr:last')
                            .append('<td></td>').find('td:last').addClass('project-completion').attr('width', '130')
                            .append('<small></small>').find('small').text('Existencia: ').parent().append(percent + '%').append('<br>')
                            .append('<div></div>').find('div:last').addClass('progress').addClass('progress-mini')
                            .append('<div></div>').find('div:last').css('width', percent + '%').addClass('progress-bar').addClass(colorPB)
                    }

                    // Sixth columm
                    $body.find('tr:last')
                        .append('<td></td>').find('td:last')
                        .append('<span></span>').find('span:last')
                        .addClass('label')
                        .addClass(i.estado == 1 ? 'label-primary' : 'label-default')
                        .text(i.estado == 1 ? 'ACTIVO' : 'INACTIVO');


                    // Sevennth columm - options
                    AEcO($body.parent(), {opciones: self.optionsTable()}, i);
                }
            });

            // Pagination
            AEcP('pagination-product','Product','table',json, size,'');
        }
        else {
            Api.Mensaje.publicar('informacion','message','No se encontraron resultados')
        }
    },

    optionsTable: function() {
        return {
            parametrizacion: [
                {
                    nombre: 'Detalle',
                    icono: 'fa-eye',
                    accion: 'Api.' + this.controllerJs + '.details',
                    color: '#555',
                    estado: false,
                    permiso: false,
                    informacion: true
                },
                {
                    nombre: 'Bodega & Ubicación',
                    icono: 'fa-map-marker',
                    accion: 'Api.' + this.controllerJs + '.cellerAndLocation',
                    color: '#428bca',
                    estado: false,
                    permiso: 'actualizar',
                    informacion: true
                },
                {
                    nombre: 'Actualizar',
                    icono: 'fa-pencil-square-o',
                    accion: 'Api.' + this.controllerJs + '.edit',
                    color: '#428bca',
                    estado: false,
                    permiso: 'actualizar',
                    informacion: true
                },
                {
                    nombre: 'Actualizar Localización',
                    icono: 'fa-pencil',
                    accion: 'Api.' + this.controllerJs + '.editLocation',
                    color: '#428bca',
                    estado: false,
                    permiso: 'actualizar',
                    informacion: true
                },
                {
                    nombre: 'Subir imagen',
                    icono: 'fa-file-image-o',
                    accion: 'Api.' + this.controllerJs + '.modalImage',
                    color: '#428bca',
                    estado: false,
                    permiso: 'actualizar',
                    informacion: false
                },
                {
                    accion: 'Api.' + this.controllerJs + '.changeStatus',
                    color: '#f7a54a',
                    estado: true,
                    condicion: {
                        1: {
                            icono: 'fa-toggle-off',
                            titulo: 'Desactivar',
                            etiqueta: '<span class="label label-primary ">ACTIVO</span>'
                        },
                        0: {
                            icono: 'fa-toggle-on',
                            titulo: 'Activar',
                            etiqueta: '<span class="label label-default">INACTIVO</span>'
                        }
                    },
                    permiso: 'estado',
                    informacion: false
                },
                {
                    nombre: 'Eliminar',
                    icono: 'fa-trash',
                    accion: 'Api.' + this.controllerJs + '.delete',
                    color: '#ec4758',
                    estado: false,
                    permiso: 'eliminar',
                    informacion: false
                },
                {
                    nombre: 'Eliminar Location',
                    icono: 'fa-eraser',
                    accion: 'Api.' + this.controllerJs + '.deleteLocation',
                    color: '#ec4758',
                    estado: false,
                    permiso: 'eliminar',
                    informacion: true
                }
            ]
        };
    },

    setFilterFields: function(Json) {

        var AHcSJ = Api.Herramientas.cargarSelectJSON;

        AHcSJ('mca-id-tax, #id-tax',Json.tax,true);
        AHcSJ('mca-id-unity, #id-unity',Json.unity,true);
        AHcSJ('mca-id-celler, #id-celler',Json.celler,true);
    },

    findLocation: function(idCeller, id) {

        if (idCeller) {

            this._FindActiveByCeller['id_celler'] = idCeller;

            this.$ajaxS(
                '',
                this.uri,
                this._FindActiveByCeller,

                function (Json) {

                    if (Object.keys(Json).length > 0) {
                        Api.Herramientas.cargarSelectJSON(id, Json, true);
                    }
                    else {
                        Api.Herramientas.cargarSelectJSON(id, [{id:0, nombre: 'Seleccione...'}], false);
                    }
                }
            );
        }
        else {
            Api.Herramientas.cargarSelectJSON(id, [{id:0, nombre: 'Seleccione...'}], false);
        }
    },

    enterSearch: function(e) {
        if (Api.Herramientas.presionarEnter(e)) {
            this.table()
        }
    },

    category: function(Json) {

        if (!Json) {
            Api.Herramientas.getJsonFromAnotherObject('Categoria', 2000, 3, 'Product', 'category');
        }
        else {
            if(Json) {

                var option  = [],
                    select  = 'mca-id-category, #id-category',
                    name    = Json.categorias,
                    json    = JSON.parse(Json.orden),
                    AHvI    = Api.Herramientas.verificarId;

                function space(number) {
                    var htmlSpace = '';
                    for(var i=0;i<number * 5;i++) {
                        htmlSpace += '&nbsp;';
                    }
                    return htmlSpace;
                }

                function getArray(json, level) {
                    $.each(json, function(k, i) {
                        option.push({"level":level,"space": space(level),"id":i.id});
                        if (i.children !== undefined) {
                            getArray(i.children, level + 1)
                        }
                    });
                }

                $(AHvI(select,true)).html('');

                getArray(json, 0);

                $.each(option, function(k, i) {
                    if (i.level) {
                        $(AHvI(select,true)).append('<option value="' + i.id + '">' + i.space + "- " +name[i.id].nombre + '</option>');
                    }
                    else {
                        $(AHvI(select,true)).append('<option value="' + i.id + '" style="font-weight: 700; font-size: 14px">' + name[i.id].nombre + '</option>');
                    }
                });
            }
        }
    },

    createUpdate: function() {

        var parametros = this.verifyForm(this._CreateOrUpdate);

        if (parametros) {
            this.$ajaxS(
                '',
                this.uri,
                parametros,

                function (json) {

                    Api.Mensaje.jsonSuperior(json);

                    if (json.resultado === 1) {

                        var AH = Api.Herramientas,
                            AP = Api.Product;

                        AP.id = null;
                        AP.constructor();

                        AH.cancelarCA('product');
                        AH.cambiarPestanhia('tab-product','listado');
                    }
                }
            );
        }
    },

    edit: function(id, $Information) {

        var contenedor = '#formulario-product',
            $AH = Api.Herramientas;
        this.id = id;

        $(contenedor).find('#id-category').val($Information.id_categoria).focus();
        $(contenedor).find('#name').val($Information.nombre);
        $(contenedor).find('#reference').val($Information.referencia);
        $(contenedor).find('#value').val($AH.formatoNumerico(Math.round($Information.valor)));
        $(contenedor).find('#description').val($Information.descripcion);

        $AH.selectDefault('id-tax', $Information.id_impuesto);
        $AH.selectDefault('id-unity', $Information.id_unidades);
        $AH.mostrarBotonesActualizar('product');
        $AH.cambiarPestanhia('tab-product','create-update');
    },

    changeStatus: function(id) {

        var $objeto = Api[this.controllerJs];

        this._ChangeStatus['id'] = id;

        this.$ajaxS(
            '',
            this.uri,
            this._ChangeStatus,

            function () {

                $objeto.table();
            }
        );
    },

    delete: function(id) {

        var $objeto = Api[this.controllerJs];

        this._Delete['id'] = id;

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
                $objeto._Delete,

                function (json) {

                    if (json.resultado === 1) {

                        swal("Eliminado!", json.mensaje, "success");
                        $objeto.table();
                    }
                    else {
                        swal("Error", json.mensaje , "error");
                    }
                }
            );
        });
    },

    modalImage: function(id) {

        $('.id-product').val(id);
        $('.dz-preview').remove();
        $('#modal-upload-image').modal({backdrop: 'static', keyboard: false});
    },
    
    details: function(id, $information) {

        var $AH = Api.Herramientas,
            content = '#details',
            percentege = 0,
            colorPB = 'progress-bar-green';

        console.log($information);
        $(content).find('#d-picture').attr('src', this.assetImages + $information.imagen);
        $(content).find('#d-name').text($information.nombre);
        $(content).find('#d-reference').text($information.referencia);
        $(content).find('#d-value').text($AH.formatoMoneda($AH.notNullNumeric($information.valor)));
        $(content).find('#d-description').text($information.descripcion);
        $(content).find('#d-celler').text($AH.noNull($information.bodega));
        $(content).find('#d-location').text($AH.noNull($information.locacion));
        $(content).find('#d-tax').text($information.impuesto + ' - ' + $information.impuesto_valor + '%');
        $(content).find('#d-unity').text($information.unidad + ' - ' + $information.unidad_descripcion);
        $(content).find('#d-stock-min').text($AH.formatoNumerico($AH.notNullNumeric($information.stock_min)));
        $(content).find('#d-stock-max').text($AH.formatoNumerico($AH.notNullNumeric($information.stock_max)));
        $(content).find('#d-existence').text($AH.formatoNumerico($AH.notNullNumeric($information.existencia)));
        $(content).find('#d-date-create').text($information.fecha_alteracion);


        if ($information.stock_max > $information.existence) {

            percentege = Math.round(parseInt($information.existence) / parseInt($information.stock_max) * 100);

            if (parseInt($information.existence) <= parseInt($information.stock_min)) {
                colorPB = 'progress-bar-red';
            }
            else if (percentege <= 70.00) {
                colorPB = 'progress-bar-yellow';
            }
            else if (percentege > 70) {
                colorPB = 'progress-bar-green';
            }
        }

        $(content).find('#d-percentege').text('Inventario ' + percentege + '%');
        $(content).find('#d-progress-bar').css('width', percentege + '%')
            .removeClass('progress-bar-red')
            .removeClass('progress-bar-yellow')
            .removeClass('progress-bar-green')
            .addClass(colorPB);

        $AH.cambiarPestanhia('tab-product', 'details')
    },

    cellerAndLocation: function(id, $information) {

        var $AH = Api.Herramientas,
            contentMessage = '#message-info';

        $('#table-location-available').html('');
        $('.block-select').text('');

        this.id = id;

        if ($information.locacion) {

            $(contentMessage)
                .removeClass('alert-info').addClass('alert-success')
                .find('p')
                .html(
                    'El producto se encuentra ubicado en <strong>' + $information.locacion +
                    '</strong> de la bodega <strong>' + $information.bodega +
                    '</strong> con un stock máximo de <strong>' + $AH.notNullNumeric($information.stock_max) + '</strong>.'
                )
        }
        else {
            $(contentMessage)
                .removeClass('alert-success').addClass('alert-info')
                .find('p')
                .text(
                    'El producto no tiene ninguna ubicación en bodega. Seleccione una bodega y luego escoja el lugar donde se guardará.'
                )
        }

        $AH.cambiarPestanhia('tab-product', 'celler-location')
    },

    setCellar: function($json) {

        var content    = '#bd-list-cellar',
            accountant = 6;

        $(content).html('');

        $.each($json, function(k, i) {

            if (k < accountant) {

                $(content)
                    .append('<div>').find('div').last()
                    .addClass('col-lg-2')
                    .addClass('text-center')
                    .addClass('apuntar')
                    .attr('onclick', 'Api.Product.findLocationAvailable(1, 10, ' + i.id + ')')
                    .append('<img>').find('img')
                    .addClass('img-circle')
                    .attr('alt', 'Image')
                    .attr('src', Api.Product.assetTheme + 'celler.png')
                    .attr('width', '100')
                    .parent()
                    .append('<br>').append('<br>').append('<div>').find('div')
                    .append('<strong>').find('strong').text(i.nombre)
                    .parent()
                    .parent()
                    .append(i.direccion)
                    .append('<br><br>')
                    .append('<span>').find('span')
                    .attr('title', 'Seleccionado')
                    .attr('id', 'selected-' + i.id)
                    .addClass('block-select')
                    .addClass('label')
                    .addClass('label-primary')
                    .addClass('text-center')
                    .text('')
            }
        });
    },

    findLocationAvailable: function(pagina, tamanhio, idCeller) {

        if (idCeller) {
            this.idCeller = idCeller;

            $('.block-select').text('');

            $('#selected-' + this.idCeller).text('Seleccionado');
        }

        this._FindAvaliableByCeller['id_celler'] = this.idCeller;

        this.$ajaxC(this.tableNameLocation, pagina, tamanhio);

        this.$ajaxT(
            this.tableNameLocation,
            this.uri,
            this._FindAvaliableByCeller,
            {
                objecto: this.controllerJs,
                metodo: 'findLocationAvailable',
                funcionalidades: this.$functionalitiesT,
                opciones: this.optionsTableLocation(),
                checkbox: false,
                columnas: [
                    {nombre: 'nombre',      edicion: false,	formato: '', alineacion:'izquierda'},
                    {nombre: 'stock_max',   edicion: false,	formato: 'numerico', alineacion:'centrado'},
                    {nombre: 'usado',       edicion: false,	formato: 'numerico', alineacion:'centrado'},
                    {nombre: 'disponible',  edicion: false,	formato: 'numerico', alineacion:'centrado'}
                ],
                automatico: false
            }
        );
    },

    optionsTableLocation: function() {
        return {
            parametrizacion: [
                {
                    nombre: 'Seleccionar',
                    icono: 'fa-check',
                    accion: 'Api.' + this.controllerJs + '.showModalSelectedLocation',
                    color: '#428bca',
                    estado: false,
                    permiso: 'actualizar',
                    informacion: false
                }
            ]
        };
    },

    showModalSelectedLocation: function(idLocation) {

        this.idLocation = idLocation;
        this.idProductLocation = null;

        $('#msl-form')[0].reset();

        $('#msl-name-modal').text('Guardar');

        $('#modal-selected-location').modal({backdrop: 'static', keyboard: false});
    },

    createUpdateLocation: function() {

        var params = this.verifyFormLocation(this._CreateOrUpdateLocation);

        if (params) {

            this.$ajaxS(
                '',
                this.uri,
                params,

                function (json) {

                    Api.Mensaje.jsonSuperior(json);

                    if (json.resultado === 1) {

                        var AH = Api.Herramientas,
                            AP = Api.Product;

                        AP.id = null;
                        AP.idCeller = null;
                        AP.idProductLocation = null;
                        AP.constructor();

                        AH.cancelarCA('product');
                        AH.cambiarPestanhia('tab-product','listado');

                        $('#modal-selected-location').modal('hide');
                    }
                }
            );
        }
    },

    deleteLocation: function(id, $information) {

        var $objeto = Api[this.controllerJs];

        this._DeleteLocation['id'] = $information.id_product_location;

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
                $objeto._DeleteLocation,

                function (json) {

                    if (json.resultado === 1) {

                        swal("Eliminado!", json.mensaje, "success");
                        $objeto.table();
                    }
                    else {
                        swal("Error", json.mensaje , "error");
                    }
                }
            );
        });
    },

    verifyFormLocation: function(parameters) {

        var contenedor = '#modal-selected-location';

        parameters['stock_max']     = $(contenedor).find('#msl-stock-max').val().replace(/,/g,'');
        parameters['stock_min']     = $(contenedor).find('#msl-stock-min').val().replace(/,/g,'');
        parameters['existence']     = $(contenedor).find('#msl-existence').val().replace(/,/g,'');

        parameters['id_product']    = this.id;
        parameters['id_location']   = this.idLocation;
        parameters['id']            = this.idProductLocation;

        if (!parameters['stock_max']) {
            this.$mS('advertencia','Advertencia','Digite el stock máximo para continuar');
            return false;
        }

        if (!parameters['stock_min']) {
            this.$mS('advertencia','Advertencia','Digite el stock mínimo para continuar');
            return false;
        }

        if (!parameters['existence']) {
            this.$mS('advertencia','Advertencia','Digite la existencia para continuar');
            return false;
        }

        return parameters;
    },

    editLocation: function(id, $Information) {

        if ($Information.status_product_location === '-1') {
            this.$mS('advertencia','Advertencia','Este producto no posee localización para actualizar.');
        }
        else {
            var contenedor = '#modal-selected-location',
                $AH = Api.Herramientas;

            this.idProductLocation = $Information.id_product_location;
            this.id = id;
            this.idLocation = $Information.id_locacion;

            $(contenedor).find('#msl-stock-max').val($Information.stock_max);
            $(contenedor).find('#msl-stock-min').val($Information.stock_min);
            $(contenedor).find('#msl-existence').val($Information.existence);
            $(contenedor).find('#msl-name-modal').text('Actualizar');

            $(contenedor).modal({backdrop: 'static', keyboard: false});
        }
    },

    verifyForm: function(parameters) {

        var contenedor = '#formulario-product';

        parameters['id_category']   = $(contenedor).find('#id-category').val();
        parameters['name']          = $(contenedor).find('#name').val().trim();
        parameters['reference']     = $(contenedor).find('#reference').val().trim();
        parameters['value']         = $(contenedor).find('#value').val().replace(/,/g,'');
        parameters['id_tax']        = $(contenedor).find('#id-tax').val();
        parameters['id_unity']      = $(contenedor).find('#id-unity').val();
        parameters['description']   = $(contenedor).find('#description').val().trim();

        parameters['id']            = this.id;

        if (!parameters['id_category']) {
            this.$mS('advertencia','Advertencia','Seleccione una categoria para continuar');
            return false;
        }

        if (!parameters['name']) {
            this.$mS('advertencia','Advertencia','Debe digitar un nombre para continuar');
            return false;
        }

        if (!parameters['reference']) {
            this.$mS('advertencia','Advertencia','Debe digitar un referencia para continuar');
            return false;
        }

        if (!parameters['value']) {
            this.$mS('advertencia','Advertencia','Debe digitar un valor para continuar');
            return false;
        }

        if (!parameters['id_tax']) {
            this.$mS('advertencia','Advertencia','Seleccione un impuesto para continuar');
            return false;
        }

        if (!parameters['id_unity']) {
            this.$mS('advertencia','Advertencia','Seleccione una unidad para continuar');
            return false;
        }

        return parameters;
    }
};