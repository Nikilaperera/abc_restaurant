<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class UserGroupsController extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserGroupsModel','usergroup_model');
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

    function index_get()
    {
        $model = new UserGroupsModel;
        $model = $model->fetch_all();
        $this->response($model, 200);
    }

    function add_post()
    {
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $this->usergroup_model->insert_api($data);
    }

    function update_post($id)
    {
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $this->usergroup_model->update_api($id, $data);
    }

    function fetch_single_get()
    {
        if ($this->input->post('id')) {
            $data = $this->UserGroupsModel->fetch_single_user($this->input->post('id'));
            foreach ($data as $row) {
                $output['id'] = $row["id"];
                $output['name'] = $row["name"];
                $output['description'] = $row["description"];

            }
            echo json_encode($output);
        }
    }


}