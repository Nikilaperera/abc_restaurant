<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class TitleController extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('TitleModel');
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

        $titles = new TitleModel;
        $titles = $titles->fetch_all();
        $this->response($titles, 200);

    }

    function add_post()
    {
        $data = [
            'name' => $this->post('name'),
        ];
        if($this->TitleModel->insert_api($data)){
            $this->response($data, 200);
        }
        else{
            $this->response([
                'status' => false,
                'message' => 'Already Exists !'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    function fetch_single_get()
    {
        if ($this->input->post('id')) {
            $data = $this->TitleModel->fetch_single_user($this->input->post('id'));
            foreach ($data as $row) {
                $output['name'] = $row["name"];

            }
            echo json_encode($output);
        }
    }

    function update_post($id)
    {

        $title = new TitleModel;
        $data = [
            'name' => $this->post('name'),
        ];

        $title->update_title($id, $data);


        $this->response($data, 200);
    }

    function delete_delete($id)
    {

        $title = new TitleModel;
        $result = $title->delete_single($id);



        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'Title deleted successfully'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Title deletion failed. Please try again'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

}
