<?php
class MemberEmployeeCategoryModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_member_emp_category');
        $query = $this->db->get();
		return $query->result();
    }

    function add($data)
    {
        $this->db->insert('tbl_master_member_emp_category', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_member_emp_category", $data);
    }

    function delete($id)
    {
        return $this->db->delete('tbl_master_member_emp_category', ['id' => $id]);
    }

}