<?php
class MasterMemberShipCategoryModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_membership_category');
		return $query->result(); 
        
    }

    function getbothtablevalue(){

        $this->db->select('*');
        $this->db->from('tbl_master_membership_category');
        $query1 = $this->db->get();
        $result1 = $query1->result();
    
        $this->db->select('*');
        $this->db->from('tbl_master_membership_elegibility_criteria'); // Replace 'another_table_name' with the name of your second table
        $query2 = $this->db->get();
        $result2 = $query2->result();
    
        // Combine the results from both tables into a single array
        $combinedResult = array(
            'table1_data' => $result1,
            'table2_data' => $result2,
        );
    
        return $combinedResult;

    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_membership_category', $data);
        if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
        } else {
            return false;
        }
       
       
    }
    function insert_api2($data)
    {
        $this->db->insert('tbl_master_membership_elegibility_criteria', $data);
        if ($this->db->affected_rows() > 0) {
        return true;
        } else {
            return false;
        }
       
       
    }
       

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_membership_category');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_membership_category", $data);
        
    }
    function update_data2($code, $data)
    {
        $this->db->where("membership_category_code", $code);
        return $this->db->update("tbl_master_membership_elegibility_criteria", $data);
    }

    
    
    function delete_data($code)
    {
         $this->db->delete('tbl_master_membership_elegibility_criteria', ['membership_category_code' => $code]);
         $this->db->delete('tbl_master_membership_category', ['code' => $code]);
    }

    function fetch_all_details($code)
    {
        $this->db->select('*' );
        $this->db->from('tbl_master_membership_elegibility_criteria');
        $this->db->where('membership_category_code', $code);
        $query = $this->db->get();
        return $query->result();
    }

    
    function approve_reject_data($id, $data)
    {
        $this->db->where("id", $id);

        return $this->db->update("tbl_master_membership_category", $data);
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_membership_category'); 
        return $query->num_rows() > 0;
    }

    function getByCodeOrNameById($code, $id)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_membership_category'); 
        return $query->num_rows() > 0;
    }

    function get_criteria($code)
    {
        $this->db->where('membership_category_code', $code);
        $query = $this->db->get('tbl_master_membership_elegibility_criteria');
        return $query->result();
    }

    function getCriteriaByCode($code, $criteria)
    {
        $this->db->where('membership_category_code', $code);
        $this->db->where('criteria', $criteria);
        $query = $this->db->get('tbl_master_membership_elegibility_criteria'); 
        return $query->num_rows() > 0;
    }

}