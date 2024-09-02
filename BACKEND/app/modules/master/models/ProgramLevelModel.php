<?php
class ProgramLevelModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_program_level');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_level', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_programLevel($programLevel_id)
    {
        $this->db->where("id", $programLevel_id);
        $query = $this->db->get('tbl_master_program_level');
        return $query->row();
    }
    function update_programLevel($programLevel_id, $data)
    {
        $this->db->where("id", $programLevel_id);
        return $this->db->update("tbl_master_program_level", $data);
    }

    function delete_single_programLevel($programLevel_id)
    {
        return $this->db->delete('tbl_master_program_level', ['id' => $programLevel_id]);
    }
    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_program_level'); 
        return $query->num_rows() > 0;
    }
}