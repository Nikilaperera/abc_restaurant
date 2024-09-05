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
}
