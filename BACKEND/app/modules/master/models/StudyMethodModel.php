<?php
class StudyMethodModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_method_of_study');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_method_of_study', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkDuplication($name)
    {
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_method_of_study');
        return $query->row();
    }

    function checkUpdateDuplication($id, $name)
    {
        $this->db->select("tbl_master_method_of_study.id");
        $this->db->from("tbl_master_method_of_study");
        $this->db->where("(name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_method_of_study", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_method_of_study', ['id' => $id]);
    }

}