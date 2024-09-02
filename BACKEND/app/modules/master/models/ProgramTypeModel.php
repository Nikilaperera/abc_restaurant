<?php
class ProgramTypeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_program_type');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

  

    function fetch_single_programType($programType_id)
    {
        $this->db->where("id", $programType_id);
        $query = $this->db->get('tbl_master_program_type');
        return $query->row();
    }
    function update_programType($programType_id, $data)
    {
        $this->db->where("id", $programType_id);
        return $this->db->update("tbl_master_program_type", $data);
    }

    function delete_single_programType($programType_id)
    {
        return $this->db->delete('tbl_master_program_type', ['id' => $programType_id]);
        $this->db->where("id", $program_id);
        $this->db->delete("programs");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_program_type'); 
        return $query->num_rows() > 0;
    }

    
    function getByCodeOrNameByID($id,$code,$name)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_program_type'); 
        return $query->num_rows() > 0;
    }

   
}