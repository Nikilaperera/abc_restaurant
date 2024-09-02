<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class DashboardController extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ion_auth_model');
        $this->load->model('DashboardModel');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('kcrud');
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


    function getMembershipData_get()
    {
        $memberships = $this->DashboardModel->getMemberships();
        $this->response($memberships, 200);
    }

    function getProgramApplicationData_get()
    {
        $memberships = $this->DashboardModel->getProgramApplicationData();
        $this->response($memberships, 200);
    }
    function getRegisterdStudentData_get()
    {
        $memberships = $this->DashboardModel->getRegisterdStudentData();
        $this->response($memberships, 200);
    }
}

