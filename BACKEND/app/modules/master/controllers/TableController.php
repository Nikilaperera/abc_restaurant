<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class TableController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TableModel');
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
        $tables = $this->TableModel->fetch_all();
        $this->response($tables, 200);
    }

    function add_post()
    {
        $code = $this->post('code');
        $name = $this->post('name');
        $status = $this->post('status');

        $existingRecord = $this->TableModel->getByCodeOrName($code, $name);

        if ($existingRecord ) {
            $response = [
                'message' => 'A record with the same table already exists.',
                'data' => $existingRecord
            ];
            $this->response($response, 400);
        } else {
            $data = [
                'code' => $code,
                'name' => $name,
                'status' => $status
            ];

            $this->TableModel->insert_api($data);
            $this->response($data, 200);
        }
    }

    function update_post($id)
    {

        $code = $this->post('code');
        $name = $this->post('name');

        $existingRecord = $this->TableModel->getByCodeOrNameByID($id, $code, $name);

        if($existingRecord) {
            $response = [
                'message' => 'A record with the same table already exists.',
                'data' => $existingRecord
            ];
            $this->response($response, 400);
        } else {
            $data = [
                'code' => $code,
                'name' => $name,
                'status' => $this->post('status'),
            ];

            $this->TableModel->update_data($id, $data);
            $this->response($data, 200);
        }


    }

    function delete_delete($id)
    {

        $result = $this->TableModel->delete_single_data($id);

        if($result > 0)
        {
            $this->response([
                'status' => true,
                'message' => 'Table deleted successfully'
            ], RestController::HTTP_OK);
        }
        else
        {
            $this->response([
                'status' => false,
                'message' => 'Table deletion failed. Please try again'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}