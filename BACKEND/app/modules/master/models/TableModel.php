<?php

class TableModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_table');
        return $query->result();
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_table');
        return $query->num_rows() > 0;
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_table', $data);
        if ($this->db->insert_id() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getByCodeOrNameByID($id, $code, $name)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_table');
        return $query->num_rows() > 0;
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_table", $data);
    }

    function delete_single_data($id)
    {
        $this->db->select("code");
        $this->db->where("id", $id);
        $query = $this->db->get("tbl_master_table");

        if ($query->num_rows() == 0) {
            return false;
        }

        $row = $query->row();
        $code = $row->code;

        $tables = $this->db->list_tables();

        foreach ($tables as $table) {
            if ($table !== 'tbl_master_table') {
                $columns = $this->db->list_fields($table);
                foreach ($columns as $column) {
                    $this->db->where($column, $code);
                    $query = $this->db->get($table);

                    if ($query->num_rows() > 0) {
                        return false;
                    }
                }

                $this->db->delete('tbl_master_table', ['id' => $id]);
                return true;
            }
        }
    }
}
