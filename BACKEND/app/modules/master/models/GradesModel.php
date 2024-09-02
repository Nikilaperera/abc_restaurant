<?php
class GradesModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function fetch_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_grade');
        $this->db->join('tbl_master_grade_details', 'tbl_master_grade_details.main_id = tbl_master_grade.id', 'inner');
        $query = $this->db->get();
        return $query->result();

    }
    function delete_grades($id)
    {
        return $this->db->delete('tbl_master_grade_details', ['id' => $id]);

    }

    function getAllPrograms(){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $query = $this->db->get();
        return $query->result();
    }
    function check_main_data($scheme)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_grade');
        $this->db->where('tbl_master_grade.scheme', $scheme);
        $query = $this->db->get();
        return $query->row();
    }

    function get_main_data_id($scheme)
    {
        $this->db->select('tbl_master_grade.id');
        $this->db->from('tbl_master_grade');
        $this->db->where('tbl_master_grade.scheme', $scheme);
        $query = $this->db->get();
        return $query->row();
    }

    function add_main_data($main_data)
    {
        $this->db->insert('tbl_master_grade', $main_data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function add_sub_data($sub_data)
    {
        $this->db->insert('tbl_master_grade_details', $sub_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function update_main_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_grade", $data);
    }

    function update_sub_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_grade_details", $data);
    }

}