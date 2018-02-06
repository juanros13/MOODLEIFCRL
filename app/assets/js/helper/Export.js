/*
 * Global Variables
*/
var _value;
var _json;

/*
 *	@namespace Export.js
*/
var Export = {

/**
* Método que recupera el Titulo del Reporte
 * @return {string}
*/
getTitle: function(){
	return $('h3').text().substring(0, 30);
},

/**
* Metódo que Obtine los Filtros que el usuario haya seleccionado para el reporte
 * @return {object}
*/
getFilters : function(){

	var _arrayFilters = [];
	if($('body form').find(":input").not('button,#recipient-name,#subject-text,#message-text,#type-export,#data-json,#activate-validation').size() > 0){
		$('body form').find(":input").not('button,#recipient-name,#subject-text,#message-text,#type-export,#data-json,#activate-validation').each(function(index){

			var _label = $(this).prev().text();
			var _value = ($(this).is('select') ? $(this).find('option:selected').text() : $(this).val());

			_value =  ( _value.toLowerCase() === 'seleccione' ? 'Sin Selección' : _value );

			_arrayFilters[index] = '\"'+_label+'\":\"'+_value+'\"';

		});

		return '{' + _arrayFilters.join(',') + '}';
	}
},

/**
* Metódo que Obtine las cabeceras de la tabla
 * @return {array}
*/
getColumnsText : function(){

 	var _names = [];

 	if($('body table').size() > 0){
 		if($('body table thead').find('th').size() > 0){

 			$('body table thead').find('th').each(function(){
 				_names.push($(this).text());
 			});

 			return _names;
 		}
 		else{
 			return false;
 		}
 	}
 	else{

 		return false;
 	}
},
/**
* Metódo encargado de recuperar los comentarios si existen para Datos de Encuesta Satisfacción
* @return {array}
*/
getComments : function(){
	
	var _array = [];
	$.each($("#comments").html().split('<br>'),function(index,value){
		if(value){
			_array.push(value);
		}
	});

	return _array;
},
/**
* Metódo encargado de crear el objeto que sera enviado al backend para el procesamiento de los archivos
* PDF o EXCEL
 * @return {object}
*/
createJSON: function(columns,data){

	var _array = [];
	var _json;

	if(columns.length !== 0 && data.length !== 0 ){

		$.each(data,function(indexData){

			var _arrayItems = [];
			$.each(columns,function(indexColumns){
				_arrayItems[indexColumns] =  '\"' + columns[indexColumns] + '\": \"' + data[indexData][indexColumns]  + '\"';
			});

			_arrayItems.sort();
			_array[indexData] = '{' + _arrayItems.join(',') + '}';
		});

		try{
				_json = $.parseJSON('{"title":"' + Export.getTitle() + '", "header":[], "filters": [' + Export.getFilters() +'], "data":['+ _array.join(',') +']}');
				_json.header[0] = columns;

				if($("#comments").size() > 0){
					_json.comments = [Export.getComments()];
				}
				
				return _json;
		}
		catch(error){
			console.log("Error on create JSON Object to Export Items");
			return false;
		}

	}
	else{
		return false;
	}
},
/**
* Metódo que ensambla y recupera el objeto JSON para envio del Backend
 * @return {object}
*/
getJSON : function(){
	var _columns = Export.getColumnsText();
	var _data 	= Export.getData();
	var _object;
	if(document.location.href.match(/SatisfactionSurveyReport/ig)){
		_object = Export.createJSON(_columns,_data);	
	}else{
		_object = Export.createJSON(_columns,_data.sort());	
	}
	

	return _object;
},
/**
* Metódo set
 * @param {string}
*/
setData: function(data){
 	_value = data;
},
/**
* Metódo get
 * @return {string}
*/
getData: function(){
 	return _value;
},
/**
 * Metódo que recupera el tipo de atibuto segun el criterio
 * @param  {string} selector  jQuery Selector
 * @param  {string} attribute  Valor del atributo en caso de existir
 * @return {string}
*/
getAttributes: function(selector,attribute){
	if(attribute && selector){
		return $(selector).attr(attribute);
	}
	else{
		return false;
	}
},
/**
 * Metódo encargado de crear un iframe dinamico el cual sirve de canal de comunicación para el envio de los parametros y generación del
 * archivo a descargar
*/
createIframe : function(){
	var _rand = Math.round(Date.now() * 10,1);
	$('body').append('<iframe name="'+ _rand +'" id="'+_rand+'" style="display:none; width:100%"></iframe>');
},
/**
 * Metódo encargado de crear un formulario donde se depositan los valores para el envio al iframe
 * archivo a descargar
 * @param {object} json
 * @param {string} typeExport
*/
createForm: function(json,typeExport){
	var _rand = Math.round(Date.now() * 20,1);
	$('body').append('<form id="'+ _rand +'" action="'+ url +'Export/genereteFile" method="post" target="' + Export.getAttributes('iframe','name') + '" novalidate="novalidate" style="display:none;"><textarea id="data" name="data">'+JSON.stringify(json)+'</textarea><input type="hidden" id="typeExport" name="typeExport" value="' + typeExport + '"/></form>');
	$("#"+_rand).submit();

	return _rand;
},
/**
 * Metódo encargado de eliminar un objeto del dom
 * @param {string} selector
*/
removeElement : function(selector){
	if(selector)
	{
		$('body').find('#'+selector).remove();
	}
},
/**
 * Metódo encargado de inicializar el modal para la transmisión de los reportes por medio de email
 *
*/
initModal : function(){

	$('#sendModal').modal('show');

	$("#recipient-name, #subject-text, #message-text").val(null);

	$("#recipient-name").focus(function(){
		$("#recipient-text").remove();
	})

	$("#recipient-name").on('blur',function(){

		if(!$(this).val().match(/;/ig)){

			if(!$(this).val().match(/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/) ){
				$(this).val(null);
				$(this).after('<div id="recipient-text" class="help-block">Correo Electrónico Inválido</div>');
			}
		}
		else{
				var array  = $(this).val().split(';');

					var invalidEmails = [];
					for(var i = 0; i < array.length; i++){
						if($.trim(array[i]).match(/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)){
							continue;
						}
						else{
							invalidEmails.push(array[i]);
						}
					}

					if(invalidEmails.length>0){
						$(this).after('<div id="recipient-text" class="help-block">La lista de Correos Electrónicos no son correctos: '+invalidEmails.join(',')+'</div>');
					}
		}

	});

	$('#send-email-list').on('click',function(){

		if($("#sendModalForm").valid()){
			var data = {};

			data.typeExport = 'send';
			data.to         = $("#recipient-name").val();
			data.subject    = $("#subject-text").val();
			data.message    = $("#message-text").val();
			data.data = JSON.stringify(Export.getJSON());

			var response = Utils.getJSON(url + 'Export/genereteFile',data,'post');

			if(response.success){
				$('#sendModal').modal('hide');
				Utils.successModal("Se ha enviado con exito el reporte a los destinatarios.",false);
			}
			else{
				Utils.errorModal(response.message,false);
			}

		}

	});

	$('#send-email-Satisfaction').on('click',function(){

		if($("#sendModalForm").valid()){
			var data = {};

			data.typeExport = 'satisfaction';
			data.to         = $("#recipient-name").val();
			data.subject    = $("#subject-text").val();
			data.message    = $("#message-text").val();
			data.data = JSON.stringify(Export.getJSON());

			var response = Utils.getJSON(url + 'Export/genereteFile',data,'post');

			if(response.success){
				$('#sendModal').modal('hide');
				Utils.successModal("Se ha enviado con exito el reporte a los destinatarios.",false);
			}
			else{
				Utils.errorModal(response.message,false);
			}

		}

	});
},

/**
 * Metódo encargado de inicializar la descarga del archivo generado de los reportes
 *
*/
getFile : function(response){

	if(response.success)
	{
		$('body iframe').attr('src', url + 'Export/downloadFile/?type='+response.type+'&name='+response.name);
		setTimeout(function(){$('body iframe').attr('src',null);},2000);
	}
	else{
		$('body iframe').removeAttr('src');
		Utils.errorModal(response.message,false);
	}
},

/**
 * Metódo encargado de inicializar las acciones de los botones Exportar PDF, Exportar Excel, o Enviar a correos
 *
*/
setButtonActions : function(table){

	var data = {};
	Export.createIframe();

	try{

		$('a[name="export-pdf"]').on('click',function(){

			data.typeExport = 'pdf';
			data.data = JSON.stringify(Export.getJSON());
			var response =  Utils.getJSON(url + 'Export/genereteFile',data,'post');
			Export.getFile(response);
		});

		$('a[name="export-excel"]').on('click',function(){
			data.typeExport = 'xls';
			data.data = JSON.stringify(Export.getJSON());
			var response =  Utils.getJSON(url + 'Export/genereteFile',data,'post');
			Export.getFile(response);
		});

		Utils.validate('#sendModalForm');

		$('a[name="send-mail"]').on('click',function(){
			Export.initModal();
		});

		$('a[name="send-mail_Satisfaction"]').on('click',function(){
			Export.initModal();
		});
	}
	catch(error){
		console.log("error", error);

	}
}

};
