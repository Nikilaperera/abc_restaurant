<?php
class MasterFollowupActivityModel extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_lead_follow_up_activities', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_lead_follow_up_activities", $data);
    }

    function delete_data($code)
    {
        return $this->db->delete('tbl_lead_follow_up_activities', ['id' => $code]);

    }

    function fetch_all()
    {

        $this->db->select('tbl_lead_follow_up_activities.*');
        $this->db->from('tbl_lead_follow_up_activities');
        //  $this->db->join('tbl_master_lead_called_status','tbl_master_lead_called_status.id=tbl_lead_follow_up_called_status.called_status','left');
        //  $this->db->join('tbl_lead_follow_up_activities','tbl_lead_follow_up_activities.id=tbl_lead_follow_up_called_status.follow_up_activity','left');
        $query=$this->db->get();
        return $query->result();
    }

    function fetchallgetfacilitytypeList()
    {
        $this->db->select('tbl_master_facility_type.*');
        $this->db->from('tbl_master_facility_type');
        $this->db->where("tbl_master_facility_type.status",'Active');
        $query=$this->db->get();
        return $query->result();
    }

    function fetch_single_source($source_id)
    {
        $this->db->where("id", $source_id);
        $query = $this->db->get('tbl_lead_follow_up_activities');
        return $query->row();
    }

      //check duplicate
    //   function checkDuplication($name,$code)
    //   {
    //           $this->db->select("tbl_lead_follow_up_activities.id");
    //           $this->db->from("tbl_lead_follow_up_activities");
    //           $this->db->where("name = '$name'");
    //           $this->db->where("code = '$code'");
    //           $query = $this->db->get();
    //           return $query->row();
          
    //   }

    //   function checkDupliction($id,$name){
    //     $this->db->select("tbl_lead_follow_up_activities.id");
    //     $this->db->from("tbl_lead_follow_up_activities");
    //     $this->db->where("(name = '$name') AND (id != '$id')");
    //     $query = $this->db->get();
    //     return $query->row();
    // }
    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_lead_follow_up_activities');
        return $query->row();
    }

    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_lead_follow_up_activities.id");
        $this->db->from("tbl_lead_follow_up_activities");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }

}