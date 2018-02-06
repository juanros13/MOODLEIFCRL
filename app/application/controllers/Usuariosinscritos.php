<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Usuariosinscritos extends REST_Controller {

	public function __construct()
	{
  	parent::__construct();
  	$this->load->model('usuariosinscritosmodel');
    $this->load->model('cursosmodel');

	}
	
    // un usuarioinscrito en concreto se pasa id
	public function find_get($id=null){
		//echo 'usuarioinscrito número ' . $id;
		if (!$id){
			$this->response(null,400);
		}
    $curso = $this->cursosmodel->get($id);
		$usuarioinscrito = $this->usuariosinscritosmodel->get($id);
    if (!is_null($curso)){
      if (!is_null($usuarioinscrito)){
        $this->response(array('response'=> $usuarioinscrito),200);
      }else{
        $this->response(array('response'=>array( )),200);
      }
    }else{
      $this->response(array('error'=>'El curso no existe'),400);
    }
		
			
	}

    //Añadir un nuevo usuarioinscrito
	public function index_post(){
		
		}

	//actualizar en la bd usuarioinscrito
	public function index_put(){
		
		}

	//borrar en la bd usuarioinscrito
	public function index_delete(){
		
		}


}