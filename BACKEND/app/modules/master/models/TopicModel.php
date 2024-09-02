<?php
class TopicModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all() 
    {
        $this->db->select('tbl_master_program_module_topic.*,tbl_master_programs.name as program_name');
        $this->db->from('tbl_master_program_module_topic');
        $this->db->join('tbl_master_programs','tbl_master_programs.code=tbl_master_program_module_topic.program_code');
        $this->db->order_by('tbl_master_program_module_topic.code');
        $query = $this->db->get();
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_module_topic', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetchAllPrograms()
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }

    //get program name
    // function getProramUsingid($code){
    //     $this->db->select('tbl_master_programs.name');
    //     $this->db->from('tbl_master_programs');
    //     $this->db->where("tbl_master_programs.code",'code');  
    //     $query=$this->db->get(); 
	// 	return $query->result(); 
    // }

    function fetchAllModules($program)
    {
        $this->db->select('tbl_master_program_module.*');
        $this->db->from('tbl_master_program_module');
        $this->db->where("tbl_master_program_module.program",$program);
        $this->db->where("tbl_master_program_module.status",'Active');
        $query=$this->db->get();
		return $query->result();
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_program_module_topic');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_program_module_topic", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_program_module_topic', ['id' => $id]);
         
    }
}