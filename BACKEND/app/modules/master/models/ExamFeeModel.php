<?php
class ExamFeeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('tbl_master_exam_fee');
		return $query->result();
    }


    function fetchAllExamTypes()
    {
        $this->db->select('tbl_master_exam_type.*');
        $this->db->from('tbl_master_exam_type');
        $this->db->where("tbl_master_exam_type.status",'Active');
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

    function fetchAllPrograms($data)
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');
        $this->db->where("tbl_master_programs.program_type",$data);
        $query=$this->db->get();
		return $query->result();
    }

    function fetchAllModules($programType, $program)
    {
        $this->db->select('tbl_master_program_module.*');
        $this->db->from('tbl_master_program_module');
        $this->db->where("tbl_master_program_module.status",'Active');
        $this->db->where("tbl_master_program_module.program_type",$programType);
        $this->db->where("tbl_master_program_module.program",$program);
        $query=$this->db->get();
		return $query->result();
    }

    function fetchAllCurrency()
    {
        $this->db->select('tbl_master_currency.*');
        $this->db->from('tbl_master_currency');
        $this->db->where("tbl_master_currency.status",'Active');
        $query=$this->db->get();
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_exam_fee', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_examFee($examFee_id)
    {
        $this->db->where("id", $examFee_id);
        $query = $this->db->get('tbl_master_exam_fee');
        return $query->row();
    }

    function update_examFee($examFee_id, $data)
    {
        $this->db->where("id", $examFee_id);
        return $this->db->update("tbl_master_exam_fee", $data);
    }

    function delete_single_examFee($examFee_id)
    {
        return $this->db->delete('tbl_master_exam_fee', ['id' => $examFee_id]);
    }

}