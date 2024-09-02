<?php
class AwardsModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_awards');
		return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_awards', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($program_id)
    {
        $this->db->where("id", $program_id);
        $query = $this->db->get('tbl_master_awards');
        return $query->row();
    }
    function update_data($program_id, $data)
    {
        $this->db->where("id", $program_id);
        return $this->db->update("tbl_master_awards", $data);
    }

    function delete_single_data($program_id)
    {
        return $this->db->delete('tbl_master_awards', ['id' => $program_id]);
        //$this->db->where("id", $program_id);
        // $this->db->delete("programs");
        // if ($this->db->affected_rows() > 0) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_awards');
        return $query->row();
    }
}