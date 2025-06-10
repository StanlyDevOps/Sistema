/**
 * Created by Jeremy Jose Reyes Barrios on 3/07/2017.
 */

Api.Herramientas = {
    anhioBisiesto: 2016,
    infoFecha: {
        1: {nombre:'Enero', diminutivo: 'Ene', ultimoDia: 31},
        2: {nombre:'Febrero', diminutivo: 'Feb', ultimoDia: 28},
        3: {nombre:'Marzo', diminutivo: 'Mar', ultimoDia: 31},
        4: {nombre:'Abril', diminutivo: 'Abr', ultimoDia: 30},
        5: {nombre:'Mayo', diminutivo: 'May', ultimoDia: 31},
        6: {nombre:'Junio', diminutivo: 'Jun', ultimoDia: 30},
        7: {nombre:'Julio', diminutivo: 'Jul', ultimoDia: 31},
        8: {nombre:'Agosto', diminutivo: 'Ago', ultimoDia: 31},
        9: {nombre:'Septiembre', diminutivo: 'Sep', ultimoDia: 30},
        10: {nombre:'Octubre', diminutivo: 'Oct', ultimoDia: 31},
        11: {nombre:'Noviembre', diminutivo: 'Nov', ultimoDia: 30},
        12: {nombre:'Diciembre', diminutivo: 'Dic', ultimoDia: 31}
    },
    accountant: 0,

    selectDefault: function(apuntador,seleccion) {

        apuntador = Api.Herramientas.verificarId(apuntador,true);

        $(apuntador + '> option[value=' + seleccion + ']').attr('selected',true);
        $(apuntador).val(seleccion).trigger("chosen:updated");
    },

    cargarSelectJSON: function(apuntador,json,mensaje,valorSelecionado) {

        if (Object.keys(json).length !== 0) {

            apuntador = Api.Herramientas.verificarId(apuntador,true);

            $(apuntador).html('');

            if (mensaje) {

                $(apuntador)
                    .html('')
                    .append(
                        $('<option>', {
                            value: '',
                            text: 'Seleccione...'
                        })
                    );
            }

            $.each(json, function(k, i) {

                $(apuntador).append(
                    $('<option>',{
                        value: i.id,
                        text: !i.nombre ? i.descripcion : i.nombre
                    })
                )
            });

            if (valorSelecionado) {
                $(apuntador + '> option[value=' + valorSelecionado + ']').attr('selected',true);
                $(apuntador).val(valorSelecionado).trigger("chosen:updated");
            }
            else {
                $(apuntador)
                    .find('option:first-child')
                    .prop('selected', true)
                    .end()
                    .trigger("chosen:updated");
            }

            Api.Inicializador.select();
        }
    },

    primeraLetraMayuscula: function(cadena) {

        return cadena.charAt(0).toUpperCase() + cadena.slice(1);
    },

    presionarEnter: function(evento) {

        if (evento.keyCode == 13) {
            return true;
        }
        else {
            return false;
        }
    },

    mostrarInput: function(contenedor,mostrar) {

        var input = $(contenedor + '> input');

        if (mostrar) {

            $(contenedor + '> input[type=password]').get(0).type = 'text';

            $(contenedor + '> span').attr('onclick',"Api.Herramientas.mostrarInput('" + contenedor + "',false)");

            $(contenedor + '> span > i')
                .removeClass('fa-eye')
                .addClass('fa-eye-slash');
        }
        else {

            $(contenedor + '> input[type=text]').get(0).type = 'password';

            $(contenedor + '> span').attr('onclick',"Api.Herramientas.mostrarInput('" + contenedor + "',true)");

            $(contenedor + '> span > i')
                .removeClass('fa-eye-slash')
                .addClass('fa-eye');
        }
    },

    verificarId: function(id,conClave) {

        if (conClave) {

            return id.substr(0, 1) === '#' ? id : '#' + id;
        }
        else {
            return id.substr(0, 1) === '#' ? id.substr(1, id.length) : id;
        }
    },

    verificarClase: function(id,conClave) {

        if (conClave) {

            return id.substr(0, 1) === '.' ? id : '.' + id;
        }
        else {
            return id.substr(0, 1) === '.' ? id.substr(1, id.length) : id;
        }
    },

    formatoNumerico: function(numero) {
        return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    formatoMoneda: function(numero) {

        return '$' + numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    tablaExiste: function(id) {

        return parseInt($(Api.Herramientas.verificarId(id,true)).children('div').length) > 0 ? true : false;
    },

    primeraMayuscula: function (string){
        return string.charAt(0).toUpperCase() + string.slice(1);
    },

    buscarTablaEnter: function(evento, objeto, metodo, id) {

        var $herramientas = Api.Herramientas;

        if ($herramientas.presionarEnter(evento)) {

            objeto = objeto.split('.');

            if (objeto.length === 2) {
                Api[objeto[0].trim()][objeto[1].trim()][metodo.trim()](
                    1,
                    parseInt($($herramientas.verificarId(id, true) + '-resultados > select').val())
                );
            }
            else {
                Api[objeto[0].trim()][metodo.trim()](
                    1,
                    parseInt($($herramientas.verificarId(id, true) + '-resultados > select').val())
                );
            }
        }
    },

    checkTabla: function(id) {

        var id              = this.verificarId(id,true);
        var contenedor      = $(id).find('table');
        var checkboxPadre   = contenedor.children('thead').find('input[type=checkbox]');

        if (checkboxPadre.is(':checked')) {
            contenedor.find(':input').prop('checked',true);
        }
        else {
            contenedor.find(':input').prop('checked',false);
        }
    },

    obtenerCheck: function(id,checkeados) {

        var ids = '';

        if (checkeados) {
            checkeados = 'checked';
        }
        else {
            checkeados = 'not(:checked)';
        }

        $(Api.Herramientas.verificarId(id,true) + ' :input:checkbox:' + checkeados).each(function() {

            if ($(this).val()) {
                ids += $(this).val() + ',';
            }
        });

        return ids.substr(0,ids.length - 1).trim();
    },

    cambiarPestanhia: function(id,idPestanhia) {

        var AH      = Api.Herramientas;

        id          = AH.verificarId(id,true);
        idPestanhia = AH.verificarId(idPestanhia,true);

        $(id +' li').each(function() {

            if ($(this).children('a').attr('href') === idPestanhia) {
                $(this).addClass('active');
            }
            else {
                $(this).removeClass('active');
            }
        });

        $(id +' .tab-pane').each(function() {

            if ($(this).attr('id') === AH.verificarId(idPestanhia,false)) {
                $(this).addClass('active');
            }
            else {
                $(this).removeClass('active');
            }
        });
    },

    mostrarBotonesActualizar: function(id) {

        var $boton = $('#ca-botones-' + id);

        id = Api.Herramientas.verificarId(id,false);

        if ($boton.find('#btn-guardar').length > 0) {

            $boton = $boton
                .find('#btn-guardar')
                .addClass('ocultar')
                .parent();
        }

        $boton = $boton
            .find('#btn-cancelar')
            .removeClass('ocultar')
            .parent();

        if ($boton.find('#btn-actualizar').length > 0) {

            $boton.find('#btn-actualizar').removeClass('ocultar');
        }
    },

    cancelarCA: function(id) {

        var $boton = $('#ca-botones-' + id);

        id = Api.Herramientas.verificarId(id,false);

        document.getElementById('formulario-' + id).reset();

        if ($boton.find('#btn-guardar').length > 0) {

            $boton = $boton
                .find('#btn-guardar')
                .removeClass('ocultar')
                .parent();
        }
        else if($boton.find('.btn-guardar').length > 0) {

            $boton = $boton
                .find('.btn-guardar')
                .removeClass('ocultar')
                .parent();
        }

        if ($boton.find('#btn-cancelar').length > 0) {

            $boton = $boton
                .find('#btn-cancelar')
                .addClass('ocultar')
                .parent();
        }
        else if($boton.find('.btn-cancelar').length > 0) {

            $boton = $boton
                .find('.btn-cancelar')
                .addClass('ocultar')
                .parent();
        }

        if ($boton.find('#btn-actualizar').length > 0) {

            $boton.find('#btn-actualizar').addClass('ocultar');
        }
        else if($boton.find('.btn-actualizar').length > 0) {

            $boton.find('.btn-actualizar').addClass('ocultar');
        }
    },

    checkboxOnclick: function(onclick,checked) {

        var $checkbox       = $('#clonar-checkbox');
        var $checkboxHTML   = $checkbox.html();
        var input           = '';

        $checkbox.find('input').attr('onclick',onclick);

        if (checked) {
            $checkbox.find('input').attr('checked','checked');
        }

        input = $checkbox.html();

        $checkbox.html($checkboxHTML);

        return input;
    },

    noNull: function(string) {
        return string === null ? '' : string;
    },

    notNullNumeric: function(string) {
        return string === null ? 0 : parseInt(string);
    },

    sumarDia: function(dias, fecha) {

        fecha = new Date(fecha);

        fecha.setDate(fecha.getDate() + parseInt(dias) + 1);

        var anhio   = fecha.getFullYear();
        var mes     = fecha.getMonth() + 1;
        var dia     = fecha.getDate();

        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;

        return anhio + '-' + mes + '-' + dia;
    },

    sumarMes: function(meses, fecha) {

        var aFecha  = fecha.split('-');
        var anhio   = parseInt(aFecha[0]);
        var mes     = parseInt(aFecha[1]);
        var dia     = 0;

        for(var i=1; i <= (meses + 1); i++) {

            if (mes > 11) {
                anhio += 1;
                mes = 1;
            }
            else {
                mes += 1;
            }
        }

        dia = this.validarUltimoDiaMes(anhio, mes, parseInt(aFecha[2]));


        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;

        return anhio + '-' + mes + '-' + dia;
    },

    validarUltimoDiaMes: function(anhio, mes, dia) {

        var anhioBisiesto = (anhio - this.anhioBisiesto) / 4 === 1 ? true : false;

        if (dia === 31) {

            if (mes === 2) {

                if (anhioBisiesto) {
                    dia = 29;
                }
                else {
                    dia = this.infoFecha[mes].ultimoDia;
                }
            }
            else {
                dia = this.infoFecha[mes].ultimoDia;
            }
        }
        else if(dia === 30 && mes === 2) {

            if (anhioBisiesto) {
                dia = 29;
            }
            else {
                dia = this.infoFecha[mes].ultimoDia;
            }
        }

        return dia;
    },

    listaExandirContraer(id) {

        $(Api.Herramientas.verificarId(id,true)).on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if(action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if(action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    },

    getJsonFromAnotherObject: function(object, time, quantity, actualObject, actualMethod) {

        var Json = Api[object].Json,
            self = Api.Herramientas;

        if (Json) {
            return Api[actualObject][actualMethod](Json);
        }
        else {

            if (self.accountant > quantity) {
                self.accountant = 0;
                return Api[actualObject][actualMethod](Json);
            }
            else {
                setTimeout(function () {
                    self.accountant += 1;
                    self.getJsonFromAnotherObject(object, time, quantity, actualObject, actualMethod);
                }, time);
            }
        }
    },

    validarEmail: function(email) {

        if (email.trim()) {
            return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email.trim()) ? true : false;
        }
        else {
            return false;
        }
    }
};


function _diferenciaEntreFechas(fechaInicial,fechaFinal,tipo) {

    switch (tipo)
    {
        case 'dias':
            var fecha1 = new Date(fechaInicial);
            var fecha2 = new Date(fechaFinal);

            var diasDif = fecha2.getTime() - fecha1.getTime();

            return Math.round(diasDif/(1000 * 60 * 60 * 24));
            break;
    }
}