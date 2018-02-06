<?php
class CatalogoCursos extends CI_Controller {

  public function view()
  {

    $this->load->model('catalogocursosmodel');
    $data['cursos'] =  $this->catalogocursosmodel->getAllCategories();
    $this->load->view('templates/header');
    $this->load->view('pages/cursos.php', $data); 
    $this->load->view('templates/footer');
  }
}