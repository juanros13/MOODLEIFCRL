var Catalog = {
    setOption: function (selector, data, key, value, firstWord, addOptionAll) {
		addOptionAll = addOptionAll || false;
        $(selector).empty();
        var option = Array();
        console.log(data);
        for (var i = 0; i < data.length; i++) {
 	    if(true)
                option.push('<option  value="' + data[i][key] + '">'+data[i][value]+'</option>');
            else
            if(typeof firstWord!="undefined" && firstWord)
                option.push('<option  value="' + data[i][key] + '">' + Utils.capitalizeFirstWord(data[i][value]) + '</option>');
            else
                option.push('<option  value="' + data[i][key] + '">' + Utils.capitalizeWords(data[i][value]) + '</option>');
        };
		
        $(selector)
            .append('<option value="" >Selecciona</option>')
            .append(option.join(""));
		
		if(addOptionAll){
			//a petición de usuario agregamos opción de 'todos' con misma funcionalidad que 'seleccione'
			$(selector).append($("<option></option>").attr("value",'').text('TODOS')); 
		}
    },

    getObject: function (service, key, value, selector, firstWord, addOptionAll) {
		
		addOptionAll = addOptionAll || false;
        $.ajax({
            url: service,
            type:"GET",
            dataType: "json",
            async: false
        }).done(function (data) {
            Catalog.setOption(selector, data, key, value, firstWord, addOptionAll);
        }).fail(function () {
            var message = 'Algo salió mal. Por favor, actualiza la página e inténtalo de nuevo.';
            Utils.errorModal(message, true);
        });
    }
};
