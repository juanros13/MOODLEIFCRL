<?php
class Login extends CI_Controller {

  public function view()
  {
    $this->load->view('templates/header');
    $this->load->view('login/login.php');
    $this->load->view('templates/footer');
  }
}