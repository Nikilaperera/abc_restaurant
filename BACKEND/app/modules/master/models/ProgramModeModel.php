<?php
class ProgramModeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_program_mode');
		return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_mode', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_program($program_id)
    {
        $this->db->where("id", $program_id);
        $query = $this->db->get('tbl_master_program_mode');
        return $query->row();
    }
    function update_program($program_id, $data)
    {
        $this->db->where("id", $program_id);
        return $this->db->update("tbl_master_program_mode", $data);
    }

    function delete_single_program($program_id)
    {
        return $this->db->delete('tbl_master_program_mode', ['id' => $program_id]);
        //$this->db->where("id", $program_id);
        // $this->db->delete("programs");
        // if ($this->db->affected_rows() > 0) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
    function checkDuplication($code){
        // $this->db->select('*');
        // $this->db->from('tbl_master_program_mode');
        // $this->db->where('tbl_master_program_mode.code',$code);
        // $this->db->where('tbl_master_program_mode.name', $name);
        // $query = $this->db->get();
        // return $query->row();
        $this->db->select('*');
        $this->db->from('tbl_master_program_mode');
        $this->db->where('code', $code);
       
        $query = $this->db->get();
        return $query->row();
    }

    function checkDuplication2($name){

        $this->db->select('*');
        $this->db->from('tbl_master_program_mode');
        $this->db->where('name', $name);

        $query = $this->db->get();
        return $query->row();

    }

    function checkCodeInUse($code)
    {
        $tables = $this->db->list_tables();
        $exclude_table = 'tbl_master_program_mode';

        foreach ($tables as $table) {
            if ($table !== $exclude_table) {
                $this->db->where('code', $code);
                $query = $this->db->get($table);
                if ($query->num_rows() > 0) {
                    return true;
                }
            }
        }
        return false;
    }


    function checkDupliction($id,$code,$name){
        $this->db->select("tbl_master_program_mode.id");
        $this->db->from("tbl_master_program_mode");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }
}