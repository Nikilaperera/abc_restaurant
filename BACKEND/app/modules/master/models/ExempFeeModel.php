<?php
class ExempFeeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all() 
    {
        $query = $this->db->get('tbl_exemption_fees');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_exemption_fees', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_exemption_fees');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_exemption_fees", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_exemption_fees', ['id' => $id]);
         
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

    function fetchAllProgramTypes()
    {
        $this->db->select('tbl_master_program_type.*');
        $this->db->from('tbl_master_program_type'); 
        $this->db->where("tbl_master_program_type.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetchAllProgramLevels()
    {
        $this->db->select('tbl_master_program_level.*');
        $this->db->from('tbl_master_program_level'); 
        $this->db->where("tbl_master_program_level.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function get_file($id)
    {
        $query=$this->db->get_where('tbl_exemption_fees', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->file;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

}