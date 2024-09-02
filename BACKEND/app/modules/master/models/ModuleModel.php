<?php
class ModuleModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $this->db->order_by('tbl_master_program_module.code');
        $query = $this->db->get('tbl_master_program_module');
		return $query->result(); 
    }

    function insert_api($data)
    {
        $this->db->insert('tbl_master_program_module', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //
    
 

    function fetch_single_data($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('tbl_master_program_module');
        return $query->row();
    }
    function update_data($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update("tbl_master_program_module", $data);
    }

    function delete_single_data($id)
    {
        return $this->db->delete('tbl_master_program_module', ['id' => $id]);
         
    }

    function fetch_all_program_types()
    {
        $this->db->select('tbl_master_program_type.*');
        $this->db->from('tbl_master_program_type'); 
        $this->db->where("tbl_master_program_type.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function fetch_all_programs()
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }

    public function getByCode($code)
    {
        $this->db->where('code', $code);
        $query = $this->db->get('tbl_master_program_module');
        return $query->row();
    }
    public function getByName($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('tbl_master_program_module');
        return $query->row();
        
    }

    function checkUpdateDuplication($id, $code, $name)
    {
        $this->db->select("tbl_master_program_module.id");
        $this->db->from("tbl_master_program_module");
        $this->db->where("(code = '$code' OR name = '$name') AND (id != '$id')");
        $query = $this->db->get();
        return $query->row();
    }

    //----------------------
    function fetchAllProgramTypes()
    {
        $this->db->select('tbl_master_program_type.*');
        $this->db->from('tbl_master_program_type'); 
        $this->db->where("tbl_master_program_type.status",'Active');
        $query=$this->db->get(); 
		return $query->result(); 
    }


    function fetchAllPrograms()
    {
        $this->db->select('tbl_master_programs.*');
        $this->db->from('tbl_master_programs');
        $this->db->where("tbl_master_programs.status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }

    function get_programs($data){
        
        $this->db->select('*');
        $this->db->from('tbl_master_programs');
        $this->db->where("program_type", $data);
        $query = $this->db->get();
        return $query->result();

    }

    //get all code
    function getcodes()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');
        $this->db->where("status",'Active');  
        $query=$this->db->get(); 
		return $query->result(); 
    }


    //get module toop
    
    function get_program_module_topic()
    {
        $this->db->select('*');
        $this->db->from('tbl_master_program_module');

        $query = $this->db->get();
        return $query->result();
    }
}