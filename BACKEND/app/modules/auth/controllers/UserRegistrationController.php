<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class UserRegistrationController extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = 'TRUE';
        $config['max_size'] = '1000';
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

    function registered_pending_students_get()
    {
        $all = $this->UserRegisterModel->fetch_allpending();
        $this->response($all, 200);
    }

    function registered_L01_approved_students_get()
    {
        $all = $this->UserRegisterModel->fetch_allL01approved();
        $this->response($all, 200);
    }

    function registered_approved_students_post()
    {
        $nic = $this->post('nic');
        $all = $this->UserRegisterModel->fetch_allapproved($nic);
        $this->response($all, 200);
    }

    function registered_rejected_students_get()
    {
        $all = $this->UserRegisterModel->fetch_allrejected();
        $this->response($all, 200);
    }

    function getStudentRegister_get($id)
    {
        $apps =  $this->UserRegisterModel->fetch_getStudentRegister($id);
        $this->response($apps, 200);
    }

    function getStudentUniDetails_get($temp_id)
    {
        $data = $this->UserRegisterModel->fetch_getStudentUniDetails($temp_id);
        $this->response($data, 200);
    }

    function getStudentALDetails_get($temp_id)
    {
        $data = $this->UserRegisterModel->fetch_getStudentALDetails($temp_id);
        $this->response($data, 200);
    }

    function getStudentOLDetails_get($temp_id)
    {
        $data = $this->UserRegisterModel->fetch_getStudentOLDetails($temp_id);
        $this->response($data, 200);
    }

    function getStudentEmpDetails_get($temp_id)
    {
        $data = $this->UserRegisterModel->fetch_getStudentEmpDetails($temp_id);
        $this->response($data, 200);
    }

    function get_titles_get()
    {
        $titles = $this->UserRegisterModel->fetch_titles();
        $this->response($titles, 200);
    }
    function get_medium_get()
    {
        $titles = $this->UserRegisterModel->fetch_medium();
        $this->response($titles, 200);
    }
    function get_civil_status_get()
    {
        $civil = $this->UserRegisterModel->fetch_civil_status();
        $this->response($civil, 200);
    }
    function get_gender_get()
    {
        $gender = $this->UserRegisterModel->fetch_gender();
        $this->response($gender, 200);
    }
    function get_country_get()
    {
        $country = $this->UserRegisterModel->fetch_country();
        $this->response($country, 200);
    }

    function get_district_all_get()
    {
        $district = $this->UserRegisterModel->fetch_district_all();
        $this->response($district, 200);
    }

    function get_title_get()
    {
        $title = $this->UserRegisterModel->fetch_get_title();
        $this->response($title, 200);
    }

    function get_district_post()
    {
        $country = $this->post('country');
        $country_id = $this->UserRegisterModel->fetch_country_id($country)->id;
        $dis = $this->UserRegisterModel->fetch_district($country_id);
        $this->response($dis, 200);
    }
    function get_country_code_post()
    {
        $country = $this->post('country');
        $phonecode = $this->UserRegisterModel->fetch_country_id($country)->phonecode;
        $this->response($phonecode, 200);
    }
    function get_olSub_get()
    {
        $dis = $this->UserRegisterModel->fetch_ol_sub();
        $this->response($dis, 200);
    }
    function get_alSub_get()
    {
        $dis = $this->UserRegisterModel->fetch_al_sub();
        $this->response($dis, 200);
    }
    function get_acType_get()
    {
        $dis = $this->UserRegisterModel->fetch_ac_type();
        $this->response($dis, 200);
    }


    function userRegister_post()
    {

        $all_info = json_decode($this->post('user_info'));
        $user_info = $all_info->firstFormGroup;
        $user_contact_info = $all_info->secondFormGroup;
        $user_edu_info = $all_info->thirdFormGroup;
        $employ_info = $all_info->fourthFormGroup;

        // $temp_student_id = $user_info->nic;
        if ($this->UserRegisterModel->getTempId('REG'.date("Y"))) {
            $lastTempId = $this->UserRegisterModel->getTempId('abc_restaurant-REG' . date("Y"))->temp_student_id;
            $lastId = (int)substr($lastTempId,13);
            $temp_student_id = "abc_restaurant-REG" . date("Y") . '-' . (str_pad($lastId + 1, 7, "0", STR_PAD_LEFT));

        } else {
            $temp_student_id = "abc_restaurant-REG".date("Y").'-'.(str_pad(1, 7, "0", STR_PAD_LEFT));
        }

        $email = $user_contact_info->email;
        $email_hash = $this->Ion_auth_model->hash_password($email);
        $email_hash = str_replace('/', '', $email_hash);
        $email_hash = str_replace('$', '', $email_hash);

        $attachment_nic = $_FILES['attachment_nic'];
        $attachment_qualification1 = $_FILES['attachment_qualification1'];
        $attachment_qualification2 = $_FILES['attachment_qualification2'];
        $attachment_photograph = $_FILES['attachment_photograph'];

        $targetDir = 'uploads/reg_qualifications/';
        $targetEmpDir ='uploads/reg_confirmletters/';
        $uploadPath = 'uploads/register_data/';

        $attachment_nicName = $uploadPath . $attachment_nic['name'];
        $attachment_qualification1Name = $uploadPath . $attachment_qualification1['name'];
        $attachment_qualification2Name = $uploadPath . $attachment_qualification2['name'];
        $attachment_photographName = $uploadPath . $attachment_photograph['name'];

        move_uploaded_file($attachment_nic['tmp_name'], $attachment_nicName);
        move_uploaded_file($attachment_qualification1['tmp_name'], $attachment_qualification1Name);
        move_uploaded_file($attachment_qualification2['tmp_name'], $attachment_qualification2Name);
        move_uploaded_file($attachment_photograph['tmp_name'], $attachment_photographName);

        $link = base_url()."auth/UserRegistrationController/student_email_confirm/";

        $current_time = strtotime(date('Y-m-d H:i:s'));

        rename($uploadPath.$attachment_nic['name'], $uploadPath.'NIC-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_nic['name'], PATHINFO_EXTENSION));
        rename($uploadPath.$attachment_qualification1['name'], $uploadPath.'qual1-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification1['name'], PATHINFO_EXTENSION));
        rename($uploadPath.$attachment_qualification2['name'], $uploadPath.'qual2-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification2['name'], PATHINFO_EXTENSION));
        rename($uploadPath.$attachment_photograph['name'], $uploadPath.'photo-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_photograph['name'], PATHINFO_EXTENSION));

        $utcDateTime = new DateTime($user_info->birthday, new DateTimeZone('UTC'));
        $utcDateTime->setTimezone(new DateTimeZone('Asia/Colombo'));
        $birthday = $utcDateTime->format('Y-m-d');

        $phonecode = '+'.$this->UserRegisterModel->fetch_country_id($user_contact_info->country)->phonecode;
        if($user_contact_info->telephone == $phonecode){
            $user_contact_info->telephone = '-';
        }
        if($user_contact_info->mobile == $phonecode){
            $user_contact_info->mobile = '-';
        }
        //student status student management
        if($this->UserRegisterModel->checkLeadManagemet($user_info->nic)){
            $data=[
              'status'=>'Registered',
              // 'lead_student'=>'Yes',
            ];
            $this->UserRegisterModel->updateStatus($this->UserRegisterModel->checkLeadManagemet($user_info->nic)->id, $data);
          //   $data1=[
          //     'lead_student'=>'Yes',
          //   ];
          //   $this->UserRegisterModel->updateStatus($this->UserRegisterModel->checkLeadManagemet($user_info->nic)->id, $data);
          $student_register = [
            'temp_student_id' => $temp_student_id,
            'title' => $user_info->title,
            'initials' => $user_info->initials,
            'first_name' => $user_info->first_name,
            'middle_name' => $user_info->middle_name,
            'last_name' => $user_info->last_name,
            'full_name' => $user_info->full_name,
            'birthday' => $birthday,
            'civil_status' => $user_info->civil_status,
            'gender' => $user_info->gender,
            'medium' => 'E',
            'nic' => strtoupper($user_info->nic),

            'registration_type' => $user_contact_info->registration_type,
            'telephone' => $user_contact_info->telephone,
            'mobile' => $user_contact_info->mobile,
            'district' => $user_contact_info->district,
            'address1' => $user_contact_info->address1,
            'address2' => $user_contact_info->address2,
            'address3' => $user_contact_info->address3,
            'postal_code' => $user_contact_info->postal_code,
            'country' => $user_contact_info->country,
            'email' => $user_contact_info->email,
            'email_hash' => $email_hash,

            'attachment_nic' => $uploadPath.'NIC-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_nic['name'], PATHINFO_EXTENSION),
            'attachment_qualification1' => $uploadPath.'qual1-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification1['name'], PATHINFO_EXTENSION),
            'attachment_photograph' => $uploadPath.'photo-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_photograph['name'], PATHINFO_EXTENSION),
            'attachment_confirmation' => '-',
            'attachment_qualification2' => $uploadPath.'qual2-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification2['name'], PATHINFO_EXTENSION),
            'lead_student'=>'Yes',
        ];
  
          }else{
            $student_register = [
                'temp_student_id' => $temp_student_id,
                'title' => $user_info->title,
                'initials' => $user_info->initials,
                'first_name' => $user_info->first_name,
                'middle_name' => $user_info->middle_name,
                'last_name' => $user_info->last_name,
                'full_name' => $user_info->full_name,
                'birthday' => $birthday,
                'civil_status' => $user_info->civil_status,
                'gender' => $user_info->gender,
                'medium' => 'E',
                'nic' => strtoupper($user_info->nic),
    
                'registration_type' => $user_contact_info->registration_type,
                'telephone' => $user_contact_info->telephone,
                'mobile' => $user_contact_info->mobile,
                'district' => $user_contact_info->district,
                'address1' => $user_contact_info->address1,
                'address2' => $user_contact_info->address2,
                'address3' => $user_contact_info->address3,
                'postal_code' => $user_contact_info->postal_code,
                'country' => $user_contact_info->country,
                'email' => $user_contact_info->email,
                'email_hash' => $email_hash,
    
                'attachment_nic' => $uploadPath.'NIC-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_nic['name'], PATHINFO_EXTENSION),
                'attachment_qualification1' => $uploadPath.'qual1-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification1['name'], PATHINFO_EXTENSION),
                'attachment_photograph' => $uploadPath.'photo-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_photograph['name'], PATHINFO_EXTENSION),
                'attachment_confirmation' => '-',
                'attachment_qualification2' => $uploadPath.'qual2-'.strtoupper($user_info->nic).'_'.$current_time.'.'.pathinfo($attachment_qualification2['name'], PATHINFO_EXTENSION),
    
            ];

          }
  
      
        $email_data = [

            'title' => $user_info->title,
            'initials' => $user_info->initials,
            'first_name' => $user_info->first_name,
            'middle_name' => $user_info->middle_name,
            'last_name' => $user_info->last_name,
            'full_name' => $user_info->full_name,
            'registration_type' => $user_info->registration_type,
            'birthday' => $user_info->birthday,
            'civil_status' => $user_info->civil_status,
            'gender' => $user_info->gender,
            'medium' => 'E',
            'nic' => strtoupper($user_info->nic),

            'telephone' => $user_contact_info->telephone,
            'mobile' => $user_contact_info->mobile,
            'district' => $user_contact_info->district,
            'address1' => $user_contact_info->address1,
            'address2' => $user_contact_info->address2,
            'address3' => $user_contact_info->address3,
            'designation' => $user_contact_info->designation,
            'country' => $user_contact_info->country,
            'email' => $user_contact_info->email,

            'email_hash' => $email_hash,
            'link' => $link,
        ];

       
        $success = $this->UserRegisterModel->register_user_data($student_register);

        $acedimicInfo = $user_edu_info->acedemicDetails;

        $olYear = $user_edu_info->olyear;
        $olIndex = $user_edu_info->olIndex;
        $olResultInfo = $user_edu_info->olDetails;

        $alYear = $user_edu_info->alyear;
        $alIndex = $user_edu_info->alIndex;
        $alResultInfo = $user_edu_info->alDetails;


        if ($success) {

            if (!empty($acedimicInfo)) {
                foreach ($acedimicInfo as $val) {
                    if (!empty($val->degreeDetails) && $val->degreeDetails != "None") {
                        $attachment_qualification3 = $_FILES['attachment_qualification3'];
                        $attachment_qualification3Name = $targetDir . $attachment_qualification3['name'];
                        move_uploaded_file($attachment_qualification3['tmp_name'], $targetDir . $attachment_qualification3Name);
            
                        $academic_qualifications = [
                            'temp_student_id' => $temp_student_id,
                            'institution' => $val->uniDetails,
                            'academic_type' => $val->degreeDetails,
                            'attachment' => $targetDir . $val->attachment_qualification3,
                        ];
            
                        $acedimicInfoSuccess = $this->UserRegisterModel->academic_qualifications($academic_qualifications);
                    }
                }
            }  

            $employerInfo = $employ_info->employerDetails;
            if(!empty($employerInfo)) {
                foreach ($employerInfo as $val) {
                    if (!empty($val->designation) && !empty($val->employerName) && !empty($val->officialAddress)) {
                        $attachment_confirmation = $_FILES['attachment_confirmation'];
                        $attachment_confirmationName = $targetEmpDir . $attachment_confirmation['name'];
                        move_uploaded_file($attachment_confirmation['tmp_name'], $targetEmpDir . $attachment_confirmationName);

                        $fromDate = substr($val->fromDate,4,11);
                        $FromDate=date('Y-m-d', strtotime($fromDate));
                        $toDate = substr($val->toDate,4,11);
                        $ToDate=date('Y-m-d', strtotime($toDate));

                        $employer_details = [
                            'designation' => $val->designation,
                            'employer' => $val->employerName,
                            'address' => $val->officialAddress,
                            'telephone' => $val->officialContact,
                            'from_date'=>$FromDate,
                            'to_date'=>$ToDate,
                            'attachment' => $targetEmpDir . $val->attachment_confirmation,
                            // Use the generated filename
                            'temp_student_id' => $temp_student_id,
                        ];

                        $this->UserRegisterModel->employer_details($employer_details);
                    }
                }
            }

            if (!empty($olResultInfo)) {
                foreach ($olResultInfo as $val2) {
                    if (!empty($olIndex) && !empty($olYear) && !empty($val2->olSubject) && !empty($val2->olGrade)) {
                        $ol_results = [
                            'exam_type' => 'OL',
                            'temp_student_id' => $temp_student_id,
                            'index_no' => $olIndex,
                            'year' => $olYear,
                            'subject' => $val2->olSubject,
                            'grade' => strtoupper($val2->olGrade),
                        ];
                        $this->UserRegisterModel->academic_results($ol_results);
                    }
                }

            if (!empty($alResultInfo)) {
                foreach ($alResultInfo as $val3) {
                    if (!empty($alIndex) && !empty($alYear) && !empty($val3->alSubject) && !empty($val3->alGrade)) {
                        $al_results = [
                            'exam_type' => 'AL',
                            'temp_student_id' => $temp_student_id,
                            'index_no' => $alIndex,
                            'year' => $alYear,
                            'subject' => $val3->alSubject,
                            'grade' => strtoupper($val3->alGrade),
                        ];
                        $this->UserRegisterModel->academic_results($al_results);
                    }
                }
            }

                $message = $this->load->view("email/email", $email_data, true);
                $this->load->library('php_mailer');

                if ($this->php_mailer->sendEmail($email, $cc= null, 'abc_restaurant - Confirmation Email', $message)) {
                    $res = [
                        'message' => 'Email sent,success',
                    ];
                } else {
                    $res = [
                        'message' => 'Email sent,fail'
                    ];
                }

            }
        }
    }

    function uploadFile_post() {
        $targetDir = 'uploads/reg_qualifications/';
        $attachment_qualification3 = $_FILES['attachment_qualification3'];
        $attachment_qualification3Name = $targetDir . $attachment_qualification3['name'];
      
        if (move_uploaded_file($attachment_qualification3['tmp_name'], $attachment_qualification3Name)) {
          $response = [
            'success' => true,
          ];
        } else {
          $response = [
            'success' => false,
            'error' => 'File upload failed',
          ];
        }
        echo json_encode($response);
      }
      
      function uploadEmpFile_post() {
        $targetDir = 'uploads/reg_confirmletters/';
        $attachment_confirmation = $_FILES['attachment_confirmation'];
        $attachment_confirmationName = $targetDir . $attachment_confirmation['name'];
      
        if (move_uploaded_file($attachment_confirmation['tmp_name'], $attachment_confirmationName)) {
          $response = [
            'success' => true,
          ];
        } else {
          $response = [
            'success' => false,
            'error' => 'File upload failed',
          ];
        }
        echo json_encode($response);
      }

    function get_registered_students($nic)
    {
        $this->db->select('tbl_students_register.*');
        $this->db->where('tbl_students_register.nic', $nic);
        $this->db->from('tbl_students_register');
        $query = $this->db->get();
        return $query->result();
    }


    function student_email_confirm_get($code)
    {

        if ($code) {
            $this->db->select('tbl_students_register.*');
            $this->db->where('tbl_students_register.email_hash', $code);
            $this->db->from('tbl_students_register');

            $query = $this->db->get();
            $data = $query->result();
            $status = $data[0]->email_status;

            if ($data) {

                $this->db->where('email_hash', $code);

                if ($status === 'Verified') {
                    $this->load->view('already_verify_email_index');
                } else {

                    $data1 = array('email_status' => 'Verified');
                    $this->db->update('tbl_students_register', $data1);

                    $this->load->view('verify_email_index');

                }
            } else {
                $res = ['message' => 'email is not verified,code incorrect'];
                $this->response($res, 400);
            }
        } else {
            $res = ['message' => 'code is empty'];
            $this->response($res, 400);
        }
    }

    function studentReject_post($id)
    {
        $nic = $this->UserRegisterModel->getNICbyID($id);
        $student_details = $this->UserRegisterModel->get_registered_students($nic);
        $data = [
            'student_status' => 'Enrolled'
        ];
        $this->UserRegisterModel->approve_students($id, $data);
    }

    function ApproveStudent_post($id)
    {
        if($this->post('membership_apply') == 'true'){
            $membership_apply = 'Yes';
        } else {
            $membership_apply = 'No';
        }
        // if($this->post('status') == 'Approved'){
        //     $data = [
        //         'status' => $this->post('status')
        //     ];
        // } else {
            $data = [
                'status' => $this->post('status'),
                'membership_apply' => $membership_apply
            ];
        // }

        $this->UserRegisterModel->approveRejectStudent($id, $data);
        // $this->studentConfirm_post($id);
    }

    // fixed reject student email 
    function RejectStudent_post($id)
    {
        $remark = $this->post('remark');

        if($this->post('membership_apply') == true){
            $membership_apply = 'Yes';
        } else {
            $membership_apply = 'No';
        }
        $data = [
            'status' => 'Rejected',
            'membership_apply' => $membership_apply,
            'remark' => $remark
        ];

        $reject = $this->UserRegisterModel->approveRejectStudent($id, $data);
        if($reject) {

            $nic = $this->UserRegisterModel->getNICbyID($id);
            $student_details = $this->UserRegisterModel->get_registered_students($nic[0]->nic);
            $email = $student_details[0]->email;
            
    
            $email_content = [
                'full_name' => $student_details[0]->initials,
                'remark' => $student_details[0]->remark,
            ];

            $message = $this->load->view("email/registration_reject_email", $email_content, true);
            $this->load->library('php_mailer');
            $this->php_mailer->sendEmail($email, $cc= null, 'abc_restaurant- Student Registration Update', $message);
        } else {
            $res = ['message' => 'registration unsuccessful'];
            $this->response($res, 400);
        }
    }

    
     // fixed confirm student registration email 
    function studentConfirm_post($id)
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        $nic = $this->UserRegisterModel->getNICbyID($id);

        $student_details = $this->UserRegisterModel->get_registered_students($nic[0]->nic);
        
        $data = [
            'student_status' => 'Enrolled'
        ];
        $this->UserRegisterModel->enrol_students($id, $data);

        $email = $student_details[0]->email;
        $identity = ($identity_column === 'email') ? $email : $student_details[0]->identity;
        $password = rand(100000, 9999999);
       

        $additional_data = [
            'first_name' => $student_details[0]->full_name,
            'last_name' => $student_details[0]->last_name,
            'company' => $student_details[0]->designation,
            'username' => $nic[0]->nic,
            'phone' => $student_details[0]->mobile,
        ];

        $succ = $this->ion_auth->register($identity, $password, $email, $additional_data, true);
        

        if ($succ) {

            $email_content = [
                'student_id' => $student_details[0]->temp_student_id,
                'full_name' => $student_details[0]->full_name,
                'nic' => strtoupper($student_details[0]->nic),
                'initials' => $student_details[0]->initials,
                'password' => $password,
                'email' => $email,
            ];

            $message = $this->load->view("email/confirm_email", $email_content, true);
            $this->load->library('php_mailer');

            if ($this->php_mailer->sendEmail($email, $cc= null, 'abc_restaurant- Your Customer Login Login Details', $message)) {
                $res = [
                    'message' => 'student registered',
                ];
            } else {
                $res = [
                    'message' => 'Email sent,fail'
                ];
                $this->response($res, 400);
            }
        } else {
            

            $errors = $this->ion_auth->errors();

            // Log Ion Auth errors for debugging
            log_message('error', 'Ion Auth Registration Error: ' . json_encode($errors));

            // Respond with a more detailed error message
            $res = ['message' => 'Registration unsuccessful. ' . $errors];
            $this->response($res, 400);
        }
    }

    //get usergroup
	public function usergroup_post(){
		$mail=$this->post('identity');

		$access = $this->UserRegisterModel->checkusergroup($mail)->name;
// 		print_r($access);
// 		die();

		return $this->response($access, 200);

	}

    function getExistingSubmissions_get() {
        $all = $this->UserRegisterModel->fetch_all_submissions();
        $this->response($all, 200);
    }

    function getPendingSubmissions_get(){
        $all = $this->UserRegisterModel->fetch_all_pending_submissions();
        $this->response($all, 200);
    }

    function updatepassword_post()
    {
        // $designation = $this->post('designation');
        // $employer = $this->post('employer');
        $password = $this->post('passwordnew');
        $identity = $this->post('identity');

      

        $this->Ion_auth_model->updatepassword($identity, $password);
    }

    function getSubscription_get($id){
        $all = $this->UserRegisterModel->getSubscription($id);
        $this->response($all, 200);
    }

    function getCoursePartialPayment_get($id){
        $all = $this->UserRegisterModel->getCourcePayment($id);
        $this->response($all, 200);
    }
}
