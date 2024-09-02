<?php
class SystemLogModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('auth_system_log');
        return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }
  
 

}