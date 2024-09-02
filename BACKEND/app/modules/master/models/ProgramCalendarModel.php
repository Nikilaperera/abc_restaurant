<?php
class ProgramCalendarModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_master_batch.*,tbl_master_programs.name AS program_name');
        $this->db->from('tbl_master_batch');
        $this->db->join('tbl_master_programs','tbl_master_programs.code=tbl_master_batch.program');
        $query=$this->db->get();
		return $query->result();
    }
}