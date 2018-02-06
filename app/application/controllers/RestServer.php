<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Restserver extends REST_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->database();
    $this->load->helper('url');
  }
  public function users_get() {
    $this->load->model('usermodel');
    $this->response($this->usermodel->getAllUsers());
  }
}