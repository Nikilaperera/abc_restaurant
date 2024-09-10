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

    function delete_delete($id)
    {

        $checkOrderStatus = $this->kitchen_mod->check_order_status($id);

        if ($checkOrderStatus == 'Pending' || $checkOrderStatus == 'Canceled'){
            $result = $this->kitchen_mod->delete_single_data($id);

            if($result > 0)
            {
                $this->response([
                    'status' => true,
                    'message' => 'Order deleted successfully'
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'Request Type deletion failed. Please try again'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'This Order already Prepared. Cannot Delete!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    function getAllMenuItems_post()
    {
        $menu_type = $this->post('menu_type');
        $menu_items = $this->kitchen_mod->fetchAllMenuItems($menu_type);
        $this->response($menu_items, 200);
    }

    function getAllMenuTypes_get()
    {
        $menu_types = $this->kitchen_mod->fetchAllMenuTypes();
        $this->response($menu_types, 200);
    }

    function update_post($id)
    {

        $data = [
            'order_status' => $this->post('order_status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->kitchen_mod->update_data($id, $data);

        $this->response($data, 200);
    }

}