<?php
class ResourcePersonModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->where("approval_status",'Pending');
        $query = $this->db->get('tbl_resource_person');
        return $query->result();
    }

    function fetch_all_approved()
    {
        $this->db->where("approval_status", 'Approved');
        $query = $this->db->get('tbl_resource_person');
        return $query->result();
    }

    function fetch_all_rejected()
    {
        $this->db->where("approval_status", 'Rejected');
        $query = $this->db->get('tbl_resource_person');
        return $query->result();
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_resource_person');
        return $query->row();
    }

    function insert_api($data)
    {

        $this->db->insert("tbl_resource_person", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getMaxResourceId()
    {
        $this->db->select_max('resource_person_id');
        $query = $this->db->get('tbl_resource_person');
        $result = $query->row_array();

        if ($result && !empty($result['resource_person_id'])) {
            // Extract the numeric part of the ID
            $numericPart = intval(substr($result['resource_person_id'], 2));
            return $numericPart;
        }

        // If no ID found, return 0 as the default value
        return 0;
    }


    function insert_payments($data)
    {
        $this->db->insert("tbl_resource_person_payment_types", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_programs($data)
    {
        $this->db->insert("tbl_resource_person_program_modules", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_experiences($data)
    {
        $this->db->insert("tbl_resource_person_experiences", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_payment_data($resource_person_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_resource_person_payment_types');
        $this->db->where("resource_person_id", $resource_person_id);
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_program_data($resource_person_id)
    {
        $this->db->select('tbl_resource_person_program_modules.*, tbl_master_programs.name AS program_name, tbl_master_program_type.name AS program_type_name, tbl_master_program_module.name AS module_name, tbl_master_program_module_topic.name AS topic_name');
        $this->db->from('tbl_resource_person_program_modules');
        $this->db->where("resource_person_id", $resource_person_id);
        $this->db->join('tbl_master_programs','tbl_master_programs.code = tbl_resource_person_program_modules.program');
        $this->db->join('tbl_master_program_type','tbl_master_program_type.code = tbl_resource_person_program_modules.program_type');
        $this->db->join('tbl_master_program_module','tbl_master_program_module.code = tbl_resource_person_program_modules.module_code');
        $this->db->join('tbl_master_program_module_topic','tbl_master_program_module_topic.code = tbl_resource_person_program_modules.topic');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_experience_data($resource_person_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_resource_person_experiences');
        $this->db->where("resource_person_id", $resource_person_id);
        $query = $this->db->get();
        return $query->result();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_resource_person", $data);
    }

    function update_payments($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_resource_person_payment_types", $data);
    }

    function update_programs($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_resource_person_program_modules", $data);
    }

    function update_experiences($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_resource_person_experiences", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_resource_person', ['id' => $id]);

    }

    function delete_payment_data($id)
    {
        return $this->db->delete('tbl_resource_person_payment_types', ['id' => $id]);
    }

    // ---------------------------------------------------------
    function delete_ByID($resource_person)
    {
        $this->db->delete('tbl_resource_person_payment_types', ['resource_person_id' => $resource_person]);
        $this->db->delete('tbl_resource_person_program_modules', ['resource_person_id' => $resource_person]);
        $this->db->delete('tbl_resource_person_qualifications', ['resource_person_id' => $resource_person]);
    }
    // ---------------------------------------------------------

    function delete_program_data($id)
    {
        return $this->db->delete('tbl_resource_person_program_modules', ['id' => $id]);
    }

    function delete_experience_data($id)
    {
        return $this->db->delete('tbl_resource_person_experiences', ['id' => $id]);
    }

    public function get_ids($resource_person_id) {
        $this->db->select('id');
        $this->db->from('tbl_resource_person_qualifications');
        $this->db->where('resource_person_id', $resource_person_id);
        $query = $this->db->get();
        $ids = array();
        foreach ($query->result() as $row) {
            $ids[] = $row->id;
        }
        return $ids;
    }

    function insert_qualifications($data){

        $this->db->insert('tbl_resource_person_qualifications', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_qualification($id,$resource_person_id,$data)
    {        
        $this->db->where("id", $id);
        $this->db->where("resource_person_id", $resource_person_id);
        return $this->db->update("tbl_resource_person_qualifications", $data);
    }

    function delete_qualification($id)
    {
        return $this->db->delete('tbl_resource_person_qualifications', ['id' => $id]);
    }

    function delete_qualification_by_resource_person_id($resource_person_id)
    {
        return $this->db->delete('tbl_resource_person_qualifications', ['resource_person_id' => $resource_person_id]);
    }

    function fetch_all_resource_person_qualifications($id)
    {
        $this->db->select('*' );
        $this->db->from('tbl_resource_person_qualifications');
        $this->db->where('resource_person_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_resource_person_id($id)
    {
        $query=$this->db->get_where('tbl_resource_person', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->resource_person_id;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function fetch_all_titles(){

        $query = $this->db->get('tbl_master_title');
        return $query->result();
    }

    function fetch_all_designations(){

        $query = $this->db->get('tbl_master_designation');
        return $query->result();
    }

    function fetch_all_qualifications()
    {
        $this->db->select('name');
        $this->db->from('tbl_master_preferred_areas');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_all_otherqualifications(){

        $query = $this->db->get('tbl_resource_person');
        return $query->result();
    }

    function get_person($id)
    {
        $query=$this->db->get_where('tbl_resource_person', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->resource_person_id;
        } else {
            return null; // or any appropriate value if no matching record is found
        }
    }

    function approval_reject_data($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_resource_person', $data);
    }

    function approval_reject_program_data($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_resource_person_program_modules', $data);
    }

    function approval_reject_payment_data($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_resource_person_payment_types', $data);
    }

    function approveRejectResourcePerson($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_resource_person", $data);
    }

    function fetchProgramTypes() 
    {
        $query = $this->db->get("tbl_master_program_type");
		return $query->result();
    }

    function fetchPrograms($program_type)
    {
        $this->db->where('program_type', $program_type);
        $query = $this->db->get("tbl_master_programs");
		return $query->result();
    }

    function fetchModules($program_type, $program)
    {
        $this->db->where('program_type', $program_type);
        $this->db->where('program', $program);
        $query = $this->db->get("tbl_master_program_module");
		return $query->result();
    }

    function fetchTopics($program, $module)
    {
        $this->db->where('program_code', $program);
        $this->db->where('module_code', $module);
        $query = $this->db->get("tbl_master_program_module_topic");
		return $query->result();
    }

    function getEmails($id)
    {
        $this->db->select('email');
        $this->db->from('tbl_resource_person');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_QualificationsByID($id)
    {
        $this->db->where('resource_person_id', $id);
        $query = $this->db->get('tbl_resource_person_qualifications');
        return $query->result();
    }

    function getModuleName($code){
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');
        $this->db->where('code', $code);
        $query = $this->db->get();
        return $query->row();
    }
}