<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class NavbarDataController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NavbarDataModel', 'nav_mod');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->database();
        $this->load->library('api_auth');
        if ($this->api_auth->isNotAuthenticated()) {
            $err = array(
                'status' => false,
                'messgae' => 'unauthorized',
                'data' => []
            );
            $this->response($err,401);
        }
    }

    function fetch_data_endpoint_get() {
        $userId = $this->api_auth->getUserId();
        $userGroups = $this->nav_mod->getUserGroup($userId);

        $data = $this->nav_mod->fetchNavbarData($userGroups);
        $this->response($data, 200);
    }

    function permissions_get($moduleId)
    {
        $userId = $this->api_auth->getUserId();
        $groupId = $this->nav_mod->getGroupById($userId)->group_id;
        $permissions = $this->nav_mod->getUserModulePermissions($groupId, $moduleId);
        $this->response($permissions, 200);
    }
}