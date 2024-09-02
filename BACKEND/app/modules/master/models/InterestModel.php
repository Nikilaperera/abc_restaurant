<?php
class InterestModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_lead_interest_level');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_lead_interest_level', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_interest($interest_id)
    {
        $this->db->where("id", $interest_id);
        $query = $this->db->get('tbl_master_lead_interest_level');
        return $query->row();
    }
    function update_interest($interest_id, $data)
    {
        $this->db->where("id", $interest_id);
        return $this->db->update("tbl_master_lead_interest_level", $data);
    }

    function delete_single_interest($interest_id)
    {
        return $this->db->delete('tbl_master_lead_interest_level', ['id' => $interest_id]);
    }

    //check duplicate
    function checkDuplication($code)
    {
            $this->db->select("tbl_master_lead_interest_level.id");
            $this->db->from("tbl_master_lead_interest_level");
            $this->db->where("(code = '$code')");
            $query = $this->db->get();
            return $query->row();
        
    }
    
    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_master_lead_interest_level.id");
        $this->db->from("tbl_master_lead_interest_level");
        $this->db->where("(code = '$code') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}