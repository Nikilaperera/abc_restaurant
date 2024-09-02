<?php

class DashboardModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMemberships()
    {
        $this->db->select('tbl_master_membership_category.name,COUNT(*) as count');
        $this->db->from('tbl_member_info');
        $this->db->join('tbl_master_membership_category','tbl_master_membership_category.code=tbl_member_info.membership_category');
        $this->db->group_by('tbl_master_membership_category.name');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProgramApplicationData()
    {
        $this->db->select('COUNT(*) as count,DATE_FORMAT(created_at, "%Y-%m-%d") as date');
        $this->db->from('tbl_student_program_application');
        $this->db->where('DATE_FORMAT(tbl_student_program_application.created_at, "%Y-%m-%d")>=', date('Y-m-d', strtotime('-7 days')));
        $this->db->group_by('DATE_FORMAT(tbl_student_program_application.created_at, "%Y-%m-%d")');
        $query = $this->db->get();
        return $query->result();
    }

    public function getRegisterdStudentData()
    {
        $sevenDaysAgo = date('Y-m-d', strtotime('-6 days'));
        $today = date('Y-m-d');
        $this->db->select('COUNT(*) as count,DATE_FORMAT(created_at, "%Y-%m-%d") as date');
        $this->db->from('tbl_students_register');
//        $this->db->where("BETWEEN DATE_FORMAT(tbl_students_register.created_at, '%Y-%m-%d')=='".date('Y-m-d', strtotime('-7 days'))."' AND "."DATE_FORMAT(tbl_students_register.created_at, '%Y-%m-%d')=='".date('Y-m-d')."'");
        $this->db->where("DATE_FORMAT(tbl_students_register.created_at, '%Y-%m-%d') BETWEEN '$sevenDaysAgo' AND '$today'");
        $this->db->group_by('DATE_FORMAT(tbl_students_register.created_at, "%Y-%m-%d")');
        $query = $this->db->get();
        return $query->result();
    }


}
