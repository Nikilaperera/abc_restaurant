<?php

class MemberToRegisterMod extends CI_Model
{
    const MAX_PASSWORD_SIZE_BYTES = 4096;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getTempId($year)
    {
        $this->db->select('tbl_students_register.temp_student_id');
        $this->db->from('tbl_students_register');
        $this->db->order_by('temp_student_id', 'desc');
        $this->db->like('temp_student_id', $year, 'both');
        $query = $this->db->get();
        return $query->row();
    }

    public function getValueAll($table,$select,$where,$like,$join,$group,$order){

        $query=$this->db->query("SELECT $select FROM $table $join $where $like $group $order");
        return $query->result();
    }

    public function getValueOne($table,$select,$where,$like,$join,$group,$order){

        $query=$this->db->query("SELECT $select FROM $table $join $where $like $group $order");
        return $query->row();
    }

    public function save($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    //data update
    public function update($table,$data,$where){
        $this->db->update($table,$data,$where);
        return true;
    }

    function get_registered_students($nic)
    {
        $this->db->select('*');
        $this->db->from('tbl_students_register');
        $this->db->where('nic', $nic);
        $query = $this->db->get();
        return $query->row();
    }

}
