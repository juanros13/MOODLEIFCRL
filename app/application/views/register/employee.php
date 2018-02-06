<div class="container">
  <style>
    input.form-control {
        text-transform: uppercase;
    }
    
    ::-webkit-input-placeholder {
       text-transform: initial;
    }

    :-moz-placeholder { 
       text-transform: initial;
    }

    ::-moz-placeholder {  
       text-transform: initial;
    }   

    :-ms-input-placeholder { 
       text-transform: initial;
    }
    
    input.user {
      text-transform: none !important;
    }
    
    .modal-backdrop.in {
      z-index: 0;
    }
    
  </style>
  <div class="row">
    <div class="col-md-12">
      <ol class="breadcrumb">
        <li><a href="http://www.gob.mx/"><i class="icon icon-home"></i></a></li>
        <li><a href="<?php echo base_url();?>register/employee">Inicio</a></li>
        <li class="active">PROCAT</li>
      </ol>
    </div>
  </div>  
    <div class="row">
      <div class="col-md-8">
        <h1>Registro de Trabajadores</h1>
      </div>
    </div>  
    <br>
  <div id="err_vacio" style='display:none;'>
    <div class="row">
      <div class="col-md-12">
        <div id="MainContent_div_error" name="div_error" class="alert alert-danger ns_">
          <b>¡Error! </b>Debes ingresar todos los campos obligatorios.
        </div>      
      </div>
    </div>
  </div>
</div>
<div class="container">
  <h3>Datos de la trabajadora / del trabajador</h3>
  <hr class="red">
  <div class="form-group">
      <div class="col-md-8">
          <label for="dstCurp" class="control-label">Clave Única de Registro de Población (CURP) <span class="obligatorio">*</span>: </label>
          <div class="input-group">
              <input type="text" class="ns_ form-control" id="dstCurp" name="dstCurp" placeholder="Clave &uacute;nica de registro de poblaci&oacute;n" maxlength="18" required>
              <a href="javascript:buscarCURPTexto();" class="input-group-addon">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
              </a>
              <a href="javascript:eliminarCURP();" class="input-group-addon">
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
              </a>
          </div>
      </div>
  </div>
</div>
<div class="container">
  <h3>Datos de usuaria / usuario</h3>
  <hr class="red">
  <div class="form-group">
      <div class="col-md-4">
          <label for="duCorreoElectronico" class="control-label">Correo electrónico<span class="obligatorio">*</span>: </label>
          <input type="text" class="form-control user" id="duCorreoElectronico" name="duCorreoElectronico" placeholder="Ingresa tu correo electrónico" required>
      </div>
      <div class="col-md-4">
          <label for="duCorreoElectronico2" class="control-label">Confirmar correo electrónico<span class="obligatorio">*</span>:</label>
          <input type="email" class="form-control user" id="duCorreoElectronico2" name="duCorreoElectronico2" placeholder="Confirma tu correo electrónico" required>
      </div>
      <div class="col-md-4"></div>
  </div>
  
  <div class="form-group">
      <div class="col-md-4">
          <label for="duClaveAcceso" class="control-label">Contraseña<span class="obligatorio">*</span>:</label>
          <input type="password" class="form-control user" id="duClaveAcceso" name="duClaveAcceso" placeholder="Ingresa una contraseña" maxlength="12" required>
      </div>
      <div class="col-md-4">
          <label for="duClaveAcceso2" class="control-label">Confirmar contraseña<span class="obligatorio">*</span>: </label>
          <input type="password" class="form-control user" id="duClaveAcceso2" name="duClaveAcceso2" placeholder="Confirma tu contraseña" maxlength="12" required>
      </div>
      <div class="col-md-4"></div>
  </div>
</div>
<div id="mdlLineamientos" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn close" aria-label="Aceptar" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Lineamientos de participaci&oacute;n</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                        include_once APP.'view/documentation/index.php';
                    ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="container">
    <br>
    <div class="col-md-7" align="left">
        <p><br>
            <font>* Campos obligatorios </font><br>
        </p>         
    </div>
    <div class="col-md-5" align="right">
      <button id="exit" type="button" class="btn btn-danger">Salir</button>
      <button id="register" type="button" formmethod="post" class="btn btn-primary" >Registrarme</button>
    </div>
</div>
<br>
<br>
</form>