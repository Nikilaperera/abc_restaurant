<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class ModuleGroupsController extends RestController
{

    public function __construct()
    {
        $module = 'SystemPermissions';
        parent::__construct();
        $this->load->model('ModuleGroupsModel');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->database();
        $this->load->library('System_log');
        $this->load->library('api_auth');
        if ($this->api_auth->isNotAuthenticated()) {
            $err = array(
                'status' => false,
                'message' => 'unauthorized',
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
        $model = new ModuleGroupsModel;
        $data = $model->fetch_all();
        $this->response($data, 200);
    }

    function getGroups_get()
    {
        $model = new ModuleGroupsModel;
        $groups = $model->getGroups();
        $this->response($groups, 200);
    }

    function getUsers_get()
    {
        $model = new ModuleGroupsModel;
        $users = $model->getUsers();
        $this->response($users, 200);
    }

    function getSections_get()
    {
        $model = new ModuleGroupsModel;
        $sections = $model->getSections();
        $this->response($sections, 200);
    }

    function getSectionById_get($id)
    {
        $model = new ModuleGroupsModel;
        $data = $model->getSectionById($id);
        $this->response($data, 200);
    }

    function getModules_get()
    {
        $model = new ModuleGroupsModel;
        $data = $model->getModules();
        $this->response($data, 200);
    }

    // function get_permissions_by_id_get($id)
    // {
    //     $model = new ModuleGroupsModel;
    //     $data = $model->get_permissions_by_id($id);
    //     $this->response($data, 200);
    // }

    // function get_moduleGroup_permissions_id_get($groups, $module)
    // {
    //     $model = new ModuleGroupsModel;
    //     $permission_data = $model->get_permissions_by_group_module_id($groups, $module);
    //     return $this->response($permission_data);
    // }

    function updatePermissions_post()
    {
        $model = new ModuleGroupsModel;
        $event = $this->post('event');
        $group = $this->post('group');
        $module = $this->post('module');

        if ($event == 'true') {
            $data = [
                'group_id' => $group,
                'module_id' => $module,
            ];
            $model->addPermissions($data);
            $this->response($data, 200);
        } else {
            $model->deletePermissions($group, $module);
            $this->response(true, 200);
        }
    }

    // public function user_permission_group_details_get()
    // {
    //     $data = $this->api_auth->user_permission_group_details();

    //     foreach ($data as $inner_array) {
    //         foreach ($inner_array as $object) {
    //             echo $object->module_id;
    //             echo $object->view_access;
    //             echo $object->add_access;
    //             echo $object->edit_access;
    //             echo $object->delete_access;
    //         }
    //     }
    // }

}
