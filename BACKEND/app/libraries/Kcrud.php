<?php

/**
 * Created by Nikila Perera.
 * User:Nikila Perera
 * Email:nikilabanuka@gmail.com
 * Date: 10/08/2024
 */


class Kcrud extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //data save
    public function save($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    //data update
    public function update($table,$data,$where){
        $this->db->update($table,$data,$where);
        return true;
    }

    //data delete
    public function delete($table,$where){
        $this->db->delete($table,$where);
        return true;
    }

    public function getDatatableInfo($select,$table,$where,$join,$action,$unset_column){

        $this->load->library('datatables');

        $this->datatables->select($select,FALSE);

        $this->datatables->from($table);
        if($where){
            $this->datatables->where($where);
        }
        if($join){
            $this->datatables->join($join);
        }
        if($action){
            $this->datatables->add_column("Actions",$action,$unset_column);
        }
        $this->datatables->unset_column($unset_column);
        echo $this->datatables->generate();

    }

    public function getValueOne($table,$select,$where,$like,$join,$group,$order){

        $query=$this->db->query("SELECT $select FROM $table $join $where $like $group $order");
        return $query->row();
    }

    public function getValueAll($table,$select,$where,$like,$join,$group,$order){

        $query=$this->db->query("SELECT $select FROM $table $join $where $like $group $order");
        return $query->result();
    }

}