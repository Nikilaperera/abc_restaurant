<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class ReservationTypeController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = true;
        $this->load->model('ReservationTypeModel', 'reservation_type_mod');
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
        $reservationTypes = $this->reservation_type_mod->fetch_all();
        $this->response($reservationTypes,200);
    }

    function add_post()
    {
        $data = [
            'code' => $this->post('code'),
            'name' => $this->post('name'),
            'status' => $this->post('status')
        ];

        // Insert logic here
        $this->reservation_type_mod->insert_api($data);

        // Response logic
        $this->response($data, 200);
    }

    function delete_delete($id)
    {
        $result = $this->reservation_type_mod->delete_single_data($id);

        if ($result > 0) {
            $this->response([
                'status' => true,
                'message' => 'Reservation Type deleted successfully'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Reservation Type deletion failed. Please try again'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    function update_post($id)
    {
        $data = [
            'code' => $this->post('code'),
            'name' => $this->post('name'),
            'status' => $this->post('status')
        ];

        // Update logic here
        $this->reservation_type_mod->update_data($id, $data);

        // Response logic
        $this->response($data, 200);
    }
}
