<?php
class ProgramModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all_programs()
    {
        $query = $this->db->get('tbl_master_programs');
        return $query->result();
    }

    function fetch_AllAcademicPrograms()
    {
        $this->db->select('tbl_master_programs.*, tbl_master_faculty.name AS fac_name, tbl_master_program_level.name AS prog_lvl, tbl_master_program_mode.name AS prog_mod');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_program_type.name', 'Academic Program');
        $this->db->join('tbl_master_program_type', 'tbl_master_program_type.code = tbl_master_programs.program_type');
        $this->db->join('tbl_master_faculty', 'tbl_master_faculty.code = tbl_master_programs.faculty');
        $this->db->join('tbl_master_program_level', 'tbl_master_program_level.code = tbl_master_programs.program_level');
        $this->db->join('tbl_master_program_mode', 'tbl_master_program_mode.code = tbl_master_programs.mode');
        $this->db->order_by('created_at','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_AllProfessionalPrograms()
    {
        $this->db->select('tbl_master_programs.*, tbl_master_faculty.name AS fac_name, tbl_master_program_level.name AS prog_lvl, tbl_master_program_mode.name AS prog_mod');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_program_type.name', 'Professional Program');
        $this->db->join('tbl_master_program_type', 'tbl_master_program_type.code = tbl_master_programs.program_type');
        $this->db->join('tbl_master_faculty', 'tbl_master_faculty.code = tbl_master_programs.faculty');
        $this->db->join('tbl_master_program_level', 'tbl_master_program_level.code = tbl_master_programs.program_level');
        $this->db->join('tbl_master_program_mode', 'tbl_master_program_mode.code = tbl_master_programs.mode');
        $this->db->order_by('created_at','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_AllSpecialPrograms()
    {
        $this->db->select('tbl_master_programs.*, tbl_master_faculty.name AS fac_name, tbl_master_program_level.name AS prog_lvl, tbl_master_program_mode.name AS prog_mod');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_program_type.name', 'Special Program');
        $this->db->join('tbl_master_program_type', 'tbl_master_program_type.code = tbl_master_programs.program_type');
        $this->db->join('tbl_master_faculty', 'tbl_master_faculty.code = tbl_master_programs.faculty');
        $this->db->join('tbl_master_program_level', 'tbl_master_program_level.code = tbl_master_programs.program_level');
        $this->db->join('tbl_master_program_mode', 'tbl_master_program_mode.code = tbl_master_programs.mode');
        $this->db->order_by('created_at','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_AllSpecialTailoredPrograms()
    {
        $this->db->select('tbl_master_programs.*, tbl_master_faculty.name AS fac_name, tbl_master_program_level.name AS prog_lvl, tbl_master_program_mode.name AS prog_mod');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_program_type.name', 'Special Tailored Program');
        $this->db->join('tbl_master_program_type', 'tbl_master_program_type.code = tbl_master_programs.program_type');
        $this->db->join('tbl_master_faculty', 'tbl_master_faculty.code = tbl_master_programs.faculty');
        $this->db->join('tbl_master_program_level', 'tbl_master_program_level.code = tbl_master_programs.program_level');
        $this->db->join('tbl_master_program_mode', 'tbl_master_program_mode.code = tbl_master_programs.mode');
        $this->db->order_by('created_at','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_AllOtherPrograms()
    {
        $this->db->select('tbl_master_programs.*, tbl_master_faculty.name AS fac_name, tbl_master_program_level.name AS prog_lvl, tbl_master_program_mode.name AS prog_mod');
        $this->db->from('tbl_master_programs');
        $this->db->where('tbl_master_program_type.name !=', 'Academic Program');
        $this->db->where('tbl_master_program_type.name !=', 'Professional Program');
        $this->db->where('tbl_master_program_type.name !=', 'Special Program');
        $this->db->where('tbl_master_program_type.name !=', 'Special Tailored Program');
        $this->db->join('tbl_master_program_type', 'tbl_master_program_type.code = tbl_master_programs.program_type');
        $this->db->join('tbl_master_faculty', 'tbl_master_faculty.code = tbl_master_programs.faculty');
        $this->db->join('tbl_master_program_level', 'tbl_master_program_level.code = tbl_master_programs.program_level');
        $this->db->join('tbl_master_program_mode', 'tbl_master_program_mode.code = tbl_master_programs.mode');
        $this->db->order_by('created_at','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // function fetch_AllAcademicPrograms()
    // {
    //     $this->db->where('program_type', 'AC');
    //     $query = $this->db->get('tbl_master_programs');
    //     return $query->result();
    // }

    function fetch_program_awards(){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->join('tbl_master_program_awards', 'tbl_master_program_awards.program_code = tbl_master_programs.code', 'inner');

        $query = $this->db->get();
        return $query->result();
    }

    function fetch_program_assessment_types(){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->join('tbl_program_assessment_type', 'tbl_program_assessment_type.program_code = tbl_master_programs.code', 'inner');

        $query = $this->db->get();
        return $query->result();
    }

    function fetch_program_modules(){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->join('tbl_master_program_module', 'tbl_master_program_module.code = tbl_master_programs.code', 'inner');

        $query = $this->db->get();
        return $query->result();
    }

    function fetch_program_module_topics(){
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->join('tbl_master_program_module_topic', 'tbl_master_program_module_topic.module_code = tbl_master_program_module.code', 'inner');

        $query = $this->db->get();
        return $query->result();
    }

    function get_awards_by_program_code($code)
    {
        $this->db->select('award_type');
        $this->db->where('program_code', $code);
        $query = $this->db->get('tbl_master_program_awards');
        $result = $query->result_array();

        $awardTypes = array();
        foreach ($result as $row) {
            $awardTypes[] = $row['award_type'];
        }
        
        return $awardTypes;
    }

    function get_assessment_types_by_program_code($code)
    {
        $this->db->select('assessment_code');
        $this->db->where('program_code', $code);
        $query = $this->db->get('tbl_program_assessment_type');
        $result = $query->result_array();

        $assessmentTypes = array();
        foreach ($result as $row) {
            $assessmentTypes[] = $row['assessment_code'];
        }
        
        return $assessmentTypes;
    }

    function get_audience_by_program_code($code)
    {
        $this->db->select('target_audience_code');
        $this->db->where('program_code', $code);
        $query = $this->db->get('tbl_program_audience');
        $result = $query->result_array();

        $audience = array();
        foreach ($result as $row) {
            $audience[] = $row['target_audience_code'];
        }

        return $audience;
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_programs', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_topic($data)
    {
        $this->db->insert("tbl_master_program_module_topic", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function remove_topic($topicData)
    {
        $this->db->where('code', $topicData['topiccode']);
        $this->db->delete('tbl_master_program_module_topic');

        return $this->db->affected_rows() > 0;
    }

//    function insert_module($data)
//    {
//        $this->db->insert('tbl_master_program_module', $data);
//        if ($this->db->affected_rows() > 0) {
//            return true;
//        } else {
//            return false;
//        }
//    }
   function insert_file($data)
   {
       $this->db->insert('tbl_master_program_documents', $data);
       if ($this->db->affected_rows() > 0) {
           return true;
       } else {
           return false;
       }
   }

    function insert_assessment_types($data)
    {
        $this->db->insert('tbl_program_assessment_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_assessment_type($code, $assessment_code)
    {
        $this->db->where('program_code', $code);
        $this->db->where('assessment_code', $assessment_code);
        $this->db->delete('tbl_program_assessment_type');
    }

    function insert_target_audience($data)
    {
        $this->db->insert('tbl_program_audience', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_target_audience($code, $target_audience_code)
    {
        $this->db->where('program_code', $code);
        $this->db->where('target_audience_code', $target_audience_code);
        $this->db->delete('tbl_program_audience');
    }

    function insert_awards($data)
    {
        $this->db->insert('tbl_master_program_awards', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_awards($code, $award_type)
    {
        $this->db->where('program_code', $code);
        $this->db->where('award_type', $award_type);
        $this->db->delete('tbl_master_program_awards');
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_programs');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_programs", $data);
    }

    function update_awards($code, $data_award_types)
    {
        $this->db->where("program_code", $code);
        $this->db->where("award_type", $data_award_types['award_type']);
        return $this->db->update("tbl_master_program_awards", $data_award_types);
    }

    function award_exists_in_master_awards($award)
    {
        $this->db->where('code', $award);
        $query = $this->db->get('tbl_master_awards');
        return $query->num_rows() > 0;
    }

    function update_atypes($code, $data_assessment_types)
    {
        $this->db->where("program_code", $code);
        $this->db->where("assessment_code", $data_assessment_types['assessment_code']);
        return $this->db->update("tbl_program_assessment_type", $data_assessment_types);
    }

    function update_audience($code,$data_program_audience)
    {
        $this->db->where("program_code", $code);
        $this->db->where("target_audience_code", $data_program_audience['target_audience_code']);
        return $this->db->update("tbl_program_audience", $data_program_audience);
    }

    function update_module($id, $data_module)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_program_module", $data_module);
    }

    // function update_topic($id, $data_topic)
    // {
    //     $this->db->where("id", $id);
    //     return $this->db->update("tbl_master_program_module_topic", $data_module);
    // }

    function update_topic($topicData)
    {
        $this->db->where('code', $topicData['topiccode']);
        unset($topicData['topiccode']); 
        $this->db->update('tbl_master_program_module_topic', $topicData);

        return $this->db->affected_rows() > 0;
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_programs', ['id' => $id]);
         
    }

    function getModuleTopicsByProgramCode($programCode)
    {
        $this->db->select('*');
        $this->db->from('tbl_master_program_module_topic');
        $this->db->where('program_code', $programCode);
        // $this->db->group_by('module_code');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_all_program_types()
    {
        $query = $this->db->get('tbl_master_program_type');
        return $query->result();
    }

    function fetch_all_program_levels()
    {
        $query = $this->db->get('tbl_master_program_level');
        return $query->result();
    }

    function fetch_all_faculties()
    {
        $query = $this->db->get('tbl_master_faculty');
        return $query->result();
    }

    function fetch_all_awarding_institutions()
    {
        $query = $this->db->get('tbl_master_university');
        return $query->result();
    }

    function fetch_all_mediums()
    {
        $query = $this->db->get('tbl_master_program_medium');
        return $query->result();
    }

    function fetch_all_target_aud()
    {
        $this->db->order_by('tbl_master_target_audience.code');
        $query = $this->db->get('tbl_master_target_audience');
        return $query->result();
    }

    function fetch_all_methodologies()
    {
        $query = $this->db->get('tbl_master_program_methodology');
        return $query->result();
    }

    function fetch_all_modes()
    {
        $query = $this->db->get('tbl_master_program_mode');
        return $query->result();
    }

    function fetch_all_modules()
    {
        $query = $this->db->get('tbl_master_program_module');
        return $query->result();
    }

    function fetch_all_durations()
    {
        $query = $this->db->get('tbl_master_program_duration');
        return $query->result();
    }
    function fetch_all_max()
    {
        $query = $this->db->get('tbl_master_programs');
        return $query->result();
    }
    function fetch_all_min()
    {
        $query = $this->db->get('tbl_master_programs');
        return $query->result();
    }

    function fetch_all_assessment_types()
    {
        $query = $this->db->get('tbl_master_assessment_type');
        return $query->result();
    }

//    function fetch_all_assessment_types()
//    {
//        $this->db->select('*');
//        $this->db->from('tbl_master_assessment_type');
//        $this->db->join('tbl_master_programs', 'tbl_master_programs.code = tbl_master_assessment_type.code');
//
//        $query = $this->db->get('tbl_master_assessment_type');
//        return $query->result();
//    }

    function fetch_all_awards()
    {
        $query = $this->db->get('tbl_master_awards');
        return $query->result();
    }

    function fetch_all_attempts()
    {
        $this->db->order_by('tbl_master_attempts.id');
        $query = $this->db->get('tbl_master_attempts');
        return $query->result();
    }

    function fetch_all_selection_pro()
    {
        $query = $this->db->get('tbl_master_program_selection_procedure');
        return $query->result();
    }

    function approve_reject_data($program_id, $data)
    {
        $this->db->where("id", $program_id);

        return $this->db->update("tbl_master_programs", $data);
    }

    function getEditData($data)
    {
        $this->db->select('tbl_master_programs.*,tbl_program_assessment_type.assessment_code,tbl_program_assessment_type.id as assessment_id,');
        $this->db->from('tbl_master_programs');
        $this->db->join('tbl_master_programs', 'tbl_program_assessment_type.program_code = tbl_master_programs.code');
        $this->db->where("tbl_master_programs.code", $data);

        $query = $this->db->get();
        return $query->result();
    }

    function get_file($id)
    {
        $query=$this->db->get_where('tbl_master_programs', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->file;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function get_program_code($id)
    {
        $query=$this->db->get_where('tbl_master_programs', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function fetch_assessmentcodes_for_program($program_code)
    {
        $this->db->where("program_code", $program_code);
        $query = $this->db->get('tbl_program_assessment_type');
        return $query->result();
    }
    
    function fetch_targetAudience_for_program($program_code)
    {
        $this->db->where("program_code", $program_code);
        $query = $this->db->get('tbl_program_audience');
        return $query->result();
    }

    function fetch_awards_for_program($program_code)
    {
        $this->db->where("program_code", $program_code);
        $query = $this->db->get('tbl_master_program_awards');
        return $query->result();
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_programs'); 
        return $query->num_rows() > 0;
    }

    function getByCodeOrNameById($code, $name, $id)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_programs'); 
        return $query->num_rows() > 0;
    }
    
    
}