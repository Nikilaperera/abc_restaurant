<?php
class FacultyModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function fetch_all()
    {
        $query = $this->db->get('tbl_master_faculty');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_faculty', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function fetch_single_faculty($faculty_id)
    {
        $this->db->where("id", $faculty_id);
        $query = $this->db->get('tbl_master_faculty');
        return $query->row();
    }

    function delete_single_faculty($id)
    {
        return $this->db->delete('tbl_master_faculty', ['id' => $id]);
         
    }


    function update_faculty($faculty_id, $data)
    {
        $this->db->where("id", $faculty_id);
        return $this->db->update("tbl_master_faculty", $data);
    }
    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_faculty'); 
        return $query->num_rows() > 0;
    }
}