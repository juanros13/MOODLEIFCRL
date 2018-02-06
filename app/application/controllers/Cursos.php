<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Cursos extends REST_Controller {

	public function __construct()
		{
		parent::__construct();
		$this->load->model('cursosmodel');

		}
	//todos los cursos
	public function index_get(){
		$cursos = $this->cursosmodel->get();
		if (!is_null($cursos))
			{
				$this->response(array('response'=> $cursos),200);
			}else
			{
				$this->response(array('error'=> 'No hay cursos'),400);

			}

		}
    // un curso en concreto se pasa id
	public function find_get($id){
		if (!$id){
			$this->response(null,400);
		}
		$curso = $this->cursosmodel->get($id);
		
		if (!is_null($curso)){
			$this->response(array('response'=> $curso),200);
		}else{
			$this->response(array('error'=>'No hay curso'),400);
		}
	}

    //Añadir un nuevo curso
	public function index_post(){
		
		}

	//actualizar en la bd curso
	public function index_put(){
		
		}

	//borrar en la bd curso
	public function index_delete(){
		
		}


}