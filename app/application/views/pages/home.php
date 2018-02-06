<!-- SLIDER -->
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1" class=""></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="<?php echo base_url();?>/assets/img/ima1.jpg" data-holder-rendered="true">
      <div class="carousel-caption d-none d-md-block">
        <h3>Curso nuevo</h3>
        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
      </div>
    </div>
     <div class="carousel-item">
      <img class="d-block w-100" src="<?php echo base_url();?>/assets/img/ima2.jpg" data-holder-rendered="true">
      <div class="carousel-caption d-none d-md-block">
        <h3>Curso nuevo</h3>
        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!-- END SLIDER -->
<div class="sep hbar"></div>
<div class="opciones">
  <div class="container text-center">
    <a href="<?php echo base_url();?>login" class="btn btn-success btn-lg">INICIAR SESIÓN</a>
    <a href="<?php echo base_url();?>register/user_type" class="btn btn-success btn-lg">REGISTRO</a>
  </div>
</div>
<div class="sep hbar"></div>

<div class="noticias">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 ">
        <h2>NOTICIAS</h2>
      </div>
      <?php foreach ($announcements as $key => $announcement) { ?>
      <div class="col-sm-3 noticias-border-left">
        <h5><?= $announcement['subject']?></h5>
        <?= word_limiter($announcement['message'], 20) ?><br>
       <span><?= $announcement['created'] ?></span>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
