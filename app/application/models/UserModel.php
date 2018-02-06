<?php
class UserModel extends CI_Model {

  public $title;
  public $content;
  public $date;

  public function getAllUsers()
  {
    $query = $this->db->get('mdl_user');
    return $query->result();
  }
 
  }
}