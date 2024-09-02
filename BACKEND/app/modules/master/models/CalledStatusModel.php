<?php
class CalledStatusModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_lead_called_status');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_lead_called_status', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_lead_called_status');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_lead_called_status", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_lead_called_status', ['id' => $id]);
         
    }

    function checkDuplication($code)
    {
        $this->db->where("code", $code);
        $query = $this->db->get('tbl_master_lead_called_status');
        return $query->row();
    }

    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_master_lead_called_status.id");
        $this->db->from("tbl_master_lead_called_status");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}