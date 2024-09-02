<?php
class UserRegisterModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function register_user_data($data)
    {
        $this->db->insert('tbl_students_register', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_all_submissions()
    {
        $this->db->where_not_in('status', ['Rejected']);
        $query = $this->db->get('tbl_students_register');
        return $query->result();
    }

    function fetch_all_pending_submissions(){
        $this->db->where('status', 'Received');
        $this->db->or_where('status', 'Approved');
        $query = $this->db->get('tbl_students_register');
        return $query->result();
    }

    function fetch_getStudentRegister($id)
    {
        $this->db->select('tbl_students_register.*, tbl_master_program_medium.name AS medium_name');
        $this->db->from('tbl_students_register');
        $this->db->join('tbl_master_program_medium', 'tbl_master_program_medium.code = tbl_students_register.medium');
        $this->db->where('tbl_students_register.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    function fetch_getStudentUniDetails($temp_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_students_register_academic_qualification');
        $this->db->where('temp_student_id', $temp_id);
        $query = $this->db->get();
        return $query->result();
    }

    //getSubscription
    function getSubscription($id){
        $this->db->select('*');
        $this->db->from('tbl_payment_member_subscription');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
     function getCourcePayment($id){
         $this->db->select('*');
         $this->db->from('tbl_student_payments');
         $this->db->where('id', $id);
         $query = $this->db->get();
         return $query->row();
     }

    function fetch_getStudentALDetails($temp_id)
    {
        $this->db->select('tbl_students_register_academic_result.*, tbl_students_register.attachment_qualification1 as attachment');
        $this->db->from('tbl_students_register_academic_result');
        $this->db->join('tbl_students_register', 'tbl_students_register.temp_student_id = tbl_students_register_academic_result.temp_student_id');
        $this->db->where('tbl_students_register_academic_result.temp_student_id', $temp_id);
        $this->db->where('exam_type', 'AL');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_getStudentOLDetails($temp_id)
    {
        $this->db->select('tbl_students_register_academic_result.*, tbl_students_register.attachment_qualification2 as attachment');
        $this->db->from('tbl_students_register_academic_result');
        $this->db->join('tbl_students_register', 'tbl_students_register.temp_student_id = tbl_students_register_academic_result.temp_student_id');
        $this->db->where('tbl_students_register_academic_result.temp_student_id', $temp_id);
        $this->db->where('exam_type', 'OL');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_getStudentEmpDetails($temp_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_students_register_employment_details');
        $this->db->where('temp_student_id', $temp_id);
        $query = $this->db->get();
        return $query->result();
    }

    function academic_qualifications($data)
    {
        $this->db->insert('tbl_students_register_academic_qualification', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function academic_results($data)
    {
        $this->db->insert('tbl_students_register_academic_result', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function employer_details($data)
    {
        $this->db->insert('tbl_students_register_employment_details', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_allpending(){
        $this->db->select('tbl_students_register.*, tbl_master_program_medium.name AS medium_name');
        $this->db->from('tbl_students_register');
        $this->db->join('tbl_master_program_medium', 'tbl_master_program_medium.code = tbl_students_register.medium');
        $this->db->where('tbl_students_register.status', 'Received');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_allL01approved(){
        $this->db->select('tbl_students_register.*, tbl_master_program_medium.name AS medium_name');
        $this->db->from('tbl_students_register');
        $this->db->join('tbl_master_program_medium', 'tbl_master_program_medium.code = tbl_students_register.medium');
        $this->db->where('tbl_students_register.status', 'L01 Approved');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_allapproved($nic){
        $this->db->select('tbl_students_register.*, tbl_master_program_medium.name AS medium_name');
        $this->db->from('tbl_students_register');
        $this->db->join('tbl_master_program_medium', 'tbl_master_program_medium.code = tbl_students_register.medium','left');
        $this->db->where('tbl_students_register.status', 'Approved');
        $this->db->group_start();
        $this->db->or_where('tbl_students_register.nic', $nic);
        $this->db->or_where('tbl_students_register.last_name', $nic);
        $this->db->group_end();
        $this->db->order_by('tbl_students_register.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_allrejected(){
        $this->db->select('tbl_students_register.*, tbl_master_program_medium.name AS medium_name');
        $this->db->from('tbl_students_register');
        $this->db->join('tbl_master_program_medium', 'tbl_master_program_medium.code = tbl_students_register.medium');
        $this->db->where('tbl_students_register.status', 'Rejected');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_titles(){
        $this->db->select('*');
        $this->db->from('tbl_master_title');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_civil_status(){
        $this->db->select('*');
        $this->db->from('tbl_master_civil_status');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_gender(){
        $this->db->select('*');
        $this->db->from('tbl_master_gender');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_country(){
        $this->db->select('*');
        $this->db->from('tbl_master_countries');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_district_all(){
        $this->db->select('*');
        $this->db->from('tbl_master_districts');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_get_title(){
        $this->db->select('*');
        $this->db->from('tbl_master_title');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_country_id($country){
        $this->db->select('*');
        $this->db->from('tbl_master_countries');
        $this->db->where('name', $country);
        $query = $this->db->get();
        return $query->row();
    }
    function fetch_district($country_id){
        $this->db->select('*');
        $this->db->from('tbl_master_districts');
        $this->db->where('country_id', $country_id);
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_ol_sub(){
        $this->db->select('*');
        $this->db->from('tbl_master_ol_subjects');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_al_sub(){
        $this->db->select('tbl_master_al_subjects.name');
        $this->db->from('tbl_master_al_subjects');
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_medium(){
        $this->db->select('*');
        $this->db->from('tbl_master_program_medium');
        $this->db->where("name = 'English' OR name = 'Sinhala' OR name = 'Tamil'");
        $query = $this->db->get();
        return $query->result();
    }
    function fetch_ac_type(){
        $this->db->select('*');
        $this->db->from('tbl_master_academic_type');
        $query = $this->db->get();
        return $query->result();
    }

    function enrol_students($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tbl_students_register', $data);
        return $this->db->affected_rows() > 0;
    }

    function approveRejectStudent($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_students_register', $data);
    }

    function get_registered_students($nic)
    {
        $this->db->select('*');
        $this->db->from('tbl_students_register');
        $this->db->where('nic', $nic);
        $query = $this->db->get();
        return $query->result();
        // $this->db->order_by('created_at', 'DESC');
        // $this->db->limit(1);
        // $query = $this->db->get('tbl_students_register');

        // print_r($query);
        // die();

        // if ($query->num_rows() > 0) {
        //     return $query->row();
        // } else {
        //     return null;
        // }
    }

    function getNICbyID($id)
    {
        // $this->db->where('member_id', $id);
        // $this->db->select('nic');
        // $this->db->where('temp_student_id', $id);
        // $this->db->order_by('created_at', 'DESC');
        // $this->db->limit(1);
        // $query = $this->db->get('tbl_students_register');
        // print_r($query);
        // die();

        $this->db->select('nic');
        $this->db->from('tbl_students_register');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    
        // if ($query->num_rows() > 0) {
        //     $row = $query->row();
        //     return $row->nic;
        // } else {
        //     return null;
        // }
    }

    function getNICbyTableID($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_students_register');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->nic;
        } else {
            return null;
        }
    }

    //get usergroup
	public function checkusergroup($mail)
    {
		// print_r($mail);
		// die();
		$this->db->select('groups.name');
        $this->db->from('users');
        $this->db->join('users_groups', 'users_groups.user_id = users.id');
        $this->db->join('groups', 'groups.id = users_groups.group_id');
         $this->db->where('users.email',$mail);
        $query = $this->db->get();
        return $query->row();
	}

    function getTempId($year)
    {
        $this->db->select('tbl_students_register.temp_student_id');
        $this->db->from('tbl_students_register');
        $this->db->order_by('id', 'desc');
        $this->db->like('temp_student_id', $year, 'both');
        $query = $this->db->get();
        return $query->row();
    }

    //get lead management details
    function checkLeadManagemet($nic){
        $this->db->select('*');
        $this->db->from('tbl_lead_management');
        $this->db->where('nic', $nic);
        $this->db->where('status','Register');
        $query = $this->db->get();
        return $query->row();
    }

    //update status
    function updateStatus($id, $data){
        $this->db->where("id", $id);
        return $this->db->update("tbl_lead_management", $data);
    }

    //update lead student or not
    function upateleadStudent($id,$data){
        $this->db->where("id", $id);
        return $this->db->update("tbl_students_register", $data);
    }


}
