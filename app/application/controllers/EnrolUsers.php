<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class EnrolUsers extends REST_Controller {

  public function __construct()
  {
  parent::__construct();

  }
  
  public function index_get(){
    $courseid = $this->input->get('courseid');
    $arrayUsers = $this->input->get('users');
    $users = explode(',', $arrayUsers);
    if(isset($courseid) and isset($arrayUsers)){
      if (!empty($users)) {
        require_once(APPPATH.'libraries/CURLMOODLE.php');
        $respuesta  = [];
        foreach ($users as $userid ) {
          //echo $userid;
          //echo $courseid;
          $token = 'fb84bcf20b68fbefe47ce812054ba8fb';
          $domainname = 'http://stpsinstitutolearn.azurewebsites.net/moodle';
          $functionname = 'enrol_manual_enrol_users';
          $restformat = 'json';
          //////// enrol_manual_enrol_users ////////
          /// Paramètres
          $enrolment = new stdClass();
          $enrolment->roleid = 5; //estudante(student) -> 5; moderador(teacher) -> 4; professor(editingteacher) -> 3;
          $enrolment->userid = $userid;
          $enrolment->courseid = $courseid; 
          $enrolments = array( $enrolment);
          $params = array('enrolments' => $enrolments);
          
          
          $serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
          
          $curl = new curl;
          //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
          $restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
          $resp = $curl->post($serverurl . $restformat, $params);
          if ($resp) {
            $respuesta[$userid]['success'] = 'true';
          }else{
            $respuesta[$userid]['success']  = 'false';
            $respuesta[$userid]['mensaje'] = 'No se pudo Enrolar en usuario en el curso deseado';
          }
        }
        if(!is_null($respuesta)){
          $this->response(array('response'=> $respuesta),200);
        }else{
          $this->response(array('error'=> 'No se pudo Enrolar en usuario en el curso deseado'),400);
        }

      }
    }else{
      $this->response(null,400);
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