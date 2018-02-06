<!doctype html>
<html lang="en">
  <head>
    <title>STPS NUEVO INSTITUTO CAPACITACIÓN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url();?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url();?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url();?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url();?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url();?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url();?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/main.css">
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-company-blue">
        <div class="container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item <?php if($this->uri->segment(1)== ""){echo "active";}?>">
                <a class="nav-link " href="<?php echo base_url();?>">INICIO</a>
              </li>
              <li class="nav-item <?php if($this->uri->segment(1)=="conocenos"){echo "active";}?>">
                <a class="nav-link " href="<?php echo base_url();?>conocenos">CONOCENOS</a>
              </li>
              <li class="nav-item <?php if($this->uri->segment(1)=="catalogocursos"){echo "active";}?>">
                <a class="nav-link" href="<?php echo base_url();?>catalogocursos">CURSOS</a>
              </li>
              <li class="nav-item <?php if($this->uri->segment(1)=="soporte" || $this->uri->segment(1)=="faq"  || $this->uri->segment(1)=="documentacion" || $this->uri->segment(1)=="manual"){echo "active";}?>">
                <a class="nav-link" href="<?php echo base_url();?>soporte">SOPORTE</a>
              </li>
              <li class="nav-item <?php if($this->uri->segment(1)=="contactanos"){echo "active";}?>">
                <a class="nav-link" href="<?php echo base_url();?>contactanos">CONTACTANOS</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="header">
        <div class="container">
          <div class="row">
            <div class=".col-md-6">
              <img src="<?php echo base_url();?>assets/img/logo_procat_1.png"  alt="Responsive image">
            </div>
            <div class=".col-md-6">
              <img src="<?php echo base_url();?>assets/img/logo_procat_3.png"  alt="Responsive image">
            </div>
          </div>
        </div>
      </div>
    </header>