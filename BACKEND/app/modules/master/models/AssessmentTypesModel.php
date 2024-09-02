<?php
class AssessmentTypesModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('tbl_master_assessment_type');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_assessment_type', $data);
        if ($this->db->insert_id() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_assessment_type');
        return $query->row();
    }

    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_assessment_type", $data);
    }

    function delete_single_data($id)
    {
        $this->db->select("code");
        $this->db->where("id", $id);
        $query = $this->db->get("tbl_master_assessment_type");

        if ($query->num_rows() == 0) {
            return false;
        }

        $row = $query->row();
        $code = $row->code;

        $tables = $this->db->list_tables();

        foreach ($tables as $table) {
            if ($table !== 'tbl_master_assessment_type') {
                $columns = $this->db->list_fields($table);
                foreach ($columns as $column) {
                    $this->db->where($column, $code);
                    $query = $this->db->get($table);

                    if ($query->num_rows() > 0) {
                        return false;
                    }
                }

                $this->db->delete('tbl_master_assessment_type', ['id' => $id]);
                return true;
            }
        }
    }

    function checkDuplication($code, $name)
    {
        $this->db->where("code", "$code");
        $this->db->or_where("name", "$name");
        $query = $this->db->get('tbl_master_assessment_type');
        return $query->row();
    }

    function getByCodeOrName($code, $name)
    {
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $query = $this->db->get('tbl_master_assessment_type'); 
        return $query->num_rows() > 0;
    }

    function getByCodeOrNameByID($id, $code, $name)
    {
        $this->db->where('id !=', $id);
        $this->db->group_start();
        $this->db->where('code', $code);
        $this->db->or_where('name', $name);
        $this->db->group_end();
        $query = $this->db->get('tbl_master_assessment_type'); 
        return $query->num_rows() > 0;
    }
}