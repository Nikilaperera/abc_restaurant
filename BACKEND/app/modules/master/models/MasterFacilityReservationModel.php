<?php
class MasterFacilityReservationModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_facility');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_facility', $data);
        if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
        } else {
            return false;
        }
       
       
    }
    
    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_facility');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_facility", $data);
    }
    

    
    
    function delete_data($id)
    {
        var_dump($id);
        die();
        return $this->db->delete('tbl_master_facility', ['id' => $id]);
         
    }
}