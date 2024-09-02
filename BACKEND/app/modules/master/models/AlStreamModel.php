<?php
class AlStreamModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_lead_al_streams');
		return $query->result();
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_lead_al_streams', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_stream($stream_id)
    {
        $this->db->where("id", $stream_id);
        $query = $this->db->get('tbl_lead_al_streams');
        return $query->row();
    }

    function update_stream($stream_id, $data)
    {
        $this->db->where("id", $stream_id);
        return $this->db->update("tbl_lead_al_streams", $data);
    }

    function delete_single_stream($id)
    {
        //return $this->db->delete('tbl_lead_al_streams', ['id' => $stream_id]);
        $this->db->where('id',$id);
        return $this->db->delete('tbl_lead_al_streams');
    }

    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_lead_al_streams');
        return $query->row();
    }

    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_lead_al_streams.id");
        $this->db->from("tbl_lead_al_streams");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}