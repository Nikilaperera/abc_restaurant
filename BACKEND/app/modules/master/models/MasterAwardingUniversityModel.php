<?php
class MasterAwardingUniversityModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_university');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_university', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_university');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_university", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_university', ['id' => $id]);
         
    }
    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_university');
        return $query->row();
    }

    function check_exists_in_other_tables($code)
    {
        $tables = $this->db->list_tables();
    
        foreach ($tables as $table) {
            if ($table !== 'tbl_master_university') {
                $this->db->where('code', $code);
                $query = $this->db->get($table);
                if ($query->num_rows() > 0) {
                    return true;
                }
            }
        }
        return false;
    }
    

    function get_code($id)
    {
        $query=$this->db->get_where('tbl_master_university', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return null;
        }
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_university'); 
        return $query->num_rows() > 0;
    }

    function getByCodeOrNameById($code, $name, $id)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_university'); 
        return $query->num_rows() > 0;
    }

    function getCountry(){
        $this->db->select('*');
        $this->db->from('tbl_master_countries');
        $query = $this->db->get();
        return $query->result();
    }

    function getCountryCode($country){
        $this->db->select('*');
        $this->db->from('tbl_master_countries');
        $this->db->where('name', $country);
        $query = $this->db->get();
        return $query->row();
    }

}