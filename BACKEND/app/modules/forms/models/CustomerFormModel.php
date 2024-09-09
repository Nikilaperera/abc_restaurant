<?php

class CustomerFormModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetchAllTables()
    {
        $this->db->select('tbl_master_table.*');
        $this->db->from('tbl_master_table');
        $this->db->where("tbl_master_table.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }
}
