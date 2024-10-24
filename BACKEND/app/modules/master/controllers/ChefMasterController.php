<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class ChefMasterController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = true;
        $this->load->model('ChefMasterModel', 'chef_master_mod');
        $this->load->library('form_validation');
        $this->load->library('upload', $config);
        $this->load->database();
        $this->load->library('api_auth');
        if ($this->api_auth->isNotAuthenticated()) {
            $err = array(
                'status' => false,
                'message' => 'unauthorized',
                'data' => []
            );
            $this->response($err, 401);
        }
    }

    function index_get()
    {
        $menuTypes = $this->chef_master_mod->fetch_all();
        $this->response($menuTypes, 200);
    }

    function delete_delete($id)
    {
        $result = $this->chef_master_mod->delete_single_data($id);

        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'Menu Type deleted successfully'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Menu Type deletion failed. Please try again'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    function add_post()
    {
        $data = [
            'name' => $this->post('name'),
            'email' => $this->post('name'),
            'status' => $this->post('status')
        ];

        // Insert logic here
        $this->chef_master_mod->insert_api($data);

        // Response logic
        $this->response($data, 200);
    }

    function update_post($id)
    {
        $data = [
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'status' => $this->post('status')
        ];

        // Update logic here
        $this->chef_master_mod->update_data($id, $data);

        // Response logic
        $this->response($data, 200);
    }
}