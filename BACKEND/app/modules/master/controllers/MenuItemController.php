<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class MenuItemController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MenuItemModel');
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
            $this->response($err, 401);
        }
    }

    function index_get()
    {
        $tables = $this->MenuItemModel->fetch_all();
        $this->response($tables, 200);
    }

    function add_post()
    {
        $code = $this->post('code');
        $menu_type = $this->post('menu_type');
        $name = $this->post('name');
        $remarks = $this->post('remarks');
        $status = $this->post('status');

        $existingRecord = $this->MenuItemModel->getByCodeOrName($code, $name);

        if ($existingRecord ) {
            $response = [
                'message' => 'A record with the same menu item already exists.',
                'data' => $existingRecord
            ];
            $this->response($response, 400);
        } else {
            $data = [
                'code' => $code,
                'menu_type' => $menu_type,
                'name' => $name,
                'remarks' => $remarks,
                'status' => $status
            ];

            $this->MenuItemModel->insert_api($data);
            $this->response($data, 200);
        }
    }

    function update_post($id)
    {
        $code = $this->post('code');
        $menu_type = $this->post('menu_type');
        $name = $this->post('name');
        $remarks = $this->post('remarks');
        $status = $this->post('status');

        $existingRecord = $this->MenuItemModel->getByCodeOrNameByID($id, $code, $name);

        if($existingRecord) {
            $response = [
                'message' => 'A record with the same menu item already exists.',
                'data' => $existingRecord
            ];
            $this->response($response, 400);
        } else {
            $data = [
                'code' => $code,
                'menu_type' => $menu_type,
                'name' => $name,
                'remarks' => $remarks,
                'status' => $status
            ];

            $this->MenuItemModel->update_data($id, $data);
            $this->response($data, 200);
        }
    }

    function getMenuTypes_get()
    {
        $program_types = $this->MenuItemModel->fetchAllMenuTypes();
        $this->response($program_types, 200);

    }

    function delete_delete($id)
    {

        $result = $this->MenuItemModel->delete_single_data($id);

        if($result > 0)
        {
            $this->response([
                'status' => true,
                'message' => 'Menu item deleted successfully'
            ], RestController::HTTP_OK);
        }
        else
        {
            $this->response([
                'status' => false,
                'message' => 'Menu item deletion failed. Please try again'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

}