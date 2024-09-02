<?php
/**
 * Created by PhpStorm.
 * User: S.Priyadarshan
 * Date: 24-Jun-16
 * Time: 8:55 AM
 */

class Permissions_mod extends CI_Model
{
    private $permissions_table = 'auth_system_permissions';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_permission($condition)
    {
        $this->db->select('auth_system_permissions.user_id');
        $this->db->from($this->permissions_table);
        $this->db->join('auth_system_modules', 'auth_system_permissions.module_id=auth_system_modules.id', 'left');
        $this->db->where($condition);
        $query = $this->db->get();
        $permitted_users = array();
        foreach($query->result() as $row)
        {
            array_push($permitted_users, (int)$row->user_id);
        }
        return $permitted_users;
    }

    public function in_user_has_permisson($check_users)
    {
        $current_user = $this->session->userdata('user_id');
        $groups = array('admin');
        if ($this->ion_auth->in_group($groups)) {
            return true;
        } else {
            foreach ($check_users as $key => $value)
            {
                if ($value==$current_user)
                {
                    return true;
                }
            }
        }
        /*$current_user = $this->session->userdata('user_id');
        if($current_user==1){
            return true;
        } else {
            foreach ($check_users as $key => $value)
            {
                if ($value==$current_user)
                {
                    return true;
                }
            }
        }*/
    }


    function select_all_data($table_name, $condition = NULL)
    {
        $this->db->select('*');
        $this->db->from($table_name);
        if ($condition !== NULL)
        {
            $this->db->where($condition);
        }
        $query = $this->db->get();
        return $query;
    }

    function chk_module_permisson_data($path,$current_user)
    {
        $this->db->select('auth_system_modules.id as mid,auth_system_permissions.user_id,auth_system_modules.path as mpath');
        $this->db->from('auth_system_permissions');
        $this->db->join('auth_system_modules', 'auth_system_permissions.module_id=auth_system_modules.id', 'left');
        $this->db->where('auth_system_modules.path',$path);
        $this->db->where('auth_system_permissions.user_id',$current_user);
        $q = $this->db->get();
        $groups = array('admin');
        if ($this->ion_auth->in_group($groups)) {
            return true;
        } else {
            if ($q->num_rows() > 0) {
                return true;
            }else{
                return false;
            }
        }
        /*if($current_user==1){
            return true;
        } else {
            if ($q->num_rows() > 0) {
                return true;
            }else{
                return false;
            }
        }*/
    }
}