var curpOK = false;
var existe = false;
  console.log("wololo");
$(document).ready(function() {
    var $form = $('#frmRegistro');
    urlCancel = url + 'register/user_type';
    jQuery.extend(jQuery.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número entero válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
      minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
      rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });
    changeInputStatus(true);
    $('#curp').keyup(function(){
      $(this).val( $(this).val().toUpperCase() );
    });


    $("#exit").click(function () {
        $('.modal-title').html('Salir');
        $('#modalMessage > p').html('¿Estás seguro que deseas cancelar el registro?');
        $('#modalFooter').html('<div class="row" style="padding-right: 10px;"><button id="exit-button" type="button" class="btn btn-danger" data-dismiss="modal">Si, cancelar el registro</button><button id="success-button" type="button" class="btn btn-primary" data-dismiss="modal">No, seguir registrándome</button></div>'
        );
        $('#genericModal').modal('show');

        $("#exit-button").click(function () {
            location.href = urlCancel;
        });
    });
    // AdMethod para validar CURP
    $.validator.addMethod("validCurp", function (value) {
      return value.match(/^[A-Z]{1}[A-Z]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/);
    }, "Formato de CURP incorrecto.");
    //Validar que el usuario no exista registrado
    $.validator.addMethod("validUser", function (value) {
      var isValid;
      var sEmail = value.toLowerCase();

      $.ajax({
        type: "POST",
        url: url + 'register/userNameExists/' + sEmail,
        async: false,
        dataType: "json",
        success: function (response) {
          if (response.success) {
            isValid = false;
          } else {
            isValid = true;
          }
        }
      });
      return isValid;
    }, "Tu correo electrónico ya existe.");
    //AddMethod para sólo Letras
    $.validator.addMethod("onlyLetters", function (value) {
        return value.match(/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑüÜ]*$/);
    }, 'Este campo sólo admite letras.');

    //AddMethod para sólo Números
    $.validator.addMethod("onlyNumbers", function (value) {
        return value.match(/^[0-9]*$/);
    }, 'Este campo sólo admite números.');

    //AddMethod para sólo Números y letras
    $.validator.addMethod("onlyAlphaNum", function (value) {
        console.log("as");
        return value.match(/^[a-zA-ZáéíóúÁÉÍáÓÚñÑüÜ0-9]*$/);
    }, 'Este campo sólo admite números y letras.');

    //AddMethod para sólo Números y letras
    $.validator.addMethod("onlyAlphaNumWithSpace", function (value) {
        console.log("as");
            return value.match(/^[a-zA-ZáéíóúÁÉÍáÓÚñÑüÜ 0-9]*$/);
    }, 'Este campo sólo admite números y letras.');

    //AddMethod para sólo Números y letras
    $.validator.addMethod("onlyAlphaNumWithSpaceAndDot", function (value) {
        console.log("as");
        return value.match(/^[a-zA-ZáéíóúÁÉÍáÓÚñÑüÜ. 0-9]*$/);
    }, 'Este campo sólo admite números y letras y punto.');

    //Validar que el usuario no exista registrado
    $.validator.addMethod("CurpExist", function (value) {
      var isValid;
      quitarErrorDiv();
      $.ajax({
        type: "POST",
        url: url + 'register/userCurpExists/' + value,
        async: false,
        dataType: "json",
        success: function (response) {
          console.log("response:", response);
          if (response.success) {
              isValid = false;
              existe = true;
              limpiarCURP();
          } else {
              isValid = true;
              existe = false;
          }
        }
      });
      return isValid;
    }, "Tu CURP ya existe.");
    $.validator.addMethod("validEmail", function (value) {
      return value.match(
          /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/
      );
    }, "Correo electrónico inválido.");
    //AdMethod para validar Password
    $.validator.addMethod("validPassword", function (value) {
      return value.match(/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@|#|$|*|)|+|-|-|?|.|\/]).*$/);
      //(?=.*[\w.+%\-])
    },
      "Tu contraseña debe ser mínimo de  8 caracteres; al menos una mayúscula, una minúscula, un número y un caracter especial(. $ ? / * - + # @))."
    );
    // Validación de formulario de registro
    var $form = $('#frmRegistro');
    $.validator.messages.required = 'Este campo es obligatorio';
    $form.validate({
      errorElement: 'div',
      errorClass: 'form-text form-text-error',
      focusInvalid: false,
      errorPlacement: function (error, element) {
        quitarErrorDiv();
              
          if (element.attr("type") === 'checkbox') {
            error.insertAfter(element.siblings());
          } else {
            if(element.prop("id")=='dstCurp' || element.prop("id")=='dsCurp' || element.prop("id")=='dtCurp' || element.prop("id")=='dtPuestoValue' || element.prop("id")=='dlPuestoValue' || element.prop("id")=='daPuestoValue'){
              error.insertAfter(element.parent());
            // Aqui podemos insertar la caja de ERROR
            muestraCuadroRojo();
            }
            else
            {
                error.insertAfter(element);
                muestraCuadroRojo();
            }
            $('label').css('color', '#545454');
          }
        },
        highlight: function (element) {
            //$(element).closest('.form-group').addClaClss('has-error'); 
            if($(element).attr("id")=='dstCurp' || $(element).attr("id")=='dsCurp' || $(element).attr("id")=='dtCurp' || $(element).attr("id")=='dtPuestoValue' || $(element).attr("id")=='dlPuestoValue' || $(element).attr("id")=='daPuestoValue'){
                $(element).addClass('form-control-error'); 
                $(element).parent().parent().find('span.obligatorio').addClass('form-text form-text-error');
                //muestraCuadroRojo();
            }
            else{               
                $(element).addClass('form-control-error'); 
                $(element).parent().find('span.obligatorio').addClass('form-text form-text-error');
                //muestraCuadroRojo();
            }
            
        },
        unhighlight: function (element) {
            //$(element).closest('.form-group').removeClass('has-error'); 
            if($(element).attr("id")=='dstCurp' || $(element).attr("id")=='dsCurp' || $(element).attr("id")=='dtCurp' || $(element).attr("id")=='dtPuestoValue' || $(element).attr("id")=='dlPuestoValue' || $(element).attr("id")=='daPuestoValue'){
                $(element).parent().parent().find('.form-control-error').removeClass('form-control-error');
                $(element).parent().parent().find('span.obligatorio').removeClass('form-text form-text-error');
                // Aqui podemos quitar la caja de ERROR
            }
            else{
                $(element).parent().find('.form-control-error').removeClass('form-control-error');
                $(element).parent().find('span.obligatorio').removeClass('form-text form-text-error');
                // Aqui podemos quitar la caja de ERROR
            }
        },
        rules: {
            nombreUsuario: {
              onlyLetters: true
            },
            apellidoPaterno: {
              onlyLetters: true
            },
            apellidoMaterno: {
              onlyLetters: true
            },
            curp: {
              validCurp: true,
              CurpExist: true
            },
            correoElectronico: {
              validEmail: true,
              validUser: true
            },
            correoElectronico2: {
                validEmail: true,
                required: true,
                email: true,
                equalTo: "#correoElectronico"
            },
            claveAcceso: {
                required: true,
                validPassword: true
            },
            claveAcceso2: {
                required: true,
                equalTo: "#claveAcceso"
            },
        },
        messages: {
            duCorreoElectronico2: {
                email: "Correo electrónico inválido",
                equalTo: "Tu correo electrónico no coincide"
            },
            deTelefono: {
                minlength: "Se requiere mínimo 7 dígitos"
            },
            duClaveAcceso2: {
                equalTo: "La contraseña no coincide"
            }
        }
    });
        
    //if register or exit button pressed actionbtn = true and page can be
    //reloaded or closed
    var actionbtn = false;
    var sAjaxUrl = url + 'register/saveUser';
    $('#register').on('click', function () {
      if(!curpOK){
          Utils.successModal("Favor de revisar los datos del CURP, para completar es necesario presionar el icono  <span class='glyphicon glyphicon-search' aria-hidden='true'></span>", false);              
      }else{
        var validator;
        var firstInvalidName;
        $('.modal-title').html('Registro de usuario');
        actionbtn = true;
            
        if ($form.valid()) {
          //showWaiter();
          changeInputStatus(false);
          $('#curp').prop('disabled', false);
          oData = $form.serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
          }, {});
          if (!oData.duDatosPersonales) {
            oData.duDatosPersonales = "0";
          }
          $.ajax({
            url: sAjaxUrl,
            dataType: 'json',
            data: oData,
            type:"POST"
          }).done(function (data) {
            //hideWaiter();
            ocultaCuadroRojo();
            var message = 'Estimado/a Usuario/a: <br><br> Hemos enviado a tu cuenta de correo un mensaje en el que encontrarás instrucciones sencillas para continuar con tu proceso de inscripción.<br><br>Si tuvieras algún problema específico, revisa la sección "Ayuda" en la página principal de la plataforma. Hay 4 documentos para consulta y descarga.';

            Utils.successModal(message, true, 'register/user_type');
            startEncuestaHC(1000,"STPS-04-016");

          }).fail( function(jqXHR,error, errorThrown) {
            //  hideWaiter();
            alert(jqXHR.responseText); 
            //var message = ' Algo salió mal. Por favor, actualiza la página e inténtalo de nuevo.';
            //Utils.errorModal(message, true);
            //actionbtn = false;
          });
        }else{

        }
      }
    });
});
function buscarCURP(curp)
{
  var curp=$('#curp').val();
  $('#curp-error').remove();
  if(curp)
  {
    $.ajax({
      type: "POST",
      //url: url + 'register/getDataByCURP/'+curp,
      url: 'https://www.procadist.gob.mx/moodle/my/test.php?curp='+curp,
      async: false,
      dataType: "jsonp",
      success: function(response){
        if(response.success){
          if(response.data.consultarPorCurpOResult.CodigoError==''){
            curpOK = true;
            var cveEntidad = response.data.consultarPorCurpOResult.cveEntidadNac;
            var entidad="";
            switch(cveEntidad){
              case "AS":
                  entidad=1;
                  break;
              case "BC":
                  entidad=2;
                  break;
              case "BS":
                  entidad=3;
                  break;
              case "CC":
                  entidad=4;
                  break;
              case "CL":
                  entidad=5;
                  break;
              case "CM":
                  entidad=6;
                  break;
              case "CS":
                  entidad=7;
                  break;
              case "CH":
                  entidad=8;
                  break;
              case "DF":
                  entidad=9;
                  break;
              case "DG":
                  entidad=10;
                  break;
              case "GT":
                  entidad=11;
                  break;
              case "GR":
                  entidad=12;
                  break;
              case "HG":
                  entidad=13;
                  break;
              case "JC":
                  entidad=14;
                  break;
              case "MC":
                  entidad=15;
                  break;
              case "MN":
                  entidad=16;
                  break;
              case "MS":
                  entidad=17;
                  break;
              case "NT":
                  entidad=18;
                  break;
              case "NL":
                  entidad=19;
                  break;
              case "OC":
                  entidad=20;
                  break;
              case "PL":
                  entidad=21;
                  break;
              case "QT":
                  entidad=22;
                  break;
              case "QR":
                  entidad=23;
                  break;
              case "SP":
                  entidad=24;
                  break;
              case "SL":
                  entidad=25;
                  break;
              case "SR":
                  entidad=26;
                  break;
              case "TC":
                  entidad=27;
                  break;
              case "TS":
                  entidad=28;
                  break;
              case "TL":
                  entidad=29;
                  break;
              case "VZ":
                  entidad=30;
                  break;
              case "YN":
                  entidad=31;
                  break;
              case "ZS":
                  entidad=32;
                  break;
            }
            try{
              $('#curp').prop('disabled', true);
              $('#nombreUsuario').val(response.data.consultarPorCurpOResult.nombres);
              $('#apellidoPaterno').val(response.data.consultarPorCurpOResult.apellido1);
              $('#apellidoMaterno').val(response.data.consultarPorCurpOResult.apellido2);
              $('#sexo').val(response.data.consultarPorCurpOResult.sexo);
              $('#fechaNacimiento').val(response.data.consultarPorCurpOResult.fechNac);
              $('#estadoNacimiento').val(entidad);
              
            } catch(e){
              console.log(e);
            }
          }else{
            curpOK = false;
            var div='<div id="curp-error" class="help-block" style="display: block; color: #a94442;">'+response.data.consultarPorCurpOResult.message+'</div>';
            $(div).insertAfter($('#curp').parent());
          }
        }else{
          curpOK = false;
          var div='<div id="curp-error" class="help-block" style="display: block; color: #a94442;">'+response.data.consultarPorCurpOResult.message+'</div>';
          $(div).insertAfter($('#curp').parent());
        }
      }
    });
  }else{
    curpOK = false;
    var div='<div id="curp-error" class="help-block" style="display: block; color: #a94442;">El campo CURP no puede estar vació</div>';
    $(div).insertAfter($('#curp').parent());    
  }
}
function buscarCURPTexto()
{
   
   buscarCURP(curp);var curp=$('#dsCurp').val();
};
function limpiarCURP(dejarCURP)
{
    try
    {
      curpOK = false;
      if(typeof dejarCURP=='undefined')
          $('#nombreUsuario').val("");
          $('#apellidoPaterno').val("");
          $('#apellidoMaterno').val("");
          $('#sexo').val("");
          $('#fechaNacimiento').val("");
          $('#estadoNacimiento').val(0);
          
          $('#curp').prop('disabled', false);        
          $('#curp').focus();
      }
    catch(e) { }
   
};
function eliminarCURP(dejarCURP)
{
  try{
    curpOK = false;
    if(typeof dejarCURP=='undefined'){
      $('#curp').val('');
      $('#nombreUsuario').val("");
      $('#apellidoPaterno').val("");
      $('#apellidoMaterno').val("");
      $('#sexo').val("");
      $('#fechaNacimiento').val("");
      $('#dsEstadoNacimiento').val(0);
      $('#curp').prop('disabled', false);
      $('#curp').focus();
      $('#curp').blur();
      $('#curp').focus();
    }
  }catch(e) { }
  
};
function changeInputStatus(status)
{
  try
  {
    $('#nombreUsuario').prop('disabled', status);
    $('#apellidoPaterno').prop('disabled', status);
    $('#apellidoMaterno').prop('disabled', status);
    $('#sexo').prop('disabled', status);
    $('#fechaNacimiento').prop('disabled', status);
    $('#estadoNacimiento').prop('disabled', status);
  }
  catch(e) { }

}
function quitarErrorDiv()
{
    $('#curp-error.help-block').each(function(i){ $(this).remove(); });
    $('#curp-error.help-block').each(function(i){ $(this).remove(); });
    $('#curp-error.help-block').each(function(i){ $(this).remove(); });
}


function muestraCuadroRojo()
{
    document.getElementById('err_vacio').style.display = 'block';
}
function ocultaCuadroRojo()
{
    document.getElementById('err_vacio').style.display = 'none';
}
var pleaseWaitDiv;

function showWaiter()
{
    pleaseWaitDiv=$('<div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5>Registrando Usuario...</h5></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>');
    pleaseWaitDiv.modal();
}

function hideWaiter()
{
    pleaseWaitDiv.modal('hide').data('bs.modal', null);
    pleaseWaitDiv.remove();
    propBody();
}
function propBody()
{
    $('body').prop('style', '');
    $('body').attr('style', 'overflow-y: scroll;');
    $('body').prop('class', '');
}

