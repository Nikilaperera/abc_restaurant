<?php
class KitchenModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_customer_order.*,tbl_master_table.name as table_name, tbl_master_menu_types.name as menu_type_name, tbl_menu_items.name as menu_type_name');
        $this->db->from('tbl_customer_order');
        $this->db->join('tbl_master_table','tbl_master_table.code=tbl_customer_order.table_code');
        $this->db->join('tbl_master_menu_types','tbl_master_menu_types.code=tbl_customer_order.menu_type');
        $this->db->join('tbl_menu_items','tbl_menu_items.code=tbl_customer_order.menu_item');
        $this->db->order_by('tbl_customer_order.order_id');
        $query = $this->db->get();
        return $query->result();
    }

}