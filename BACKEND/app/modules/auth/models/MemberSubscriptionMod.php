<?php

class MemberSubscriptionMod extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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
}
