<?php
class CatalogoCursosModel extends CI_Model {

  public $title;
  public $content;
  public $date;

  public function getAllCategories()
  {
    //$query = $this->db->get('mdl_course_categories');
    //sreturn $query->result();


    $this->db->select('mdl_course_categories.name, mdl_course.shortname, mdl_course.fullname');
    $this->db->from('mdl_course');
    $this->db->join('mdl_course_categories', 'mdl_course_categories.id = mdl_course.category ', 'left');
    //$this->db->where('mdl_course.category !=',0);
    $query= $this->db->get();

    if ($query->num_rows()>0)
    {
        return $query->result_array();
    }
    return null;  
  }
  public function getTopAnnouncements()
  {

    $this->db->select("from_unixtime(mdl_forum_posts.created,'%d/%m/%Y') as created, mdl_forum_posts.subject, mdl_forum_posts.message");
    $this->db->from('mdl_forum_posts');
    $this->db->join('mdl_forum_discussions', 'mdl_forum_discussions.id = mdl_forum_posts.discussion ', 'left');
    $this->db->where('mdl_forum_discussions.course', 1);
    $this->db->order_by("mdl_forum_posts.created", "asc");
    $this->db->limit(3, 0);

    //$this->db->where('mdl_course.category !=',0);
    $query= $this->db->get();

    if ($query->num_rows()>0)
    {
        return $query->result_array();
    }
    return null;  
  }
 
}