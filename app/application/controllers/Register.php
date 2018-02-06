<?php
class Register extends CI_Controller {

  public function user_type()
  {
    $this->load->view('templates/header_gobmx');
    $this->load->view('register/tipo_usuario');
    $this->load->view('templates/footer_gobmx');
  }
  public function employee()
  {
    $this->load->view('templates/header_gobmx.php');
    $this->load->view('register/general_public' );
    $this->load->view('templates/footer_gobmx.php');
  }
  public function general_public()
  {
    $this->load->view('templates/header_gobmx.php');
    $this->load->view('register/general_public' );
    $this->load->view('templates/footer_gobmx.php');
  }
  public function fillMdlUserData($estado = false)
  {
      $mdlUserData = [];
      $email       = strtolower(filter_var($_POST['correoElectronico'], FILTER_VALIDATE_EMAIL));
      $secret      = md5(time() . $_POST['claveAcceso'] . 'WOLOLO1'); // genera clave secreta
      $secret      = substr($secret, '0', '15');                 // trunca la clave a 15 caracteres
      
      $password    = password_hash($_POST['claveAcceso'], 1, array('cost' => 10));   // usa funcion de moodle para crear pass  

      $mdlUserData = [
          'username'  => $email,
          'password'  => $password,
          'email'     => $email,
          'secret'    => $secret,
          'country'   => 'MX',
          'lang'      => 'es_MX',
          'city'      => ''
      ];

      $mdlUserData['firstname'] = $_POST['nombreUsuario'];
      $mdlUserData['lastname']  = $_POST['apellidoPaterno'] . ' ' . $_POST['apellidoMaterno'];

      $token = '1ee4e83895cb7394fe0df5503c0ebd9d';
      $domainname = 'http://172.16.50.37/ifcrl/moodle';

      $functionname = 'core_user_create_users';
      $restformat = 'json';

      $user1 = new stdClass();
      $user1->username = $email;
      $user1->password = $_POST['claveAcceso'];
      $user1->firstname = $_POST['nombreUsuario'];
      $user1->lastname = $_POST['apellidoPaterno'] . ' ' . $_POST['apellidoMaterno'];
      $user1->email = $email;
      $user1->timezone = 'America/Mexico_City';
      $user1->lang = 'es_mx';
      $user1->country = 'MX';
      $user1->city = $estado;

      $users = array($user1);
      $params = array('users' => $users);


      //header('Content-Type: text/plain');
      $serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
      require_once(APPPATH.'libraries/CURLMOODLE.php');
      $curl = new curl;
      //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
      $restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
      $resp = $curl->post($serverurl . $restformat, $params);
      //print_r($resp);
      return json_decode($resp);
  }
  public function saveUser()
  {
    $this->load->model('registermodel');
    header('Content-Type: application/json');
    if($this->input->is_ajax_request()) {
      // Consulta si existe el usuario ya registrado
      $email     = strtolower(filter_var($_POST['correoElectronico'], FILTER_VALIDATE_EMAIL));
      $userExist = $this->registermodel->getUserExist($email);
      // si el arreglo de parametros no esta vacio y si no existe el usuario en la base da datos
      if (!$userExist) {
          // construir objeto mdlUserData
        $estado = $this->registermodel->getEstado(intval($_POST['estadoRadica']));
        //print_r($estado);
        $mdlUserData = $this->fillMdlUserData($estado['description']);

        //agregando el estado a $mdlUserData
        
        //$mdlUserData['city'] = $estado['description'];
        // agrega el usuario a la tabla de moodle mdl_user
        //$this->registermodel->saveUser($mdlUserData);

        // obtiene el id del usuario recien insertado
        //$userId = $this->registermodel->getUserExist($email);
        if ($mdlUserData[0]->id) {
          // Construye el objeto alternateUserData
          $alternateUserData = $this->fillAlternateUserData($mdlUserData[0]->id);

          // agrega el usuario a la tabla mdl_alt_tbl_user_common_data
          //RegisterModel::saveAltUserCommonData($alternateUserData);
          $this->registermodel->saveAltUserCommonData($alternateUserData);
          // envia email para informar que continue con la encuesta
          //$resultEmail = Helper::sendRegistroEmail($userId, $mdlUserData['fullName'], $mdlUserData['urlSurvey'], $email);
          echo '{"success": true}' ;
        }else{
          print_r(json_encode($mdlUserData));
        }
      } else {
        echo '{"success": false}';
      }
    } else {
        header('Location: ' . URL);
    }
  }
  public function fillAlternateUserData($userId)
    {
        $alternateUserData = [];

        $alternateUserData = [
            'iduser'            => $userId,
            'idbranchlevel'     => 1,
            'fieldid'           => 2,
            'data'              => 0,
        ];

        $alternateUserData['gender']            = $_POST['sexo'];
        $alternateUserData['birthdate']         = $_POST['fechaNacimiento'];
        $alternateUserData['idbornstate']       = intval($_POST['estadoNacimiento']);
        $alternateUserData['curp']              = $_POST['curp'];
        $alternateUserData['idacademiclevel']   = intval($_POST['nivelAcademico']);
        $alternateUserData['idstaterequest']    = intval($_POST['estadoRadica']);
        $alternateUserData['idlocalityrequest'] = intval($_POST['localidad']);
        $alternateUserData['idtownrequest']     = intval($_POST['municipio']);
        $alternateUserData['cargo'] = $_POST['cargo'];
        $alternateUserData['institucion']   = $_POST['institucion'];

        return $alternateUserData;
    }
  public function getDataByCURP($curp)
  {
      require_once(APPPATH.'libraries/CURP.php');
      header('Content-Type: application/json');
      $objCurp = new CURP();
      $result  = $objCurp->getDataByCURP($curp);
      echo ($result && $result!=null) ? '{"success": true, "data": '.json_encode($result).'}' : '{"success": false}';
  }
  public function getStateAll()
  {
    $this->load->model('registermodel');
    header('Content-Type: application/json');
    if ($this->input->is_ajax_request()) {
        $result = $this->registermodel->get_all_states();
        echo $result ? json_encode($result) : '[]';
    } else {
        header('Location: ' . URL);
    }
  }
  public function getAcademicLevelAll()
  {
    $this->load->model('registermodel');
    if ($this->input->is_ajax_request()) {
        $result = $this->registermodel->get_all_academic_levels();
        echo $result ? json_encode($result) : '[]';
    } else {
        header('Location: ' . URL);
    }
  }
  public function getTownByIdState()
  {
    if ($this->input->is_ajax_request()) {
      $this->load->model('registermodel');
      $result = $this->registermodel->get_town_by_id_state($this->input->get('data'));
      echo $result ? json_encode($result) : '[]';
     } else {
        header('Location: ' . URL);
    }
  }
  public function getLocalityByIdTown()
  {
    if ($this->input->is_ajax_request()) {
      $this->load->model('registermodel');
      $result = $this->registermodel->getLocalityByIdTown($this->input->get('data'));
      echo $result ? json_encode($result) : '[]';
     } else {
        header('Location: ' . URL);
    }
  }
  public function userCurpExists($email)
  {
    header('Content-Type: application/json');
    if ($this->input->is_ajax_request()) {

      $this->load->model('registermodel');
      $result = $this->registermodel->getUserCurpExists($email);
      echo $result ? '{"success": true}' : '{"success": false}' ;
     } else {
        header('Location: ' . URL);
    }
  }
  public function userNameExists($email)
  {
    header('Content-Type: application/json');
    if ($this->input->is_ajax_request()) {

      $this->load->model('registermodel');
      $result = $this->registermodel->getUserNameExists($email);
      echo $result ? '{"success": true}' : '{"success": false}' ;
     } else {
        header('Location: ' . URL);
    }
  }
  
}