<?php
class IntakeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_intake');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_intake', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_intake');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_intake", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_intake', ['id' => $id]);
         
    }
    function fetchAllProgramTypes()
    {
        $this->db->select('tbl_master_program_type.*');
        $this->db->from('tbl_master_program_type'); 
        $this->db->where("tbl_master_program_type.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchAllPrograms()
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function get_programs($data){
        
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where("program_type", $data);
        $query = $this->db->get();
        return $query->result();

    }
    
}
