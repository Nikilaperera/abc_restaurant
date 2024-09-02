<?php
class FeedbackForm1Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_master_feedback_form_qr.*, tbl_master_programs.name AS program_name, tbl_master_program_mode.name AS mode_name, tbl_master_program_module.name AS module_name,');
        $this->db->from('tbl_master_feedback_form_qr');
        $this->db->join('tbl_master_programs','tbl_master_feedback_form_qr.program = tbl_master_programs.code');
        $this->db->join('tbl_master_program_mode', 'tbl_master_feedback_form_qr.program_mode = tbl_master_program_mode.code ');
        $this->db->join('tbl_master_program_module','tbl_master_feedback_form_qr.module = tbl_master_program_module.code');
      //  $this->db->join('tbl_master_batch','tbl_master_feedback_form_qr.batch = tbl_master_program_batch.code');
       // $this->db->join('tbl_resource_person','tbl_master_feedback_form_qr.resource_person_id = tbl_resource_person.resource_person_id');
       $this->db->order_by('tbl_master_feedback_form_qr.id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_feedback_form_qr', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_feedback_form_qr');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_feedback_form_qr", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_feedback_form_qr', ['id' => $id]);
         
    }
    function fetchallquestions()
    {
        $this->db->select('tbl_master_feedback_questions.*');
        $this->db->from('tbl_master_feedback_questions'); 
        $this->db->where("tbl_master_feedback_questions.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchallMedium()
    {
        $this->db->select('tbl_master_program_medium.*');
        $this->db->from('tbl_master_program_medium');
        $this->db->where("tbl_master_program_medium.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchallModule()
    {
        $this->db->select('tbl_master_program_module.*');
        $this->db->from('tbl_master_program_module');
        $this->db->where("tbl_master_program_module.status",'Active');  
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
        $this->db->select('tbl_master_program_module.*');
        $this->db->from('tbl_master_program_module'); 
        $this->db->where("tbl_master_program_module.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchget_model()
    {
        $this->db->select('tbl_master_program_mode.*');
        $this->db->from('tbl_master_program_mode'); 
        $this->db->where("tbl_master_program_mode.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchget_batch()
    {
        $this->db->select('tbl_master_batch.*');
        $this->db->from('tbl_master_batch'); 
        $this->db->where("tbl_master_batch.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchgetPerson()
    {
        $this->db->select('tbl_resource_person.*');
        $this->db->from('tbl_resource_person'); 
        $this->db->where("tbl_resource_person.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function update_api($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_feedback_form_qr", $data);
    }
    function fetchgetProgramTypes($programType)
    {
        $this->db->select('tbl_master_program_type.*');
        $this->db->from('tbl_master_program_type'); 
        $this->db->where("tbl_master_program_type.code",$programType);
        $query=$this->db->get(); 
		return $query->row(); 


    }
    function fetchgetProgram($program)
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs'); 
        $this->db->where("tbl_master_programs.code",$program);
        $query=$this->db->get(); 
		return $query->row(); 


    }


}
