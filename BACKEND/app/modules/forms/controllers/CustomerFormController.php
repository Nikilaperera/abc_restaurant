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
        $this->response($tables, 200);
    }

    function getAllMenuTypes_get()
    {

        $menu_types = $this->Cust_form_mod->fetchAllMenuTypes();
        $this->response($menu_types, 200);
    }

    function getAllMenuItems_post()
    {
        $menu_type = $this->post('menu_type');
        $menu_items = $this->Cust_form_mod->fetchAllMenuItems($menu_type);
        $this->response($menu_items, 200);
    }

    function add_post() {

        $latest_order_id = $this->Cust_form_mod->get_latest_order_id();

        if ($latest_order_id) {
            $numeric_id = (int) str_replace('ORDID', '', $latest_order_id);
            $order_id = 'ORDERID' . ($numeric_id + 1);
        } else {
            $order_id = 'ORDERID1';
        }

        $customerName = $this->input->post('customerName');
        $customerEmail = $this->input->post('customerEmail');
        $customerNumber = $this->input->post('customerNumber');
        $Table_code = $this->input->post('Table_code');
        $orders = $this->input->post('orders'); // Fixed 'post'

        $data_array = json_decode($orders, true);

        foreach ($data_array as $order) {

            $data = [
                'order_id' => $order_id,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_number' => $customerNumber,
                'table_code' => $Table_code,
                'menu_type' => $order['menu_type'],
                'menu_item' => $order['menu_item'],
                'quantity' => $order['quantity'],
                'order_status' => 'Pending'
            ];

             $insert_id = $this->Cust_form_mod->insert_api($data);
        }

        $this->response(true, 200);
    }

}