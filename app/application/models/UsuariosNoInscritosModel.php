<?php

class UsuariosNoInscritosModel extends CI_Model 
{
	public function __construct(){
		parent::__construct();	
	}
  public function get($id=null){
    if (is_null($id))
    {
      return null;
    }

    //$query= $this->db->select('*')->from ('mdl_vw_alumnosInscritos')->get();
    //$query= $this->db->select('*')->from ('mdl_vw_alumnosInscritos')->where('idCurso',$id)->get();
    
    $this->db->select('mdl_user.id');
    $this->db->from('mdl_user');
    $this->db->join('mdl_user_enrolments', 'mdl_user.id = mdl_user_enrolments.userid');
    $this->db->join('mdl_enrol', 'mdl_user_enrolments.enrolid = mdl_enrol.id');
    $this->db->join('mdl_course', 'mdl_enrol.courseid = mdl_course.id');
   
    $this->db->where('mdl_course.id',$id);



    $array = array();
    $subQuery= $this->db->get();
    foreach($subQuery->result_array() as $row)
    {
        $array[] = $row['id']; // add each user id to the array
    }
    //print_r($subQuery);
    //return null;

    //$this->db->_reset_select();

    $this->db->select('mdl_user.id id_usuario,mdl_user.firstname as nombres,mdl_user.lastname as apellidos,mdl_user.email,mdl_alt_tbl_user_common_data.curp');
    $this->db->from('mdl_user');
    $this->db->join('mdl_user_enrolments', 'mdl_user.id = mdl_user_enrolments.userid', 'left');
    $this->db->join('mdl_enrol', 'mdl_user_enrolments.enrolid = mdl_enrol.id', 'left');
    $this->db->join('mdl_course', 'mdl_enrol.courseid = mdl_course.id');
    $this->db->join('mdl_alt_tbl_user_common_data', 'mdl_user.id = mdl_alt_tbl_user_common_data.iduser', 'left');
    $this->db->join('mdl_context', 'mdl_course.id = mdl_context.instanceid AND mdl_context.contextlevel = "50"');
    $this->db->join('mdl_role_assignments', 'mdl_role_assignments.contextid = mdl_context.id');
    $this->db->join('mdl_role', 'mdl_role.id = mdl_role_assignments.roleid');

    if($array){
      $this->db->where_not_in('mdl_user.id', $array);
    }
    $this->db->group_by('mdl_user.id'); 
    $query = $this->db->get();
    if ($query->num_rows()>0)
    {
      return $query->result_array();
    }
    return null;  

  }
}