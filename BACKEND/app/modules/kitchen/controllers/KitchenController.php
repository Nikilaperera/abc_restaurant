<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class KitchenController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KitchenModel','kitchen_mod');
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
        $kitchenDetails =  $this->kitchen_mod->fetch_all();
        $this->response($kitchenDetails, 200);

    }
}