<?php

class CustomerFormModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetchAllTables()
    {
        $this->db->select('tbl_master_table.*');
        $this->db->from('tbl_master_table');
        $this->db->where("tbl_master_table.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }

    function fetchAllMenuTypes()
    {
        $this->db->select('tbl_master_menu_types.*');
        $this->db->from('tbl_master_menu_types');
        $this->db->where("tbl_master_menu_types.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }

    function fetchAllMenuItems($menu_type)
    {
        $this->db->select('tbl_menu_items.*, tbl_master_menu_types.name as menu_type_name');
        $this->db->from('tbl_menu_items');
        $this->db->join('tbl_master_menu_types','tbl_master_menu_types.code=tbl_menu_items.menu_type');
        $this->db->where("tbl_menu_items.menu_type",$menu_type);
        $this->db->where("tbl_menu_items.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }

    public function get_latest_order_id() {

        $this->db->select('order_id');
        $this->db->like('order_id', 'ORDID', 'after');
        $this->db->order_by('order_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_customer_order');

        if ($query->num_rows() > 0) {
            return $query->row()->order_id;
        } else {
            return null;
        }
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_customer_order', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
