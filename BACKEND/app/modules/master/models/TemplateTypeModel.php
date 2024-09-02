<?php
class TemplateTypeModel extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all_template_types()
    {
        $query = $this->db->get('tbl_master_edm_template_type');
        return $query->result();
    }

    function checkDuplication($name)
    {

        $this->db->where("name", $name);
        $query = $this->db->get('tbl_master_edm_template_type');
        return $query->row();
    }

    function add_data($data){
        $this->db->insert('tbl_master_edm_template_type', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    function checkUpdateDuplication($id, $name)
    {
        $this->db->select("tbl_master_edm_template_type.id");
        $this->db->from("tbl_master_edm_template_type");
        $this->db->where("(name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }

    function update_model($user_id,$data){
        $this->db->where("id", $user_id);
        return $this->db->update("tbl_master_edm_template_type", $data);
    }

    function deleteTemplate($id){
        return $this->db->delete('tbl_master_edm_template_type', ['id' => $id]);
    }
}