<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class SystemUserPermissions extends RestController
{

    public function __construct()
    {
        $module = 'SystemPermissions';
        parent::__construct();
        $this->load->model('SystemUserPermissionModel');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->database();
        $this->load->library('System_log');
        $this->load->library('api_auth');
        if ($this->api_auth->isNotAuthenticated()) {
            $err = array(
                'status' => false,
                'messgae' => 'unauthorized',
                'data' => []
            );
            $this->response($err, 401);
        }

        $data = $this->api_auth->user_permission_group_details();
        $modnames = array();


        foreach ($data as $inner_array) {
            foreach ($inner_array as $object) {
                $modname = $object->module_name;
                array_push($modnames, $modname);
                //echo $object->module_name;

            }

        }
        // if (!in_array($module, $modnames)) {
        //     $err = array(
        //         'status' => false,
        //         'messgae' => 'you are not autherized for view this page',
        //     );
        //     $this->response($err, 401);
        // }
    }

    function index_get()
    {
        $module_id = 122;
        $access = $this->api_auth->checkModuleViewAccess($module_id);
        if (!($access)) {
            $err = array(
                'status' => false,
                'messgae' => 'you are not view access for this page',
            );
            $this->response($err, 401);
        }
        $all_permissions = new SystemUserPermissionModel;
        $data = $all_permissions->fetch_all();
        $this->response($data, 200);
    }

    public function get_all_groups_get()
    {
        $groupList = $this->SystemUserPermissionModel->all_groups();
        return $this->response($groupList, 200);
    }

    public function get_all_users_get()
    {
        $usersList = $this->SystemUserPermissionModel->all_users();
        return $this->response($usersList, 200);
    }

    function get_all_sections_get()
    {
        $all_sections = new SystemUserPermissionModel;
        $data = $all_sections->get_sections();
        $this->response($data, 200);

    }
    function get_all_sections_by_id_get($id)
    {
        $all_sections = new SystemUserPermissionModel;
        $data = $all_sections->get_sections_by_id($id);
        $this->response($data, 200);

    }
    function get_all_modules_get()
    {
        $model = new SystemUserPermissionModel;
        $data = $model->get_modules();
        $this->response($data, 200);

    }

    function get_permissions_by_id_get($id)
    {
        $model = new SystemUserPermissionModel;
        $data = $model->get_permissions_by_id($id);
        $this->response($data, 200);
    }
    function get_moduleGroup_permissions_id_get($groups, $module)
    {
        $model = new SystemUserPermissionModel;
        $permission_data = $model->get_permissions_by_group_module_id($groups, $module);
        return $this->response($permission_data);
    }
    public function addPermissions_post()
    {
        // $module_id = 122;
        // $module_id = $this->input->post('module');
        // $access = $this->api_auth->checkModuleAddAccess($module_id);
        // if (!($access)) {
        //     $err = array(
        //         'status' => false,
        //         'message' => 'you are not authorized for perform this action',
        //     );
        //     $this->response($err, 401);
        // }
        // $access = $this->api_auth->checkModuleUpdateAccess($module_id);
        // if (!($access)) {
        //     $err = array(
        //         'status' => false,
        //         'message' => 'you are not authorized for perform this action',
        //     );
        //     $this->response($err, 401);
        // }

        $groups = $this->input->post('group');
        $user = $this->input->post('user');
        $module = $this->input->post('module');
        $section = $this->SystemUserPermissionModel->getSectionByModule($module)->section;
        $view_access = $this->input->post('view_access');
        $add_access = $this->input->post('add_access');
        $edit_access = $this->input->post('edit_access');
        $delete_access = $this->input->post('delete_access');
        $approve_access_1 = $this->input->post('approve1_access');
        $approve_access_2 = $this->input->post('approve2_access');
        $approve_access_3 = $this->input->post('approve3_access');
        $reject_access = $this->input->post('reject_access');
        $model = new SystemUserPermissionModel;
        $permission_data = $model->get_permissions_by_group_module_id($groups, $module);
        $id = $permission_data[0]->id;
        if ($id) {

            if ($view_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'view_access' => ($view_access),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $view_access,
                    ];
                    $this->system_log->create_system_log('View', 'Success', $res['message']);
                    $this->response($data, 200);
                }

            } elseif ($add_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'add_access' => ($add_access),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $add_access,
                    ];
                    $this->system_log->create_system_log('Add', 'Success', $res['message']);
                    $this->response($data, 200);
                }

            } elseif ($edit_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'edit_access' => ($edit_access),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $edit_access,
                    ];
                    $this->system_log->create_system_log('View', 'Success', $res['message']);
                    $this->response($data, 200);
                }

            } elseif ($delete_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'delete_access' => ($delete_access),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $delete_access,
                    ];
                    $this->system_log->create_system_log('Delete', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_1) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve1_access' => ($approve_access_1),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $approve_access_1,
                    ];
                    $this->system_log->create_system_log('Approve_1', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_2) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve2_access' => ($approve_access_2),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $approve_access_2,
                    ];
                    $this->system_log->create_system_log('Approve_2', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_3) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve3_access' => ($approve_access_3),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $approve_access_3,
                    ];
                    $this->system_log->create_system_log('Approve_3', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($reject_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'reject_access' => ($reject_access),
                ];
                $success = $this->SystemUserPermissionModel->update_permissions($data, $id);
                if ($success) {
                    $res = [
                        'message' => $reject_access,
                    ];
                    $this->system_log->create_system_log('Reject', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            }

        } else {
            if ($view_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'view_access' => ($view_access),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $view_access,
                    ];
                    $this->system_log->create_system_log('View', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($add_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'add_access' => ($add_access),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $add_access,
                    ];
                    $this->system_log->create_system_log('Add', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($edit_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'edit_access' => ($edit_access),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $edit_access,
                    ];
                    $this->system_log->create_system_log('Add', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($delete_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'delete_access' => ($delete_access),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $delete_access,
                    ];
                    $this->system_log->create_system_log('Delete', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_1) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve_access' => ($approve_access_1),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $approve_access_1,
                    ];
                    $this->system_log->create_system_log('Approve_1', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_2) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve_access_2' => ($approve_access_2),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $approve_access_2,
                    ];
                    $this->system_log->create_system_log('Approve_2', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($approve_access_3) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'approve_access_3' => ($approve_access_3),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $approve_access_3,
                    ];
                    $this->system_log->create_system_log('Approve_3', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            } elseif ($reject_access) {
                $data = [
                    'group_id' => ($groups),
                    'section_id' => ($section),
                    'module_id' => ($module),
                    'reject_access' => ($reject_access),
                ];
                $success = $this->SystemUserPermissionModel->add_permissions($data);
                if ($success) {
                    $res = [
                        'message' => $reject_access,
                    ];
                    $this->system_log->create_system_log('Reject', 'Success', $res['message']);
                    $this->response($data, 200);
                }
            }

        }

    }
    public function user_permission_group_details_get()
    {
        // $data = $this->api_auth->user_permission_group_details();

        // foreach ($data as $inner_array) {
        //     foreach ($inner_array as $object) {
        //         echo $object->module_id; 
        //         echo $object->view_access; 
        //         echo $object->add_access; 
        //         echo $object->edit_access; 
        //         echo $object->delete_access; 

        //     }
        // }

    }

}
