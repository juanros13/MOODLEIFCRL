<div class="bs-example">    
  <!-- Modal HTML -->
  <div id="genericModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="modalHeader" class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div id="modalMessage" class="modal-body">
          <p></p>
        </div>
        <div id="modalFooter" class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>
<form action="#" class="form-horizontal" id="frmRegistro" name="frmRegistro" class="ns_" >

  <div class="container">
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
          <h1>Registro de Publico en General</h1>
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
          <input type="text" class="ns_ form-control" id="curp" name="curp" placeholder="Clave &uacute;nica de registro de poblaci&oacute;n" maxlength="18" value="ROVJ880131HDFSRN05" required>
          <a href="javascript:buscarCURP();" class="input-group-addon">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </a>
          <a href="javascript:eliminarCURP();" class="input-group-addon">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <br /><p></p>
        <button type="button" class="btn btn-link" onclick="javascript:window.open('https://consultas.curp.gob.mx/CurpSP/gobmx/inicio.jsp');">Busca tu CURP</button>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-4">
          <label for="nombreUsuario" class="control-label">Nombre(s)<span class="obligatorio">*</span>:</label>
          <input type="text" class="ns_ form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ingresa tu(s) nombre(s)" required>
      </div>
      <div class="col-md-4">
          <label for="dstApellidoPaterno" class="control-label">Primer apellido<span class="obligatorio">*</span>: </label>
          <input type="text" class="ns_ form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Ingresa tu primer apellido" required>
      </div>
      <div class="col-md-4">
          <label for="dstApellidoMaterno" class="control-label">Segundo apellido<span class="obligatorio">*</span>: </label>
          <input type="text" class="ns_ form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Ingresa tu segundo apellido" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-4">
        <label for="dstSexo" class="control-label">Sexo<span class="obligatorio">*</span>: </label>
        <select class="form-control" id="sexo" name="sexo" required>
          <option value="">Selecciona una opción</option>
          <option value="H">Hombre</option>
          <option value="M">Mujer</option>
        </select>
      </div>
      <div class="col-md-4">
        <div class="datepicker-group">
          <label for="dstFechaNacimiento" class="control-label">Fecha de nacimiento<span class="obligatorio">*</span>: </label>
          <input type="text" class="ns_ form-control" id="fechaNacimiento" name="fechaNacimiento" placeholder="dd/mm/aaaa" required>
          <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
        </div>
      </div>
      <div class="col-md-4">
       <label for="dstEstadoNacimiento" class="control-label">Lugar de nacimiento<span class="obligatorio">*</span>: </label>
        <select class="ns_ form-control" id="estadoNacimiento" name="estadoNacimiento" required>
          <option value="">Selecciona una opción</option>
        </select>
      </div>
    </div>
    <h3>Maximo grado de estudios</h3>
    <hr class="red">
    <div class="form-group">
      <div class="col-md-4">
        <label for="nivelAcademico" class="control-label">Nivel académico<span class="obligatorio">*</span>: </label>
        <select class="ns_ form-control" id="nivelAcademico" name="nivelAcademico" required>
          <option value="">Selecciona una opción</option>
        </select>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-4"></div>
    </div>
    <h3>Lugar donde radica</h3>
    <hr class="red">
    <div class="form-group">
      <div class="col-md-4">
        <label for="estadoRadica" class="control-label">Estado<span class="obligatorio">*</span>: </label>
        <select class="ns_ form-control" id="estadoRadica" name="estadoRadica" required>
          <option value="">Selecciona una opción</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="municipio" class="control-label">Municipio o Alcaldía<span class="obligatorio">*</span>: </label>
        <select class="ns_ form-control" id="municipio" name="municipio" required>
          <option value="">Selecciona una opción</option>
        </select>
      </div> 
      <div class="col-md-4">
        <label for="localidad" class="control-label">Colonia<span class="obligatorio">*</span>: </label>
        <select class="ns_ form-control" id="localidad" name="localidad" required>
          <option value="">Selecciona una opción</option>
        </select>
      </div>
    </div>
    <h3>Datos laborales</h3>
    <hr class="red">
    <div class="form-group">
      <div class="col-md-4">
        <label for="duCorreoElectronico" class="control-label">Institución<span class="obligatorio">*</span>: </label>
        <input type="text" class="form-control user" id="institucion" name="institucion" placeholder="Institución" required>
      </div>
      <div class="col-md-4">
        <label for="dstMunicipio" class="control-label">Cargo<span class="obligatorio">*</span>: </label>
        <input type="text" class="form-control user" id="cargo" name="cargo" placeholder="Cargo" maxlength="12" required>
      </div> 
    </div>
  </div>
  <div class="container">
    <h3>Datos de usuaria / usuario</h3>
    <hr class="red">
    <div class="form-group">
        <div class="col-md-4">
            <label for="duCorreoElectronico" class="control-label">Correo electrónico<span class="obligatorio">*</span>: </label>
            <input type="text" class="form-control user" id="correoElectronico" name="correoElectronico" placeholder="Ingresa tu correo electrónico" required>
        </div>
        <div class="col-md-4">
            <label for="duCorreoElectronico2" class="control-label">Confirmar correo electrónico<span class="obligatorio">*</span>:</label>
            <input type="email" class="form-control user" id="correoElectronico2" name="correoElectronico2" placeholder="Confirma tu correo electrónico" required>
        </div>
        <div class="col-md-4"></div>
    </div>
    
    <div class="form-group">
        <div class="col-md-4">
            <label for="duClaveAcceso" class="control-label">Contraseña<span class="obligatorio">*</span>:</label>
            <input type="password" class="form-control user" id="claveAcceso" name="claveAcceso" placeholder="Ingresa una contraseña" maxlength="12" required>
        </div>
        <div class="col-md-4">
            <label for="duClaveAcceso2" class="control-label">Confirmar contraseña<span class="obligatorio">*</span>: </label>
            <input type="password" class="form-control user" id="claveAcceso2" name="claveAcceso2" placeholder="Confirma tu contraseña" maxlength="12" required>
        </div>
        <div class="col-md-4"></div>
    </div>
  </div>
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
</form>