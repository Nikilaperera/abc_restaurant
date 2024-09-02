<?php
class NavbarDataModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function fetchNavbarData($userGroups)
    {
        $groupedData = [];
        
        foreach ($userGroups as $userGroup) {
            $this->db->select('auth_system_modules.path, auth_system_modules.name, auth_system_module_sections.icon, auth_system_module_sections.title');
            $this->db->from('auth_system_modules');
            $this->db->join('auth_system_module_sections', 'auth_system_modules.section = auth_system_module_sections.id');
            $this->db->join('auth_system_permissions', 'auth_system_modules.id = auth_system_permissions.module_id');
            $this->db->where('auth_system_permissions.group_id', $userGroup['group_id']);
            $this->db->where('auth_system_permissions.view_access', 'Yes');
            $this->db->order_by('auth_system_module_sections.order, auth_system_modules.order');
            $query = $this->db->get();
            $result = $query->result_array();
    
            foreach ($result as $item) {
                $title = $item['title'];
                if (!isset($groupedData[$title])) {
                    $groupedData[$title] = [
                        'path' => '',
                        'title' => $title,
                        'icon' => $item['icon'],
                        'items' => [],
                    ];
                }
                $groupedData[$title]['items'][] = [
                    'path' => $item['path'],
                    'name' => $item['name'],
                ];
            }
        }

        $groupedArray = array_values($groupedData);

        return $groupedArray;
    }

    function getUserGroup($userId) {
        $this->db->where('user_id', $userId);
        $query = $this->db->get('users_groups');
        $userGroups = $query->result_array();
        return $userGroups;
    }

    function getGroupById($userId)
    {
        $this->db->where('user_id', $userId);
        $query = $this->db->get('users_groups');
        return $query->row();
    }

    function getUserModulePermissions($groupId, $moduleId) {
        $this->db->where('group_id', $groupId);
        $this->db->where('module_id', $moduleId);
        $query = $this->db->get('auth_system_permissions');
        return $query->result();
    }
}