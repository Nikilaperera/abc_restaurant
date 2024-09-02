<?php
class ProgramSemesterModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_semesters');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_semesters', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_semesters');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_semesters", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_semesters', ['id' => $id]);
         
    }

    function getByCategory($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_semesters'); 
        return $query->num_rows() > 0;
    }
}