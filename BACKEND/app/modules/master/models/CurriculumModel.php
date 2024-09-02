<?php
class CurriculumModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_curriculum');
        $query = $this->db->get();
        return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }

    //get module details using curriculem code

    function getmoddetailsusingCC($code){

        $this->db->select('tbl_master_curriculum_details.id,tbl_master_curriculum_details.module,tbl_master_curriculum_details.module_name,tbl_master_curriculum_details.credits,tbl_master_curriculum_details.module_type,tbl_master_curriculum_details.number_of_hours,tbl_master_curriculum_details.lecturer,tbl_master_curriculum_details.topic_name');
        $this->db->from('tbl_master_curriculum_details');
        $this->db->where('tbl_master_curriculum_details.curriculum', $code);
        $query = $this->db->get();
        return $query->result();

    }

    //get program name
    function getPname($code){

        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_programs.code', $code);
        $query = $this->db->get();
        return $query->row();

    }
    function fetch_all_by_id($id)
    {
        $this->db->select('tbl_master_curriculum.*,tbl_master_curriculum_details.id as detailsId,duration_number,module,module_type,number_of_hours,topic,credits,lecturer');
        $this->db->from('tbl_master_curriculum');
        $this->db->where('tbl_master_curriculum.id', $id);
        $this->db->join('tbl_master_curriculum_details', 'tbl_master_curriculum.code = tbl_master_curriculum_details.curriculum');
        $query = $this->db->get();
        return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }

    //get by id tbl_master_curriculum
    function getbyid($id){

        $this->db->select('tbl_master_curriculum.*,tbl_master_curriculum_details.*,tbl_master_curriculum.id as main_id,tbl_master_curriculum.status,tbl_master_curriculum.program_type,tbl_master_curriculum.program,tbl_master_curriculum.duration');
        $this->db->from('tbl_master_curriculum');
        $this->db->where('tbl_master_curriculum.id', $id);
        $this->db->join('tbl_master_curriculum_details', 'tbl_master_curriculum.code = tbl_master_curriculum_details.curriculum','left');
        $query = $this->db->get();
        return $query->result();

    }

    function fetch_curriculum_details_code($code)
    {
        $this->db->select('tbl_master_curriculum_details.*,tbl_master_program_duration.name AS sem_name, tbl_master_program_module.name AS mod_name, tbl_master_program_module_topic.name As top_name, tbl_master_curriculum.intake, tbl_master_curriculum.batch, tbl_master_curriculum.status, tbl_master_curriculum.curriculum_status');
        $this->db->from('tbl_master_curriculum_details');
        $this->db->where('tbl_master_curriculum_details.curriculum', $code);
        $this->db->join('tbl_master_program_duration', 'tbl_master_program_duration.code = tbl_master_curriculum_details.duration');
        $this->db->join('tbl_master_program_module', 'tbl_master_program_module.code = tbl_master_curriculum_details.module');
        $this->db->join('tbl_master_program_module_topic', 'tbl_master_program_module_topic.code = tbl_master_curriculum_details.topic');
        $this->db->join('tbl_master_curriculum', 'tbl_master_curriculum.code = tbl_master_curriculum_details.curriculum');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_curri_code($id)
    {
        $query = $this->db->get_where('tbl_master_curriculum', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function fetch_prog_code($id)
    {
        $query = $this->db->get_where('tbl_master_curriculum', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->program;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function fetch_program_assessment_by_id($id)
    {
        $this->db->select('tbl_master_curriculum_program_assessment_details.id as assessmentId,assessment_type,mark_presentage');
        $this->db->from('tbl_master_curriculum_program_assessment_details');
        $this->db->where('tbl_master_curriculum_program_assessment_details.curriculum', $id);
        $query = $this->db->get();
        return $query->result();

    }

    //get curriculum code
    function getcurriculumCodeload(){
        $this->db->select('tbl_master_curriculum.code');
        $this->db->from('tbl_master_curriculum');
        $query = $this->db->get();
        return $query->result();
    }

    //get all by curriculum code
    function getallcurriculum($code){
        $this->db->select('tbl_master_curriculum.*,tbl_master_curriculum_details.program_name');
        $this->db->from('tbl_master_curriculum');
        $this->db->join('tbl_master_curriculum_details', 'tbl_master_curriculum_details.curriculum = tbl_master_curriculum.code');
        $this->db->where('tbl_master_curriculum.code',$code);
        $query = $this->db->get();
        return $query->result();

    }

    //get modulename
    function getMduleName($code){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');
        $this->db->where('tbl_master_program_module.code',$code);
        $query = $this->db->get();
        return $query->row();
    }

    function getMduleTopic($code){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module_topic');
        $this->db->where('tbl_master_program_module_topic.code',$code);
        $query = $this->db->get();
        return $query->row();
    }

    function fetch_assessment_by_id($id)
    {
        $this->db->select('tbl_curriculum_assessment_type.*');
        $this->db->from('tbl_curriculum_assessment_type');
        $this->db->where('tbl_curriculum_assessment_type.curriculum_code', $id);
        $query = $this->db->get();
        return $query->result();

    }

    function get_programs($data)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where("program_type", $data);
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result();

    }

    function get_intakes($proType, $pro)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_intake');
        $this->db->where("program_type", $proType);
        $this->db->where("program", $pro);
        $query = $this->db->get();
        return $query->result();

    }

    function get_batches($proType, $pro, $int)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_batch');
        $this->db->where("program_type", $proType);
        $this->db->where("program", $pro);
        $this->db->where("intake", $int);
        $query = $this->db->get();
        return $query->result();

    }

    function get_program_module_topic($program_type,$program)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');
        $this->db->where("program_type", $program_type);
        $this->db->where("program", $program);

        $query = $this->db->get();
        return $query->result();
    }

    function get_credits($module)
    {
        $this->db->select('tbl_master_program_module.credits');
        $this->db->from('tbl_master_program_module');
        $this->db->where('tbl_master_program_module.code', $module);
        $query = $this->db->get();
        return $query->row();
    }

    function get_program_topic($module)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_program_module_topic');
        $this->db->where("module_code", $module);
        $query = $this->db->get();
        return $query->result();

    }

    function fetch_durations()
    {
        $query = $this->db->get('tbl_master_program_duration');
        return $query->result();
    }

    function assessment_type()
    {
        $query = $this->db->get('tbl_master_assessment_type');
        return $query->result();
    }

    function topics()
    {
        $query = $this->db->get('tbl_master_program_module_topic');
        return $query->result();
    }

    // function fetch_program($id)
    // {
    //     $query=$this->db->get_where('tbl_master_curriculum', array('id' => $id)); 
    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();
    //         return $row->program;
    //     } else {
    //         return null;
    //     } 
    // }
    function fetch_rperson()
    {
        $this->db->select('*');
        $this->db->from('tbl_resource_person');
        $this->db->where("type", 'Lecturer');
        $this->db->or_where("type", 'Lecturer & Examiner');
        $query = $this->db->get();
        return $query->result();
    }

    function topic(){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module_topic');
      
        $query = $this->db->get();
        return $query->result();
    }
    
    function assessment_type_by_program($id)
    {
        $this->db->select('assessment_code');
        $this->db->from('tbl_master_assessment_type');
        $this->db->where("program_code", $id);
        $query = $this->db->get();
        return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_curriculum', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_api_details($data)
    {
        $this->db->insert('tbl_master_curriculum_details', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_assessment_details($data)
    {
        $this->db->insert('tbl_curriculum_assessment_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function update_data($program_id, $data)
    {
        $this->db->where("id", $program_id);
        return $this->db->update("tbl_master_curriculum", $data);
    }

    function getnewdata($var){
        $this->db->select('*');
        $this->db->from('tbl_master_curriculum_details');
        $this->db->where("curriculum", $var);
        $query = $this->db->get();
        return $query->result();

    }


    function update_details_data($program_id, $data)
    {
        $this->db->where("id", $program_id);
        return $this->db->update("tbl_master_curriculum_details", $data);
    }


    function update_assessment_details_data($program_id, $data)
    {
        $this->db->where("id", $program_id);
        return $this->db->update("tbl_master_curriculum_program_assessment_details", $data);
    }


    function lock_unlock_data($program_id, $data)
    {
        $this->db->where("id", $program_id);

        return $this->db->update("tbl_master_curriculum", $data);
    }


    function approval_reject_data($program_id, $data)
    {
        $this->db->where("id", $program_id);

        return $this->db->update("tbl_master_curriculum", $data);
    }


    function delete_previous_topics($id)
    {
        return $this->db->delete('tbl_master_curriculum_details', ['id' => $id]);

    }

    function delete_assessment($id)
    {
        return $this->db->delete('tbl_curriculum_assessment_type', ['id' => $id]);
    }

    //delete_CurriculumDetails
    function delete_CurriculumDetails($id)
    {
        return $this->db->delete('tbl_master_curriculum_details', ['id' => $id]);
    }

    function update_assessment($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_curriculum_assessment_type", $data);
    }

    function getEditAssessmentData($curriculum_code, $program_code)
    {
        $this->db->select('tbl_curriculum_assessment_type.*,tbl_curriculum_assessment_type.id as assesm_id');
        $this->db->from('tbl_curriculum_assessment_type');
        $this->db->where("tbl_curriculum_assessment_type.curriculum_code", $curriculum_code);
        $this->db->where("tbl_curriculum_assessment_type.program_code", $program_code);
        $query = $this->db->get();
        return $query->result();
    }

    function getCurriculumCode($program)
    {
        $this->db->select('tbl_master_curriculum.code');
        $this->db->from('tbl_master_curriculum');
        $this->db->where("tbl_master_curriculum.program", $program);
        $this->db->order_by('code', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    //app & rej
    function approve_reject_data($id, $data){

        $this->db->where("id", $id);

        return $this->db->update("tbl_master_curriculum", $data);

    }

}