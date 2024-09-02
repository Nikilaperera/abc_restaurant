<?php
class RequestTypeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_master_request_type.*,tbl_master_department.name as depname');
        $this->db->from('tbl_master_request_type');
        $this->db->join('tbl_master_department','tbl_master_department.code=tbl_master_request_type.department');
        $query = $this->db->get();
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_request_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_request_type');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_request_type", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_request_type', ['id' => $id]);
    }

    function approve_reject_data($id, $data)
    {
        $this->db->where("id", $id);

        return $this->db->update("tbl_master_request_type", $data);
    }
    function fetchAllDepartments()
    {
        $this->db->select('tbl_master_department.*');
        $this->db->from('tbl_master_department');
        $this->db->where("tbl_master_department.status",'Active');
        $query=$this->db->get();
		return $query->result();
    }
}
