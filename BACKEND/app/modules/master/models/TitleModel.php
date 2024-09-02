<?php
class TitleModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_title');
		return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('tbl_master_title');
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_title', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_title($title_id)
    {
        $this->db->where("id", $title_id);
        $query = $this->db->get('tbl_master_title');
        return $query->row();
    }
    function update_title($title_id, $data)
    {
        $this->db->where("id", $title_id);
        return $this->db->update("tbl_master_title", $data);
    }

    function delete_single($title_id)
    {
        return $this->db->delete('tbl_master_title', ['id' => $title_id]);
    }
}