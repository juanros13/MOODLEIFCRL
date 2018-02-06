<?php
class RegisterModel extends CI_Model {

  public $title;
  public $content;
  public $date;

  public function get_all_states()
  {
    $query = $this->db->get('mdl_alt_tbl_state');
    return $query->result();
  }
  public function get_all_academic_levels()
  {
    $query = $this->db->get('mdl_alt_tbl_academiclevel');
    return $query->result();
  }
  public function get_town_by_id_state($idState)
  {
    $this->db->select('*');
    $this->db->from('mdl_alt_tbl_town');
    $this->db->where('idstate', $idState);
    $query = $this->db->get();
    return $query->result();
  }
  public function getLocalityByIdTown($idTown)
  {
    $this->db->select('*');
    $this->db->from('mdl_alt_tbl_locality');
    $this->db->where('idtown', $idTown);
    $query = $this->db->get();
    return $query->result();
  }
  public function saveUser($data)
  {
    return $this->db->insert('mdl_user', $data); 
  }
  public function getUserExist($email = null){
    $this->db->select('id');
    $this->db->from('mdl_user');
    $this->db->where('email', $email);
    $query = $this->db->get();
    $result = $query->row();
    return  $result;
  }
  public function getEstado($id_estado)
  {
    $this->db->select('*');
    $this->db->from('mdl_alt_tbl_state');
    $this->db->where('idstate', $id_estado);
    $query = $this->db->get()->row_array();
    return $query;
    //return $query ? $query->fetch(PDO::FETCH_ASSOC) : 'false'; 
    //foreach($query->result_array() as $row){
    //echo $row['someContent'];
    //}
  }
  public function getUserCurpExists($curp){
    $this->db->select('*');
    $this->db->from('mdl_alt_tbl_user_common_data');
    $this->db->where('curp', $curp);
    $query = $this->db->get()->row_array();
    return $query;
  }
  public function getUserNameExists($email){
    $this->db->select('*');
    $this->db->from('mdl_user');
    $this->db->where('email', $email);
    $query = $this->db->get()->row_array();
    return $query;
  }
  public function saveAltUserCommonData($altUserCommonData){
        // Conexión a la base de datos
        $var = $altUserCommonData['birthdate'];
        $birthdate = str_replace('/', '-', $var);
        $birthdate = date("Y-m-d", strtotime($birthdate));
        // Grabado de información
        try {
         $data = array(
             'iduser'                  => $altUserCommonData['iduser'],
             'gender'                  => $altUserCommonData['gender'],
             'birthdate'               => $birthdate,
             'idbornstate'             => $altUserCommonData['idbornstate'],
             'curp'                    => $altUserCommonData['curp'],
             'idacademiclevel'         => $altUserCommonData['idacademiclevel'],
             'idstaterequest'          => $altUserCommonData['idstaterequest'],
             'idlocalityrequest'       => $altUserCommonData['idlocalityrequest'],
             'idtownrequest'           => $altUserCommonData['idtownrequest'],
             'institution'             => $altUserCommonData['cargo'],
             'appointment'             => $altUserCommonData['institucion'],
          );
          $result = $this->db->insert('mdl_alt_tbl_user_common_data', $data);
          return $result;
        } catch (Exception $e) {
            // En caso de error
            echo $e->getMessage();
            return false;
        }
    }
}

