<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class ChefMasterController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_Email'] = true;
        $this->load->model('ChefMasterModel');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->database();
        $this->load->library('api_auth');
        if ($this->api_auth->isNotAuthenticated()) {
            $err = array(
                'Status' => false,
                'messgae' => 'unauthorized',
                'data' => []
            );
            $this->response($err, 401);
        }
    }

    function index_get()
    {
        $tables = $this->ChefMasterModel->fetch_all();
        $this->response($tables, 200);
    }

    function delete_delete($id)
      {

          $result = $this->ChefMasterModel->delete_single_data($id);

          if ($result > 0) {
              $this->response([
                  'Status' => true,
                  'message' => 'Chef Detail deleted successfully'
              ], RestController::HTTP_OK);
          } else {
              $this->response([
                  'Status' => false,
                  'message' => 'Chef Detail deletion failed. Please try again'
              ], RestController::HTTP_BAD_REQUEST);
          }
      }


      function add_post()
          {
              $Name = $this->post('Name');
              $Email = $this->post('Email');
              $Status = $this->post('Status');


              $existingRecord = $this->MenuItemModel->getByNameOrEmail($Name, $Email);

              if ($existingRecord) {
                  $response = [
                      'message' => 'A record with the same chef details already exists.',
                      'data' => $existingRecord
                  ];
                  $this->response($response, 400);
              } else {
                  $data = [
                      'Name' => $Name,
                      'Email' => $Email,
                      'Status' => $Status,
                  ];

                  $this->MenuItemModel->insert_api($data);
                  $this->response($data, 200);
              }
          }

//     function add_post()
//         {
//             $val = $this->input->post();
// //             Print_r($val);
//
//
//             $data = [
//                 'Name' => $this->post('Name'),
//                 'Email' => $this->post('Email'),
//                 'Status' => $this->post('Status')
//             ];
//
// //             var_dump($data);
//             // Insert logic here
//             $this->ChefMasterModel->insert_api($data);
//
//             // Response logic
//             $this->response($data, 200);
//         }
//
//         function update_post($id)
//             {
//                 $data = [
//                     'Name' => $this->post('Name'),
//                     'Email' => $this->post('Email'),
//                     'Status' => $this->post('Status')
//                 ];
//
//                 // Update logic here
//                 $this->ChefMasterModel->update_data($id, $data);
//
//                 // Response logic
//                 $this->response($data, 200);
//             }


    function update_post($id)
        {
            $Name = $this->post('Name');
            $Email = $this->post('Email');
            $Status = $this->post('Status');

            $existingRecord = $this->MenuItemModel->getNameOrEmailByID($id, $Name, $Email);

            if ($existingRecord) {
                $response = [
                    'message' => 'A record with the same chef details already exists.',
                    'data' => $existingRecord
                ];
                $this->response($response, 400);
            } else {
                $data = [
                    'Name' => $Name,
                    'Email' => $Email,
                    'Status' => $Status
                ];

                $this->MenuItemModel->update_data($id, $data);
                $this->response($data, 200);
            }
        }


    function getChef_get()
    {
        $program_types = $this->ChefMasterModel->fetchAllChefs();
        $this->response($program_types, 200);

    }

}