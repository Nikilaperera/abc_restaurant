<?php

class TableModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_table');
        return $query->result();
    }
}
