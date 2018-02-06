<?php

class CursosModel extends CI_Model 
{
	public function __construct(){
		parent::__construct();	

		}

	public function get($id=null){
			$this->db->select('mdl_course.id, mdl_course.fullname, mdl_course_categories.name as category, mdl_course.shortname, mdl_course.summary, mdl_course.timecreated,  mdl_course.timemodified, "01/01/18" as datestart, "31/03/18" as datefinish');
      $this->db->from('mdl_course');
      $this->db->join('mdl_course_categories', 'mdl_course.category = mdl_course_categories.id', 'left');
      if (!is_null($id)){
        $this->db->where('mdl_course.id',$id);
      } 
      $query= $this->db->get();
			if ($query->num_rows()==1){
				return $query->row_array();
			}
      if ($query->num_rows()>0)
      {
        return $query->result_array();
      }
			return null;
	}
}