<?php
class UserGroupsModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('groups');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('groups', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_api($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("groups", $data);
    }

    function fetch_single_model($user_id)
    {
        $this->db->where("id", $user_id);
        $query = $this->db->get('groups');
        return $query->row();
    }

}