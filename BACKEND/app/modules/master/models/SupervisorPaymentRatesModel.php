<?php
class SupervisorPaymentRatesModel extends  CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function fetch_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_supervisor_payment ');
//        $this->db->join('tbl_master_grade_details', 'tbl_master_grade_details.main_id = tbl_master_grade.id', 'inner');
        $query = $this->db->get();
        return $query->result();

    }

    function add_data($main_data){
        $this->db->insert('tbl_master_supervisor_payment', $main_data);

            return $this->db->insert_id();
    }


    function delete_rates($id){
        return $this->db->delete('tbl_master_supervisor_payment', ['id' => $id]);
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_supervisor_payment", $data);
    }
}