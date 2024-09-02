<?php
class LeadsourceModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_lead_source');
		return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('tbl_master_lead_source');
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_lead_source', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_source($source_id)
    {
        $this->db->where("id", $source_id);
        $query = $this->db->get('tbl_master_lead_source');
        return $query->row();
    }
    function update_source($source_id, $data)
    {
        $this->db->where("id", $source_id);
        return $this->db->update("tbl_master_lead_source", $data);
    }

    function delete_single_source($source_id)
    {
        return $this->db->delete('tbl_master_lead_source', ['id' => $source_id]);
        //$this->db->where("id", $source_id);
        // $this->db->delete("sources");
        // if ($this->db->affected_rows() > 0) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

  
    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_lead_source');
        return $query->row();
    }

    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_master_lead_source.id");
        $this->db->from("tbl_master_lead_source");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}