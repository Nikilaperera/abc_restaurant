<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class viewController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserRegisterModel');
        $this->load->model('Ion_auth_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('url');

        $this->load->database();
        $this->load->library('ion_auth');
        $this->load->library('api_auth');
        $this->load->library('email');
        $this->load->library(['system_log']);



    }
    function view_email_template(){
        $this->load->view('email/email');
    }


}