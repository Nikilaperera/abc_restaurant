<?php
class MasterFollowupActivityCalledStatusModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->select('tbl_lead_follow_up_called_status.*,tbl_lead_follow_up_activities.name AS followupActivity,tbl_master_lead_called_status.name AS calledStatus');
        $this->db->from('tbl_lead_follow_up_called_status');
        $this->db->join('tbl_master_lead_called_status','tbl_master_lead_called_status.id=tbl_lead_follow_up_called_status.called_status','left'); 
        $this->db->join('tbl_lead_follow_up_activities','tbl_lead_follow_up_activities.id=tbl_lead_follow_up_called_status.follow_up_activity','left');
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetchallfollowupActivityList()
    {
        $this->db->select('tbl_lead_follow_up_activities.*');
        $this->db->from('tbl_lead_follow_up_activities'); 
        $this->db->where("tbl_lead_follow_up_activities.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }
    function fetchallcalledStatusList()
    {
        $this->db->select('tbl_master_lead_called_status.*');
        $this->db->from('tbl_master_lead_called_status');
        $this->db->where("tbl_master_lead_called_status.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }
    
    

    function insert_api($data)
    {
        $this->db->insert('tbl_lead_follow_up_called_status', $data);
        if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
        } else {
            return false;
        }
       
       
    }
     
       

    function fetch_single_data($id)
    {
        $this->db->select('tbl_lead_follow_up_called_status.*');
        $this->db->from('tbl_lead_follow_up_called_status');        
        $this->db->where("tbl_lead_follow_up_called_status.id", $id);
        $query=$this->db->get(); 
        return $query->row();
    }
    
    
  
    
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_lead_follow_up_called_status", $data);
    }
    
    
    
    function delete_data($code)
    {
        return $this->db->delete('tbl_lead_follow_up_called_status', ['id' => $code]);
         
    }

    function checkDuplication($code)
    {
        $this->db->where("code", $code);
        $query = $this->db->get('tbl_lead_follow_up_called_status');
        return $query->row();
    }

    function checkDupliction($id,$code){
        $this->db->select("tbl_lead_follow_up_called_status.id");
        $this->db->from("tbl_lead_follow_up_called_status");
        $this->db->where("(code = '$code') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}