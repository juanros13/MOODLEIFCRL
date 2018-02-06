<div class="login">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 form-container">
        <h1>INGRESAR</h1>
        <hr>
        <form class="form-horizontal" id="formLogin" action="<?php echo $this->config->item('moodle_url');?>login/index.php" method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Correo Electrónico</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter email"  id="username" name="username">
            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" placeholder="Contraseña"  id="password" name="password">
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>