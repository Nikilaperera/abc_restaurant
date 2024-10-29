<?php

class ChefMasterModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all records from tbl_master_chef
    function fetch_all()
    {
        $query = $this->db->get('tbl_master_chef');
        return $query->result();
    }

    // Check if a chef exists by name or email
    function getByNameOrEmail($name, $email)
    {
        $this->db->where('Name', $name);
        $this->db->or_where('Email', $email);
        $query = $this->db->get('tbl_master_chef');
        return $query->num_rows() > 0;
    }

    // Insert a new chef record
    function insert_api($data)
    {
        $this->db->insert('tbl_master_chef', $data);
        return ($this->db->insert_id() > 0); // Simplified return
    }

    // Check for duplicates by ID, excluding the current chef's ID
    function getNameOrEmailByID($id, $name, $email)
    {
        $this->db->where('ID !=', $id);
        $this->db->group_start();
        $this->db->where('Name', $name);
        $this->db->or_where('Email', $email);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_chef');
        return $query->num_rows() > 0;
    }

    // Update chef record by ID
    function update_data($id, $data)
    {
        $this->db->where("ID", $id);
        return $this->db->update("tbl_master_chef", $data);
    }

    // Fetch all active chefs from tbl_master_chef
    function fetchAllChefs()
    {
        $this->db->select('tbl_master_chef.*');
        $this->db->from('tbl_master_chef');
        $this->db->where("tbl_master_chef.Status", 'Active');
        $query = $this->db->get();
        return $query->result();
    }

    // Delete a chef record by ID
    function delete_single_data($id)
    {
        // First, check if record exists
        $this->db->where('ID', $id);
        $query = $this->db->get('tbl_master_chef');

        if ($query->num_rows() > 0) {
            // Proceed to delete the record
            $this->db->where('ID', $id);
            return $this->db->delete('tbl_master_chef'); // Return true if delete was successful
        } else {
            return false; // Return false if no record found
        }
    }


}
