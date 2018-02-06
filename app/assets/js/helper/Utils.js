var Utils = {

    /**
     * Retorna el tipo de usuario para el controlador registro
     * @return {string} cadena con el tipo de usuario
     */
    getTypeUserByPath: function () {
        var path = document.URL.split('/');
        return path[path.length - 1];
    },

    /**
     * Función para cambiar a mayúscula la primer letra de 1 palabra
     * @param  {string} string cadena formada por una sola palabra
     * @return {string}        palabra con la primera letra en mayúscula
     */
    capitalizeWord: function (string) {
        return string.toLowerCase().replace(/(^\s*[a-z])/g, function (m, p1) {
            return p1.toUpperCase();
        });
    },

    /**
     * Función para poner la primer letra de cada palabra en mayúcula
     * @param  {string} string cadena para ser convetida
     * @return {string}        cadena con la primera letra en mayúscula de cada palabra
     */
    capitalizeWords: function (string) {
        var strings = [];
        var words = string.split(' ');

        for (var i = 0; i < words.length; i++) {
            strings.push(Utils.capitalizeWord(words[i]));
        };

        return strings.join(' ');
    },
    
    /**
     * Función para poner la primer letra de una frase en mayúcula
     * @param  {string} string cadena para ser convetida
     * @return {string}        cadena con la primera letra en mayúscula de la frase
     */
    capitalizeFirstWord: function (string) {
        var strings = [];
        var words = string.split(' ');
        var capitalize=false;
        for (var i = 0; i < words.length; i++) {
            if(isNaN(parseInt(words[i])) && !capitalize)
            {
                strings.push(Utils.capitalizeWord(words[i]));
                capitalize=true;
            }
            else
            {
                strings.push(words[i].toLowerCase());
            }
        };

        return strings.join(' ');
    },

    /**
     * Transforma una fecha en el formato d/m/yyyy a dd/mm/yyyy
     * @param  {string} inputFormat cadena con una fecha en el formato d/m/yyyy
     * @return {string}             cadena con una fecha en el formato dd/mm/yyyy
     */
    convertDate: function (inputFormat) {
        function pad(s) {
            return (s < 10) ? '0' + s : s;
        }
        var d = new Date(inputFormat);
        return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('/');
    },

    changeComboData: function (target, service, key, value, dependency,addOptionAll) {
		addOptionAll = addOptionAll || false;
        $(document).on("change", target, function () {
            var $self = $(this);

            if ($self.val()) {
                Catalog.getObject(service + $self.val(), key, value, dependency);
            }
			if(addOptionAll){
			    $(dependency).append($("<option></option>").attr("value",'').text('TODOS')); 
	 		}
        });
    },

    changeComboDataMul: function (target, aTarget, service, servicedep, key, value, dependency,addOptionAll) {
		addOptionAll = addOptionAll || false;
        $(document).on("change", target, function () {
            if ($(target).val() != '') {
                var dependencia = servicedep + $(aTarget).val();
                Catalog.getObject(service + $(this).val() + dependencia, key, value,dependency);
            } else {
                $('#course').empty().append('<option selected="selected" value="">Seleccionar</option>');
            }
			if(addOptionAll){
				$(dependency).append($("<option></option>").attr("value",'').text('TODOS')); 
	 		}	
        });
    },

    /**
     * Levanta un modal con un mensaje de error si este esta cargado en la vista, el modal se encuestra en _templates/modal.php
     * @param  {string} message  (Opcional) El mensaje que sera utilizado en el modal
     * @param  {boolean} reload  (Opcional) indica si se recargara la pagina cuando se de click en el boton continuar
     */
    errorModal: function (message, reload) {
        message = typeof message !== 'undefined' ? message :
            'Algo salió mal. Por favor, actualiza la página e inténtalo de nuevo.';
        reload = typeof reload !== 'undefined' ? reload : true;

        if ($('#genericModal').length) {
            $('.modal-title').html('ERROR');
            $('#modalMessage > p').html(message);
            $('#modalFooter').html('<button id="success-button" type="button" class="btn btn-primary" data-dismiss="modal">Continuar</button>');
            $('#genericModal').modal('show');
            $("#success-button").on('click', function () {
                if (reload) {
                    location.reload();
                } else {
                    $('#genericModal').modal('hide');
                }
            });
        }
    },

    /**
     * Levanta un modal con un mensaje de error si este esta cargado en la vista, el modal se encuestra en _templates/modal.php
     * @param  {string} message  (Opcional) El mensaje que sera utilizado en el modal
     * @param  {boolean} location  (Opcional) indica si se redirecciona la pagina cuando se de click en el boton continuar
     */
    successModal: function (message, location, urlRedirect) {
        message = typeof message !== 'undefined' ? message : '';
        location = typeof location !== 'undefined' ? location : true;
        urlRedirect = typeof urlRedirect !== 'undefined' ? urlRedirect : false;

        if ($('#genericModal').length) {
            $('.modal-title').html('Notificación');
            $('#modalMessage > p').html(message);
            $('#modalFooter').html('<button id="success-button" type="button" class="btn btn-primary" data-dismiss="modal">Continuar</button>');
            $('#genericModal').modal('show');
            $("#success-button").on('click', function () {
                if (location) {
                    if(urlRedirect){
                        window.location.href = url + urlRedirect;
                    }else{
                        window.location.href = url;
                    }
                } else {
                    $('#genericModal').modal('hide');
                }

            });
        }
    },

    /**
     * Filtra las opciones de un combo pasando como parametros los items que no seran mostrados ejemplo
     * Utils.selectFilterOptions('#dlSector',[20]);
     * @param  {string} target  referencia del objeto en DOM
     * @param  {array}  arrayOfIds  arreglo de valores que deseas eliminar de la Lista
     */
    selectFilterOptions: function (target, arrayOfIds) {
        var $options = $(target).find("option");

        $.each(arrayOfIds, function (index) {
            $.each($options, function () {
                if (parseInt(arrayOfIds[index]) === parseInt($(this).val())) {
                    $(this).remove();
                }
            });
        });

        return this;
    },

    /**
     * Limpia un conjunto de combos dependientes cuando se selecciona la opción "Seleccione"
     */
    clearDependentnCombo: function (origin, aTarget) {
        origin = typeof origin !== 'undefined' ? origin : '';
        aTarget = typeof aTarget !== 'undefined' ? aTarget : [];

        var $origin = $(origin);

        $origin.on('change', function () {
            if (!$(this).val()) {
                for (var i = aTarget.length - 1; i >= 0; i--) {
                    $(aTarget[i]).empty().append('<option selected="selected" value="">Seleccionar</option>');
                };
            } else {
                for (var i = aTarget.length - 1; i >= 0; i--) {
                    if (i !== 0) {
                        $(aTarget[i]).empty().append('<option selected="selected" value="">Seleccionar</option>');
                    } else {
                        $(aTarget[i] + ' option').first().prop('selected', true).click();
                    }
                };
            }
        });
    },

    clearCombo: function (origin, target) {
        origin = typeof origin !== 'undefined' ? origin : '';
        target = typeof target !== 'undefined' ? target : '';

        $(origin).on('click', function () {
            var value = $(this).val();

            if (target && !value) {
                $(target + ' option').first().prop('selected', true).click();
            }
        });
    },

    /**
     * Habilita elementos del dom del tipo [a] anchor (Usado en Objeto Export.js)
     * @param  {array} Arreglo de selectores separados por coma ej.  Utils.enableAnchor('a[name="export-pdf"],a[name="export-excel"],a[name="send-mail"]');
     */
    enableAnchor: function (target) {
        $(target).attr("disabled", false);
    },

    /**
     * Habilita elementos del dom del tipo [textarea] (Usado en MassiveCampaings.js)
     * @param  {sel} Selector ej.  Utils.enableCleditor('#message');
     */
    enableCleditor: function (target) {
        var editor = $(target).cleditor({
            width: 500, // width not including margins, borders or padding
            height: 250, // height not including margins, borders or padding
            controls: // controls to add to the toolbar
            "bold italic underline strikethrough subscript superscript | font size " +
            "style | color highlight removeformat | bullets numbering | outdent " +
            "indent | alignleft center alignright justify | undo redo | " +
            "rule image link unlink | cut copy paste pastetext | print source",
            colors: // colors in the color popup
            "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
            "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
            "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
            "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
            "666 900 C60 C93 990 090 399 33F 60C 939 " +
            "333 600 930 963 660 060 366 009 339 636 " +
            "000 300 630 633 330 030 033 006 309 303",
            fonts: // font names in the font popup
            "Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond," +
            "Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",
            sizes: // sizes in the font size popup
                "1,2,3,4,5,6,7",
            styles: // styles in the style popup
                [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
                    ["Header 3", "<h3>"], ["Header 4", "<h4>"], ["Header 5", "<h5>"],
                    ["Header 6", "<h6>"]],
            useCSS: false, // use CSS to style HTML when possible (not supported in ie)
            docType: // Document type contained within the editor
                '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
            docCSSFile: // CSS file used to style the document contained within the editor
                "",
            bodyStyle: // style to assign to document body contained within the editor
                "margin:4px; font:10pt Arial,Verdana; cursor:text"

        })[0];
        
        return editor;
    },
    /**
     * Oculta elementos del dom del tipo [a] anchor (Usado en Objeto Export.js)
     * @param  {array} Arreglo de selectores separados por coma ej.  Utils.hiddenInput('a[name="export-pdf"],a[name="export-excel"],a[name="send-mail"]');
     */
    hiddenInput: function (target) {
        $(target).attr("style", "visibility: hidden");
    },
    /**
     * Muestra elementos del dom del tipo [a] anchor (Usado en Objeto Export.js)
     * @param  {array} Arreglo de selectores separados por coma ej.  Utils.showInput('a[name="export-pdf"],a[name="export-excel"],a[name="send-mail"]');
     */
    showInput: function (target) {
        $(target).attr("style", "visibility: visible");
    },
    /**
     * Deshabilita elementos del dom del tipo [a] anchor
     * @param  {array} Arreglo de selectores separados por coma ej.  Utils.disabledAnchor('a[name="export-pdf"],a[name="export-excel"],a[name="send-mail"]');
     */
    disabledAnchor: function (target) {
        $(target).attr("disabled", true);
    },

    /**
     * Método asicróno que envia un objeto json con los parametros que solicita el servicio y retorna un array del response
     * para poblar los data-tables, se suprime el uso de ajax en los datatables
     * por el uso de la funcionalidad del Objeto Export.js
     *
     */
    getObject: function (service, dataValues) {
        var array = [];

        $.ajax({
            url: service,
            type: "GET",
            dataType: "json",
            async: false,
            data: dataValues
        }).done(function (data) {
            console.log(data);
	    array = data;
        }).fail(function (e) {
	    //console.log("Error: ");
	    console.log(e);
            Utils.errorModal();
        });

        return array;
    },

    /**
     * Método asicróno que solicita un objeto json de forma sincrona
     * @param {string} service. URL del servicio que sera recuperado en formato json
     * @param {string} dataValues. objeto con parametros de envio en el request
     * @param {string} type. Tipo de método de envio
     */
    getJSON: function (service, dataValues, type) {

        var json;
        $.ajax({
            url: service,
            type: (type) ? type : 'GET',
            dataType: "json",
            data: dataValues,
            async: false
        }).done(function (data) {
            json = data;
        }).fail(function () {
            Utils.errorModal();
        });

        return json;
    },

    /**
     * Obtiene el tamaño de datos de una tabla que este en una vista de reportes sin uso de id o name
     * @return {int}
     */
    getSizeTable: function () {
        return $('body table').DataTable().data().length;
    },

    /**
     * Inyecta los valores recuperados de una consulta para asignarle el valor a una instancia de DataTable
     * @param {object} table Datatable instance
     * @param {array}  response Objeto recuperado de una respuesta a un servicio para poblar la instancia table
     * @return {object} Iterate Table
     */
    setDataTable: function (table, response) {
        Utils.clearDataTable(table);
        for (var key in response) {
            table.rows.add(response[key]).draw();
        }
    },

    /**
     * Elimina los valores que tiene una tabla
     * @param {object} table Datatable instance
     * @return {object} Clean Table
     */
    clearDataTable: function (table) {
        return table.clear().draw();
    },

    validate: function (target) {
        target = typeof target !== 'undefinded' ? target : '';

        $.validator.messages.required = 'Este campo es requerido';

        $(target).validate({
            errorElement: 'div',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.attr("type") === 'checkbox') {
                    error.insertAfter(element.siblings());
                }else{
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
    },

    validateHoneyAlonso: function (target) {
        target = typeof target !== 'undefinded' ? target : '';

        $.validator.messages.required = 'Este campo es requerido';

        $(target).validate({
            errorElement: 'div',
            errorClass: 'alert alert-danger',
            errorPlacement: function (error, element) {
                error.appendTo(element.parents('tr').find('.question'));
            }
        });
    },

    /**
     * Método que redirecciona al contexto de admin si las credenciales son validas
     * @return {}  location.url
     */
    success: function () {
        return location.href = url + "Administration";
    },

    /**
     * Método que valida la exisencia del objeto #salid si es localizado
     * en el contexto del DOM aplica evento para destruir la sesión creada
     * y retornar a la pantalla principal de Login
     * @return {}  location.url
     */
    logout: function () {
        //if ($('#salir')) {
        //    $('#salir').on('click', function () {
        //        var data = {
        //            destroy: true
        //        };

        //        var response = Utils.getJSON(url + 'Login/logout', data, 'POST');
                //return (response.success) ? location.href = url + 'Login' : location.href = url;
        //    });
        //}
    },

    /**
     * Método que inicializa los objetos DatePicker de Bootstrap
     * @param {string} target Selector(es) de jquery a inicializar Ej target = '#datepicker'
     * @param {int} propertyId entero usado para validar el tipo de propiedades que serán seteadas en el control del datepicker 1 = Registro 2 = Reportes
     * @return {}  location.url
     */
    setDatePicker: function (target, propertyId) {
        switch (propertyId) {

        case 1:
            json = {
                format: "dd-mm-yyyy",
                weekStart: 0,
                startView: 2,
                language: "es",
                autoclose: true,
                startDate: '-100y',
                endDate: '1',
                forceParse: true
            };
            break;
        case 2:
            json = {
                format: "dd-mm-yyyy",
                weekStart: 0,
                startView: 1,
                language: "es",
                autoclose: true,
                startDate: '-100y',
                endDate: '+0d',
                forceParse: true
            };
            break;
        case 3:
            json = {
                format: "dd-mm-yyyy",
                weekStart: 0,
                startView: 1,
                language: "es",
                autoclose: true,
                startDate: '-100y',
                endDate: '+0d',
                forceParse: false
            };
            break;
        case 4:
            json = {
                format: "dd-mm-yyyy",
                weekStart: 0,
                startView: 1,
                language: "es",
                autoclose: true,
                startDate: '-100y',
                endDate: '+10d',
                forceParse: false
            };
            break;
        default:
            json = {};
        }
        if(propertyId==1)
        {
            $(target).datepicker();   
        }
        else
        {
            $(target).datepicker(json);
        }

    },

    /**
     * Método que evalua si el valor de un datepicker es igual al dia actual de sistema
     * Si el valor es igual elimina su valor a si mismo de lo contrario verifica que el dato sea valido
     * @param {string} target Selector(es) de jquery a inicializar Ej target = '#datepicker'
     * @return {}  null o elemento valido
     */
    isCurrentDateValueOnPicker: function (target) {
		//console.log('isCurrentDateValueOnPicker');
        $(target).on('change', function () {
            if ($(this).datepicker("getDate") >= new Date().setHours(0, 0, 0, 0)) {
                $(this).val(null)
            } else {
                $(this).valid();
            }
        });
    },

    /**
     * Método que evalua si el valor de un datepicker es diferente a tipo fecha
     * Si el valor es erroneo limpia el input
     * @param {string} target Selector(es) de jquery a inicializar Ej target = '#datepicker'
     * @return {}  null o elemento valido
     */
    isValidDateValueOnPicker: function (target) {

        $(target).on('change', function () {
            var fecha = $(this).val();
            var datePat = /^(\d{1,2})(\-)(\d{1,2})(\-)(\d{4})$/;
            var fechaCompleta = fecha.match(datePat);
			//console.log('isValidDateValueOnPicker');
            if (fechaCompleta === null) {
                $(this).val(null)
            } else {
                $(this).valid();
            }
        });
    },

    /**
     * Método que evalua las fechas proporcionadas
     * Si el valor de la fecha final es menor a la fecha inicial la fecha final se limpia
     * @param {timestamp} init fecha inicial
     * @param {timestamp} end  fecha final
     * @param {string} target Selector jQuery
     * @return {}  null o elemento valido
     */
    endDateIsLessThanToInitialDate: function (init, end, target) {
        $(target).on('change', function () {
            if ($(end).datepicker("getDate") < $(init).datepicker("getDate")) {
                $(target).val(null);
            }
        });
    },

    /**
     * Método que evalua si los elementos del Dom son validos
     */
    theValueIsValidOnChangeEvent: function (target) {
        $(target).on('change', function () {
            //   alert($(this).invalid());
            $(this).valid();
            /*var text= $(this).val();
            var comp = text.split('-');
            alert(comp);
            var d = parseInt(comp[0], 10);
            var m = parseInt(comp[1], 10);
            var y = parseInt(comp[2], 10);
            if ( y>=2000  &&  m>=1 && m<=12 && d>=1 && d<=31) {
                alert('valido');
               $(this).valid();
            } else {
                alert('invalido');
               $(this).val('');
            }*/
        });
    },

    /**
     * Método que agrega clases Css en los filtros del Objeto Datatable
     *
     */
    addClassOnFiltersByTable: function () {
        $(".dataTables_filter").addClass('form-inline');
        $(".dataTables_filter input[type='search']").addClass('form-control');

        $(".dataTables_length").addClass('form-inline');
        $(".dataTables_length select").addClass('form-control');
    },

    /**
     * Método que añade scroll en la posición x del contenedor de un DataTable si existe
     *
     */
    addScrollOnTableContainer: function () {
        if ($('body table')) {
            var count = 0;
            count = $('thead tr th').size();
            //console.log(count);
            if (count > 6) {
                $('table').closest('.row').css({
                    "overflow-x": "scroll"
                });
                Utils.addClassOnFiltersByTable();
            }
        }
    }

};

//Instancia para logout
Utils.logout();


$( document ).ready(function() {
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-85523269-1', 'auto');
	  ga('send', 'pageview');
});