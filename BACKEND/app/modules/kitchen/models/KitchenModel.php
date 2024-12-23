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
        // $this->db->select('tbl_customer_order.*,tbl_master_table.name as table_name, tbl_master_menu_types.name as menu_type_name, tbl_menu_items.name as menu_type_name');
        // $this->db->from('tbl_customer_order');
        // $this->db->join('tbl_master_table', 'tbl_master_table.code=tbl_customer_order.table_code');
        // $this->db->join('tbl_master_menu_types', 'tbl_master_menu_types.code=tbl_customer_order.menu_type');
        // $this->db->join('tbl_menu_items', 'tbl_menu_items.code=tbl_customer_order.menu_item');
        // $this->db->order_by('tbl_customer_order.order_id');
        // $query = $this->db->get();
        // return $query->result();

        $this->db->select('tbl_customer_order.*, 
                   tbl_master_table.name AS table_name, 
                   tbl_master_menu_types.name AS menu_type_name, 
                   tbl_menu_items.name AS menu_item_name, 
                   IFNULL(tbl_master_chef.Name, "Unknown") AS chef_name');  // Replaces NULL with "Unknown"
        $this->db->from('tbl_customer_order');
        $this->db->join('tbl_master_table', 'tbl_master_table.code = tbl_customer_order.table_code');
        $this->db->join('tbl_master_menu_types', 'tbl_master_menu_types.code = tbl_customer_order.menu_type');
        $this->db->join('tbl_menu_items', 'tbl_menu_items.code = tbl_customer_order.menu_item');
        $this->db->join('tbl_master_chef', 'tbl_master_chef.ID = tbl_customer_order.chef_id', 'left');  // LEFT JOIN for nullable chef
        $this->db->order_by('tbl_customer_order.order_id');
        $query = $this->db->get();
        return $query->result();

    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_customer_order', ['id' => $id]);

    }

    function check_order_status($id)
    {
        $this->db->select('order_status');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_customer_order');
        return $query->row() ? $query->row()->order_status : null;
    }

    function fetchAllMenuItems($menu_type)
    {
        $this->db->select('tbl_menu_items.*, tbl_master_menu_types.name as menu_type_name');
        $this->db->from('tbl_menu_items');
        $this->db->join('tbl_master_menu_types', 'tbl_master_menu_types.code=tbl_menu_items.menu_type');
        $this->db->where("tbl_menu_items.menu_type", $menu_type);
        $this->db->where("tbl_menu_items.status", 'Active');
        $query = $this->db->get();
        return $query->result();
    }

    function fetchAllMenuTypes()
    {
        $this->db->select('tbl_master_menu_types.*');
        $this->db->from('tbl_master_menu_types');
        $this->db->where("tbl_master_menu_types.status", 'Active');
        $query = $this->db->get();
        return $query->result();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_customer_order", $data);
    }

    public function fetchActiveChefs()
    {
        // $this->db->select('ID,Name');
        // $this->db->from('tbl_master_chef');
        // $this->db->where('Status', 'Active');
        // $query = $this->db->get();
        // return $query->result();
        $this->db->select('tbl_master_chef.ID, tbl_master_chef.Name');
        $this->db->from('tbl_master_chef');
        $this->db->join('tbl_customer_order', 'tbl_customer_order.chef_id = tbl_master_chef.ID AND tbl_customer_order.order_status = "Pending"', 'left');
        $this->db->where('tbl_master_chef.Status', 'Active');
        $this->db->where('tbl_customer_order.order_status IS NULL', null, false);  // Ensures chefs without 'Pending' orders
        $query = $this->db->get();
        return $query->result();
    }

}