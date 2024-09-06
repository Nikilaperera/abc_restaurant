<?php

class MenuItemModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_menu_items');
        return $query->result();
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_menu_items');
        return $query->num_rows() > 0;
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_menu_items', $data);
        if ($this->db->insert_id() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getByCodeOrNameByID($id, $code, $name)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_menu_items');
        return $query->num_rows() > 0;
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_menu_items", $data);
    }

    function fetchAllMenuTypes()
    {
        $this->db->select('tbl_master_menu_types.*');
        $this->db->from('tbl_master_menu_types');
        $this->db->where("tbl_master_menu_types.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_menu_items', ['id' => $id]);

    }


}