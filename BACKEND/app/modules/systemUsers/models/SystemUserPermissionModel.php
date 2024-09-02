<?php
class SystemUserPermissionModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('auth_system_permissions');
        return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }
    function get_sections()
    {

        $query = $this->db->get('auth_system_module_sections');
        return $query->result();

        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }
    function get_sections_by_id($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('auth_system_module_sections');
        return $query->row();

        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }
    function get_modules()
    {
        $query = $this->db->get('auth_system_modules');
        return $query->result();
        // $this->db->order_by('id', 'DESC');
        // return $this->db->get('programs');
    }

    function getSectionByModule($module)
    {
        $this->db->where('id',$module);
        $query = $this->db->get('auth_system_modules');
        return $query->row();
    }

     function all_groups(){
        $this->db->where('name !=', 'Student');
        $query = $this->db->get('groups');
        return $query->result();
    }

    function all_users(){

        $this->db->select("*");
        $this->db->from("users");
        $this->db->join("users_groups","users_groups.user_id=users.id");
        $this->db->where('users_groups.group_id !=',4);
        $this->db->where('users.active',1);
        $query = $this->db->get();
        return $query->result();
    }

    function add_permissions($data)
    {


        $this->db->insert('auth_system_permissions', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
    function update_permissions($data,$id)
    {
  
        $this->db->where("id", $id);
        return $this->db->update('auth_system_permissions', $data);
      

    }

    function get_permissions_by_id($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('auth_system_permissions');
        return $query->row();

    }
    function get_permissions_by_group_module_id($groups, $module)
    {
        $this->db->select('id');
        $this->db->from('auth_system_permissions');
        $this->db->where("group_id", $groups);
        $this->db->where("module_id", $module);
        $query = $this->db->get();
        return $query->result();

    }

    // function get_user_type( $id){
      
    //     $this->db->select('groups.name');
    //     $this->db->from('users_groups');
    //     $this->db->join('groups', 'users_groups.group_id = groups.id');
        
    //     $this->db->where('user_id',$id);
    //     $query = $this->db->get();
    //     return $query->result();



    // }

}
