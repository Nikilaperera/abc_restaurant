<?php
class ProgramMediumModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_program_medium');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_medium', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_medium($medium_id)
    {
        $this->db->where("id", $medium_id);
        $query = $this->db->get('tbl_master_program_medium');
        return $query->row();
    }

    function update_medium($medium_id, $data)
    {
        $this->db->where("id", $medium_id);
        return $this->db->update("tbl_master_program_medium", $data);
    }
    function delete_single_medium($medium_id)
    {
        $this->db->where("id", $medium_id);
        return $this->db->delete("tbl_master_program_medium");
    }
    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_program_medium'); 
        return $query->num_rows() > 0;
    }
}