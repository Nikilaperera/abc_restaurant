<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class CustomerFormController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CustomerFormModel','Cust_form_mod');
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

    function getAllTables_get()
    {

        $tables = $this->Cust_form_mod->fetchAllTables();
//        var_dump($tables);
//        die();
        $this->response($tables, 200);
    }
}