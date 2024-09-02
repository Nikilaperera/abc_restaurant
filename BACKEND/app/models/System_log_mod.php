<?php


class System_log_mod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_system_log($data)
    {
       
        $this->db->insert('auth_system_log', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}