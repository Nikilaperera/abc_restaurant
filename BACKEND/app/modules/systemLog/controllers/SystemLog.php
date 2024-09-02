<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class SystemLog extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SystemLogModel');
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
        $model = new SystemLogModel;
        $data = $model->fetch_all();
        $this->response($data, 200);
    }
    
   
    
   

}