<?php
class MasterDesignationModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_designation');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_designation', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_model($user_id)
    {
        $this->db->where("id", $user_id);
        $query = $this->db->get('tbl_master_designation');
        return $query->row();
    }
    function update_model($user_id, $data)
    {
        $this->db->where("id", $user_id);
        return $this->db->update("tbl_master_designation", $data);
    }

    function checkDuplication($name)
    {
     
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_designation');
        return $query->row();
    }

    function delete_single($id)
    {
        return $this->db->delete('tbl_master_designation', ['id' => $id]);
    }
}
