<?php
class MenuTypeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_menu_types');
        return $query->result();
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_menu_types', ['id' => $id]);
    }
}