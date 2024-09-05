<?php
class ReservationTypeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_reservation_type');
        return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_reservation_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}