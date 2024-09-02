<?php
class ModuleGroupsModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetch_all()
    {
        $query = $this->db->get('groups_modules');
        return $query->result();
    }

    function getGroups()
    {
        $this->db->where('name !=', 'Student');
        $query = $this->db->get('groups');
        return $query->result();
    }

    function getUsers()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->join("users_groups", "users_groups.user_id=users.id");
        $this->db->where('users_groups.group_id !=', 4);
        $this->db->where('users.active', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getSections()
    {
        $query = $this->db->get('auth_system_module_sections');
        return $query->result();
    }

    function getSectionById($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('auth_system_module_sections');
        return $query->row();
    }

    function getModules()
    {
        $query = $this->db->get('auth_system_modules');
        return $query->result();
    }

    // function getSectionByModule($module)
    // {
    //     $this->db->where('id', $module);
    //     $query = $this->db->get('auth_system_modules');
    //     return $query->row();
    // }

    function addPermissions($data)
    {
        $this->db->insert('groups_modules', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deletePermissions($group, $module)
    {
        return $this->db->delete('groups_modules', ['group_id' => $group, 'module_id' => $module]);
    }

    ////
    function update_permissions($data, $id)
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

    // function get_user_type($id)
    // {
    //     $this->db->select('groups.name');
    //     $this->db->from('users_groups');
    //     $this->db->join('groups', 'users_groups.group_id = groups.id');
    //     $this->db->where('user_id', $id);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

}
