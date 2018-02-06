<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Usuariosnoinscritos extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuariosnoinscritosmodel');
    $this->load->model('cursosmodel');
	}

	public function find_get($id){
		if (!$id){
			$this->response(null,400);
		}
		$usuarionoinscrito = $this->usuariosnoinscritosmodel->get($id);
		 $curso = $this->cursosmodel->get($id);
    if (!is_null($curso)){
  		if (!is_null($usuarionoinscrito)){
  			$this->response(array('response'=> $usuarionoinscrito),200);
  		}else{
  			$this->response(array('response'=>array()),200);
  		}
    }else{
      $this->response(array('error'=>'El curso no existe'),400);
    }
	}

    //Añadir un nuevo usuarionoinscrito
	public function index_post(){
		
		}

	//actualizar en la bd usuarionoinscrito
	public function index_put(){
		
		}

	//borrar en la bd usuarionoinscrito
	public function index_delete(){
		
		}


}