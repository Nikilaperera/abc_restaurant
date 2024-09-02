<?php
class SchoolModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function fetch_all()
    {
        $query = $this->db->get('tbl_lead_school_list');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_lead_school_list', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_school($school_id)
    {
        $this->db->where("id", $school_id);
        $query = $this->db->get('tbl_lead_school_list');
        return $query->row();
    }
    function update_school($school_id, $data)
    {
        $this->db->where("id", $school_id);
        return $this->db->update("tbl_lead_school_list", $data);
    }

    function delete_single_school($school_id)
    {
        return $this->db->delete('tbl_lead_school_list', ['id' => $school_id]);
    }
}