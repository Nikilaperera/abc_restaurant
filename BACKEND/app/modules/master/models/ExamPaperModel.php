<?php
class ExamPaperModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
   
    function fetch_program_type(){
        $this->db->select('*');
        $this->db->from('tbl_master_program_type');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_program($data){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where('program_type',$data);
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_questionFormat(){
        $this->db->select('*');
        $this->db->from('tbl_master_exam_question_formats');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_exam_type(){
        $this->db->select('*');
        $this->db->from('tbl_master_exam_type');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_topics($data){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module_topic');
        $this->db->where('module_code',$data);
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_modules(){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');
        $query = $this->db->get();
        return $query->result();
    }
    function getMedium()
    {
        $query = $this->db->get('tbl_master_program_medium');
        return $query->result();
    }
    function getResourcePerson()
    {
        $query = $this->db->get('tbl_resource_person');
        return $query->result();
    }
    /////////////////////////////////////
    function insert_api($data)
    {
        $this->db->insert('tbl_exam_paper', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
   
    function fetch_all()
    {
        $query = $this->db->get('tbl_exam_paper');
		return $query->result();
    }
 
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_exam_paper", $data);
    }
    function approval_reject_data($id, $data)
    {
        $this->db->where("id", $id);

        return $this->db->update("tbl_exam_paper", $data);
    }
    
    function add_questions($data)
    {
        $this->db->insert('tbl_exam_paper_questions', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function update_questions($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_exam_paper_questions", $data);
    }
    function update_paper_details($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_exam_paper_questions", $data);
    }
    function fetch_exam_paper_questions()
    {
        $this->db->select('tbl_exam_paper_questions.*,tbl_resource_person.full_name as lecturer_name,tbl_exam_paper.paper_name');
        $this->db->from('tbl_exam_paper_questions');
        $this->db->join('tbl_resource_person', 'tbl_exam_paper_questions.lecturer = tbl_resource_person.resource_person_id');
        $this->db->join('tbl_exam_paper', 'tbl_exam_paper_questions.paper_id = tbl_exam_paper.id');
        $query = $this->db->get();
		return $query->result();
   
    }
    function get_paper_by_id($paper_id){
        $this->db->select('*');
        $this->db->from('tbl_exam_paper');
        $this->db->where('id',$paper_id);
        $query = $this->db->get();
		return $query->result();
    }
   

    /////////////////////////////////////


    function get_mcq_content(){
        $this->db->select('tbl_exam_paper_questions.*,tbl_resource_person.full_name as lecturer_name,tbl_exam_paper.paper_name,tbl_master_program_module.name as modulename,tbl_master_program_module_topic.name as topicname');
        $this->db->from('tbl_exam_paper_questions');
        $this->db->join('tbl_resource_person', 'tbl_exam_paper_questions.lecturer = tbl_resource_person.resource_person_id');
        $this->db->join('tbl_master_program_module', 'tbl_exam_paper_questions.module = tbl_master_program_module.code');
        $this->db->join('tbl_master_program_module_topic', 'tbl_exam_paper_questions.topic = tbl_master_program_module_topic.code');
        $this->db->join('tbl_exam_paper', 'tbl_exam_paper_questions.paper_id = tbl_exam_paper.id');
        $this->db->where('question_format','MCQ');
        $this->db->where('question_content IS NOT NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
      }

    function get_essay_content(){
        $this->db->select('tbl_exam_paper_questions.*,tbl_resource_person.full_name as lecturer_name,tbl_exam_paper.paper_name,tbl_master_program_module.name as modulename,tbl_master_program_module_topic.name as topicname');
        $this->db->from('tbl_exam_paper_questions');
        $this->db->join('tbl_resource_person', 'tbl_exam_paper_questions.lecturer = tbl_resource_person.resource_person_id');
        $this->db->join('tbl_master_program_module', 'tbl_exam_paper_questions.module = tbl_master_program_module.code');
        $this->db->join('tbl_master_program_module_topic', 'tbl_exam_paper_questions.topic = tbl_master_program_module_topic.code');
        $this->db->join('tbl_exam_paper', 'tbl_exam_paper_questions.paper_id = tbl_exam_paper.id');
        $this->db->where('question_format','Essay');
        $this->db->where('question_content IS NOT NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    } 
    function get_structured_content(){
        $this->db->select('tbl_exam_paper_questions.*,tbl_resource_person.full_name as lecturer_name,tbl_exam_paper.paper_name,tbl_master_program_module.name as modulename,tbl_master_program_module_topic.name as topicname');
        $this->db->from('tbl_exam_paper_questions');
        $this->db->join('tbl_resource_person', 'tbl_exam_paper_questions.lecturer = tbl_resource_person.resource_person_id');
        $this->db->join('tbl_master_program_module', 'tbl_exam_paper_questions.module = tbl_master_program_module.code');
        $this->db->join('tbl_master_program_module_topic', 'tbl_exam_paper_questions.topic = tbl_master_program_module_topic.code');
        $this->db->join('tbl_exam_paper', 'tbl_exam_paper_questions.paper_id = tbl_exam_paper.id');
        $this->db->where('question_format','Structured Essay');
        $this->db->where('question_content IS NOT NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    } 
    function get_short_content(){
        $this->db->select('tbl_exam_paper_questions.*,tbl_resource_person.full_name as lecturer_name,tbl_exam_paper.paper_name,tbl_master_program_module.name as modulename,tbl_master_program_module_topic.name as topicname');
        $this->db->from('tbl_exam_paper_questions');
        $this->db->join('tbl_resource_person', 'tbl_exam_paper_questions.lecturer = tbl_resource_person.resource_person_id');
        $this->db->join('tbl_master_program_module', 'tbl_exam_paper_questions.module = tbl_master_program_module.code');
        $this->db->join('tbl_master_program_module_topic', 'tbl_exam_paper_questions.topic = tbl_master_program_module_topic.code');
        $this->db->join('tbl_exam_paper', 'tbl_exam_paper_questions.paper_id = tbl_exam_paper.id');
        $this->db->where('question_format','Short Answer Questions');
        $this->db->where('question_content IS NOT NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    } 
    function merge_paper($data)
    {
        $this->db->insert('tbl_exam_paper_questions_merge', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function get_merged_papers($id){
        $this->db->where('paper_id',$id);

        $query = $this->db->get('tbl_exam_paper_questions_merge');
		return $query->result();
    }

    function merge_paper_update($id,$data){
        $this->db->where("id", $id);
        return $this->db->update("tbl_exam_paper_questions_merge", $data);
    }
    function merge_paper_update_by_editor($id,$data){
        $this->db->where("id", $id);
        return $this->db->update("tbl_exam_paper_questions_merge", $data);
    }
}