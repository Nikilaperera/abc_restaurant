<?php
class MasterBatchesModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_master_batch.*, tbl_master_programs.name as program_name');
        $this->db->from('tbl_master_batch');
        $this->db->join('tbl_master_programs','tbl_master_programs.code = tbl_master_batch.program','left');
        $query=$this->db->get();
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
    function fetchAllPrograms()
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchallIntakes()
    {
        $this->db->select('tbl_master_intake.*');
        $this->db->from('tbl_master_intake');  
        //$this->db->where("tbl_master_intake.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchallconvo_types()
    {
        $this->db->select('tbl_master_convocation_type.*');
        $this->db->from('tbl_master_convocation_type');  
        $this->db->where("tbl_master_convocation_type.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    
    function fetch_latest_batch_code($program)
    {
        $this->db->select('tbl_master_batch.*');
        $this->db->from('tbl_master_batch');        
        $this->db->where('tbl_master_batch.program',$program);
        $this->db->order_by("tbl_master_batch.id",'DESC');
        $query=$this->db->get(); 
        return $query->row();
    }
    
    function get_programs($data){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.program_type", $data);
        $query = $this->db->get();
        return $query->result();
    }

    function get_intakes($data){
        $this->db->select('*');
        $this->db->from('tbl_master_intake');
        $this->db->where("tbl_master_intake.program", $data);
        $query = $this->db->get();
        return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_batch', $data);
        if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->select('tbl_master_batch.*,tbl_master_programs.name as programName');
        $this->db->from('tbl_master_batch');
        $this->db->join('tbl_master_programs','tbl_master_programs.code = tbl_master_batch.program');
        $this->db->where("tbl_master_batch.id", $id);
        $query=$this->db->get();
        return $query->row();
    }

    function fetch_duration_data($code)
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.code", $code);
        $query=$this->db->get();
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_batch", $data);
    }

    function delete_data($code)
    {
        return $this->db->delete('tbl_master_batch', ['id' => $code]);
    }

    function approveRejectBatch($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_batch", $data);
    }

}
