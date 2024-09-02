<?php
class TargetAudienceModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_target_audience');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_target_audience', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_targetAudience($targetAudience_id)
    {
        $this->db->where("id", $targetAudience_id);
        $query = $this->db->get('tbl_master_target_audience');
        return $query->row();
    }
    // function update_targetAudience($targetAudience_id, $data)
    // {
    //     $this->db->where("id", $targetAudience_id);
    //     return $this->db->update("tbl_master_target_audience", $data);
    // }


    public function update_targetAudience($id,$code,$name,$status){

        $response = array('status'=>false,'message'=>"");
        if(!$id||!$code||!$name||!$status){
            $response['message']="incomplete";
            return $response;
        }

        $datauni=array(
            
            'code'=>$code,
            'name'=>$name,
            'status'=>$status
        );
        
        $this->db->where('id',$id);
        return $result = $this->db->update('tbl_master_target_audience',$datauni);

        if($result){
            $response['status']=true;
        }else{
            $response['message']="faill update";
        }

    }






    function delete_single_targetAudience($targetAudience_id)
    {
        return $this->db->delete('tbl_master_target_audience', ['id' => $targetAudience_id]);
    }
    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_target_audience'); 
        return $query->num_rows() > 0;
    }
}



