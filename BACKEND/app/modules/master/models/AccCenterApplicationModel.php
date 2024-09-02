<?php
class AccCenterApplicationModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getApplicationNumber(){
        $this->db->select("tbl_accredited_centre_application.application_no");
        $this->db->from("tbl_accredited_centre_application");
        $this->db->order_by("application_no","desc");
        $query = $this->db->get();
        return $query->row();

    }

    function fetch_all()
    {
        $this->db->select('tbl_accredited_centre_application.*,tbl_accredited_centres_visit_schedule.visit_status');
        $this->db->from('tbl_accredited_centre_application');
        $this->db->join('tbl_accredited_centres_visit_schedule','tbl_accredited_centres_visit_schedule.application_no = tbl_accredited_centre_application.application_no','left');
        $query = $this->db->get();

        return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_accredited_centre_application', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_accredited_centre_application');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_accredited_centre_application", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_accredited_centre_application', ['id' => $id]);

    }

    function insert_visit_api($data)
    {
        $this->db->insert('tbl_accredited_centres_visit_schedule', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_visit($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_accredited_centres_visit_schedule", $data);
    }

    function fetch_all_scheduled_visits()
    {
        $query = $this->db->get('tbl_accredited_centres_visit_schedule');
        return $query->result();
    }

    function insert_rejection_reason($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_accredited_centre_application", $data);
    }

    function update_approve_status($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_accredited_centre_application", $data);
    }

    function approve_application( $data)
    {
        $this->db->insert('tbl_accredited_centres', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function approve_visit_status($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_accredited_centres_visit_schedule", $data);
    }

    function fetch_visit_single_data($application_no)
    {
        $this->db->where("application_no", $application_no);
        $query = $this->db->get('tbl_accredited_centres_visit_schedule');
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

    function fetchAllRegistrationFee(){
        $this->db->select('tbl_master_accredited_subscription_type.registration_fee');
        $this->db->from('tbl_master_accredited_subscription_type');
        $query=$this->db->get();
        return $query->row();
    }

    public function getRegistrationFee() {

        $this->db->select('registration_fee');
        $this->db->from('tbl_master_accredited_subscription_type');
        $query = $this->db->get();

        // Check if the query was successful
        if ($query->num_rows() > 0) {
            // Assuming you want to return a single value (registration_fee)
            return $query->row()->registration_fee;
        } else {
            // Handle the case where no data is found
            return null;
        }
    }


    function fetchprograms($program_type)
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs'); 
        $this->db->where("tbl_master_programs.status",'Active');
        $this->db->where("tbl_master_programs.program_type",$program_type);
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

}
