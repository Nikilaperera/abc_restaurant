<?php
class DepartmentModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_department');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_department', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_department');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_department", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_department', ['id' => $id]);
         
    }
    function checkDuplication($code, $name)
    {
        $this->db->where("code", $code);
        $this->db->or_where("name", $name);
        $query = $this->db->get('tbl_master_department');
        return $query->row();
    }

    function check_exists_in_other_tables($id, $code)
    {
        $tables = $this->db->list_tables();
        $exclude_table = 'tbl_master_department';

        foreach ($tables as $table) {
            if ($table !== $exclude_table) {
                $this->db->where('id', $id); // Replace 'award_id' with the actual column name in each table
                $this->db->or_where('code', $code);
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
        $query=$this->db->get_where('tbl_master_department', array('id' => $id)); 
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->code;
        } else {
            return null;
        }
    }
}