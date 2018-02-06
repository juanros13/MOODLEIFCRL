<?php

class UsuariosInscritosModel extends CI_Model 
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
    
    $this->db->select('mdl_user.id id_usuario,mdl_user.firstname as nombres,mdl_user.lastname as apellidos,mdl_user.email,mdl_course.id as id_curso,mdl_course.fullname as nombre_curso, mdl_alt_tbl_user_common_data.curp');
    $this->db->from('mdl_user');
    $this->db->join('mdl_user_enrolments', 'mdl_user.id = mdl_user_enrolments.userid');
    $this->db->join('mdl_enrol', 'mdl_user_enrolments.enrolid = mdl_enrol.id');
    $this->db->join('mdl_course', 'mdl_enrol.courseid = mdl_course.id');
    $this->db->join('mdl_alt_tbl_user_common_data', 'mdl_user.id = mdl_alt_tbl_user_common_data.iduser', 'left');
    $this->db->where('mdl_course.id',$id);
    $query= $this->db->get();
		if ($query->num_rows()>0)
		{
				return $query->result_array();
		}
		return null;	

	}
}