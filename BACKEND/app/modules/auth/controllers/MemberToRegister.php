<?php


defined('BASEPATH') or exit('No direct script access allowed');

class MemberToRegister extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MemberToRegisterMod');
        $this->load->model('UserRegisterModel');
        $this->load->model('Ion_auth_model');
        $this->load->database();

        $this->load->library('ion_auth');
        $this->load->library('api_auth');
        $this->load->library('email');
        $this->load->library(['system_log']);

    }

    public function onboard($password){

        if($password == 2323723349234343443){

            //get member data
            $members=$this->MemberToRegisterMod->getValueAll("tbl_member_info","*","WHERE tbl_member_info.onboard=0",null,null,null,"ORDER BY id DESC LIMIT 500");

            $send_count = 0;
            $fail_count = 0;
            foreach ($members as $member){

                //check duplicate register
                if(!$this->MemberToRegisterMod->getValueOne("tbl_students_register","*","WHERE nic='".$member->nic."'",null,null,null,null)) {

                    $lastTempId = $this->UserRegisterModel->getTempId('abc_restaurant-REG' . date("Y"))->temp_student_id;
                    $lastId = (int)substr($lastTempId,13);

                    $temp_student_id = "abc_restaurant-REG" . date("Y") . '-' . (str_pad($lastId + 1, 7, "0", STR_PAD_LEFT));

                    $gender = $member->gender;
                    if ($member->gender != "Male" || $member->gender != "Female") {
                        $gender = "Male";
                    }

                    //generate email hash
                    $email = $member->email;
                    $email_hash = $this->Ion_auth_model->hash_password($email);
                    $email_hash = rand(100000,100000000).str_replace('/', '', $email_hash);
                    $email_hash = rand(1000,100000).str_replace('$', '', $email_hash);

                    $data = array(
                        'temp_student_id' => $temp_student_id,
                        'title' => $member->title,
                        'initials' => $member->initials,
                        'first_name' => $member->first_name,
                        'middle_name' => $member->middle_name,
                        'last_name' => $member->last_name,
                        'full_name' => $member->full_name,
                        'registration_type' => 'Local',
                        'district' => $member->district,
                        'country' => $member->country,
                        'birthday' => $member->birthday,
                        'civil_status' => 'Single',
                        'gender' => $gender,
                        'nic' => $member->nic,
                        'telephone' => $member->telephone,
                        'mobile' => $member->mobile,
                        'medium' => $member->medium,
                        'email' => $member->email,
                        'address1' => $member->address1,
                        'address2' => $member->address2,
                        'address3' => $member->address3,
                        'postal_code' => "-",
                        'designation' => $member->designation,
                        'attachment_nic' => "-",
                        'attachment_qualification1' => "-",
                        'attachment_confirmation' => "-",
                        'attachment_photograph' => "-",
                        'attachment_qualification2' => "-",
                        'student_status' => "Pending",
                        'status' => "Approved",
                        'pay_status' => "Payment Completed",
                        'created_at' => $member->registered_date,
                        'updated_at' => $member->registered_date,
                        'remark' => "-",
                        'email_hash' => $email_hash,
                        'email_status' => "Verified",
                        'membership_apply' => "Yes",
                        'member_id' => $member->member_id,
                        'lead_student' => "No",
                        'migrated' => 2
                    );

                    //insert to register table
                    if ($insert_id=$this->MemberToRegisterMod->save("tbl_students_register", $data)){


                        $tables = $this->config->item('tables', 'ion_auth');
                        $identity_column = $this->config->item('identity', 'ion_auth');
                        $this->data['identity_column'] = $identity_column;

                        $nic = $this->UserRegisterModel->getNICbyTableID($insert_id);

                        $student_details = $this->UserRegisterModel->get_registered_students($nic);
                        $data = [
                            'student_status' => 'Enrolled'
                        ];
                        $this->UserRegisterModel->enrol_students($insert_id, $data);

                        $email = $student_details->email;
                        $identity = ($identity_column === 'email') ? $email : $student_details->identity;
                        $password = rand(100000, 9999999);

                        $additional_data = [
                            'first_name' => $student_details->full_name,
                            'last_name' => $student_details->last_name,
                            'company' => $student_details->designation,
                            'username' => $nic,
                            'phone' => $student_details->mobile,
                        ];
                        $succ = $this->ion_auth->register($identity, $password, $email, $additional_data, true);

                        if ($succ) {

                            $email_content = [
                                'student_id' => $student_details->temp_student_id,
                                'member_id' => $student_details->member_id,
                                'full_name' => $student_details->full_name,
                                'nic' => strtoupper($student_details->nic),
                                'initials' => $student_details->initials,
                                'created_at' => date("d F Y"),
                                'password' => $password,
                                'email' => $email,
                            ];

                            $message = $this->load->view("email/onboard_email", $email_content, true);
                            $this->load->library('php_mailer');

                            if($this->php_mailer->sendEmail($email, $cc= null, 'Student Membership Registration & Myabc_restaurant Credentials', $message)) {
                                $send_count++;
                            } else {
                                $fail_count++;
                                $error_data = array(
                                    'member_id' => $member->member_id,
                                    'nic' => $member->nic,
                                    'remark' => 'Duplicate Email Address'
                                );

                                $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
                            }
                        } else {
                            $fail_count++;
                            $error_data = array(
                                'member_id' => $member->member_id,
                                'nic' => $member->nic,
                                'remark' => 'Duplicate Email Address'
                            );

                            $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
                        }

                    } else {

                        $fail_count++;
                        $error_data = array(
                            'member_id' => $member->member_id,
                            'nic' => $member->nic,
                            'remark' => 'Not Insert !',
                            'migrated'=>2
                        );

                        $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
                    }

                }
                else {

                    $fail_count++;
                    $error_data = array(
                        'member_id' => $member->member_id,
                        'nic' => $member->nic,
                        'remark' => 'Duplicate NIC !',
                        'migrated'=>2
                    );

                    $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
                }

                //update onboard status
                $update_data = array(
                    'onboard' => 2
                );

                $this->MemberToRegisterMod->update("tbl_member_info", $update_data,array('id'=>$member->id));

            }
            //get send and failed count
            echo "Successfully Sent !. SEND COUNT: ".$send_count." | FAILED COUNT :".$fail_count;
        }

    }

    public function send_email(){

        $this->load->view('send_email_index');
    }

    public function search_student_info() {

        $response="";
        $val = $this->input->post();
        $identity = $val['identity'];
        //get student registration info using nic or email
        if($student_info = $this->MemberToRegisterMod->getValueOne("tbl_students_register","*","WHERE member_id='".$identity."' OR nic='".$identity."'",null,null,null,null)){
            $response = array('data' => $student_info,'status'=>true);
        }
        else{
            $response = array('data' => "No data Found !",'status'=>false);
        }

//        $response = array('status' => 'success', 'message' => 'Form submitted successfully');

        echo json_encode($response);
    }

    public function create_student_account() {

        $response="";
        $val = $this->input->post();
        $insert_id=$val['member_id'];

//        //update member info
        $update_data=array(
//            'nic'=>$val['nic'],
            'email'=>$val['email'],
//            'mobile'=>$val['mobile']
        );
//
//        //

        if($val['nic'] !='-' && $val['nic'] !='0' && $val['nic'] != NULL) {
            $this->MemberToRegisterMod->update("tbl_member_info", $update_data, array('nic' => $val['nic']));
            $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('nic' => $val['nic']));


            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;

            $nic = $val['nic'];

            $student_details = $this->MemberToRegisterMod->get_registered_students($nic);

            $data = [
                'student_status' => 'Enrolled'
            ];
            $this->UserRegisterModel->enrol_students($insert_id, $data);

            if ($this->MemberToRegisterMod->getValueOne("users", "*", "WHERE username='" . $student_details->nic . "'", null, null, null, null)) {

                //update onboard status
                $update_data = array(
                    'onboard' => 3
                );

                $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('id' => $student_details->id));
                echo json_encode(array('status' => false, 'message' => 'Already Exists1 !'));

            } else {
//generate email hash
                $email = $student_details->email;
                $email_hash = $this->Ion_auth_model->hash_password($email);
                $email_hash = rand(100000, 100000000) . str_replace('/', '', $email_hash);
                $email_hash = rand(1000, 100000) . str_replace('$', '', $email_hash);

                $tables = $this->config->item('tables', 'ion_auth');
                $identity_column = $this->config->item('identity', 'ion_auth');
                $this->data['identity_column'] = $identity_column;

                $identity = $val['email'];
                $password = rand(100000, 9999999);

                $additional_data = [
                    'first_name' => $student_details->full_name,
                    'last_name' => $student_details->last_name,
                    'company' => $student_details->designation,
                    'username' => $student_details->nic,
                    'phone' => $student_details->mobile,
                ];

                $succ = $this->ion_auth->register($identity, $password, $val['email'], $additional_data, true);

                if ($succ) {

                    $email_content = [
                        'student_id' => $student_details->temp_student_id,
                        'member_id' => $student_details->member_id,
                        'full_name' => $student_details->full_name,
                        'nic' => strtoupper($student_details->nic),
                        'initials' => $student_details->full_name,
                        'created_at' => date("d F Y"),
                        'password' => $password,
                        'email' => $val['email'],
                    ];

                    $message = $this->load->view("email/onboard_email", $email_content, true);
                    $this->load->library('php_mailer');

                    $this->php_mailer->sendEmail($email, $cc = null, 'Myabc_restaurant- Your Student Portal Login Details', $message);

                    //update onboard status
                    $update_data = array(
                        'onboard' => 2
                    );

                    $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('id' => $student_details->id));

                    echo json_encode(array('status' => true, 'message' => 'Successfully Added !'));
                } else {

                    //update onboard status
                    $update_data = array(
                        'onboard' => 1
                    );

                    $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('id' => $student_details->id));
                    echo json_encode(array('status' => false, 'message' => 'Error !'));
                }

            }
        }
    }



    public function reset_student_account() {

        $response="";
        $val = $this->input->post();
        $insert_id=$val['nic'];

        //update member info
        $update_data=array(
            'email'=>$val['email'],
//            'mobile'=>$val['mobile']
        );

        //
        if($val['nic'] !='-' && $val['nic'] !='0' && $val['nic'] != NULL) {

            $this->MemberToRegisterMod->update("tbl_member_info", $update_data, array('nic' => $val['nic']));
            $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('nic' => $val['nic']));

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;

            $nic = $val['nic'];

            $student_details = $this->MemberToRegisterMod->get_registered_students($nic);

            $email = $student_details->email;
            $identity = ($identity_column === 'email') ? $email :$nic;
            $password = rand(100000, 9999999);

            $success = $this->ion_auth->reset_password($identity, $password);


            if ($success) {

                $email_content = [
                    'student_id' => $student_details->temp_student_id,
                    'full_name' => $student_details->full_name,
                    'nic' => strtoupper($student_details->nic),
                    'initials' => $student_details->initials,
                    'password' => $password,
                    'email' => $email,
                ];

                $message = $this->load->view("email/onboard_email", $email_content, true);
                $this->load->library('php_mailer');

                if ($message = $this->php_mailer->sendEmail($email, $cc = null, 'Myabc_restaurant- Reset Your Student Portal Login Details', $message)) {
                    echo json_encode(array('status' => true, 'message' => $message));
                }

            } else {
                echo json_encode(array('status' => false, 'message' => 'Already Exist!'));
            }
        }
    }

//    public function create_student_account_with_member_info(){
//
//        $val = $this->input->post();
//        $member_id = $this->input->post('member_id');
//
//        //update member info
//        $update_data=array(
//            'nic'=>$val['nic'],
//            'email'=>$val['email'],
//            'mobile'=>$val['mobile']
//        );
//
//        //
//        $this->MemberToRegisterMod->update("tbl_member_info", $update_data,array('member_id'=>$val['member_id']));
//        $this->MemberToRegisterMod->update("tbl_students_register", $update_data,array('member_id'=>$val['member_id']));
//
//        //get member data
//        $member=$this->MemberToRegisterMod->getValueOne("tbl_member_info","*","WHERE tbl_member_info.onboard=0 AND member_id='".$member_id."'",null,null,null,null);
//
//        $send_count = 0;
//        $fail_count = 0;
//        $message="";
//
//        //check duplicate register
//        if(!$this->MemberToRegisterMod->getValueOne("tbl_students_register","*","WHERE nic='".$member->nic."' OR email='".$member->email."'",null,null,null,null)) {
//
//            $lastTempId = $this->UserRegisterModel->getTempId('abc_restaurant-REG' . date("Y"))->temp_student_id;
//            $lastId = (int)substr($lastTempId,13);
//
//            $temp_student_id = "abc_restaurant-REG" . date("Y") . '-' . (str_pad($lastId + 1, 7, "0", STR_PAD_LEFT));
//
//            $gender = $member->gender;
//            if ($member->gender != "Male" || $member->gender != "Female") {
//                $gender = "Male";
//            }
//
//            //generate email hash
//            $email = $member->email;
//            $email_hash = $this->Ion_auth_model->hash_password($email);
//            $email_hash = rand(100000,100000000).str_replace('/', '', $email_hash);
//            $email_hash = rand(1000,100000).str_replace('$', '', $email_hash);
//
//            $data = array(
//                'temp_student_id' => $temp_student_id,
//                'title' => $member->title,
//                'initials' => $member->initials,
//                'first_name' => $member->first_name,
//                'middle_name' => $member->middle_name,
//                'last_name' => $member->last_name,
//                'full_name' => $member->full_name,
//                'registration_type' => 'Local',
//                'district' => $member->district,
//                'country' => $member->country,
//                'birthday' => $member->birthday,
//                'civil_status' => 'Single',
//                'gender' => $gender,
//                'nic' => $member->nic,
//                'telephone' => $member->telephone,
//                'mobile' => $member->mobile,
//                'medium' => $member->medium,
//                'email' => $member->email,
//                'address1' => $member->address1,
//                'address2' => $member->address2,
//                'address3' => $member->address3,
//                'postal_code' => "-",
//                'designation' => $member->designation,
//                'attachment_nic' => "-",
//                'attachment_qualification1' => "-",
//                'attachment_confirmation' => "-",
//                'attachment_photograph' => "-",
//                'attachment_qualification2' => "-",
//                'student_status' => "Pending",
//                'status' => "Approved",
//                'pay_status' => "Payment Completed",
//                'created_at' => $member->registered_date,
//                'updated_at' => $member->registered_date,
//                'remark' => "-",
//                'email_hash' => $email_hash,
//                'email_status' => "Verified",
//                'membership_apply' => "Yes",
//                'lead_student' => "No",
//                'migrated' => 2
//            );
//
//            //insert to register table
//            if ($insert_id=$this->MemberToRegisterMod->save("tbl_students_register", $data)){
//
//
//                $tables = $this->config->item('tables', 'ion_auth');
//                $identity_column = $this->config->item('identity', 'ion_auth');
//                $this->data['identity_column'] = $identity_column;
//
//                $nic = $this->UserRegisterModel->getNICbyID($insert_id);
//
//                $student_details = $this->UserRegisterModel->get_registered_students($nic);
//                $data = [
//                    'student_status' => 'Enrolled'
//                ];
//                $this->UserRegisterModel->enrol_students($insert_id, $data);
//
//                $email = $student_details->email;
//                $identity = ($identity_column === 'email') ? $email : $student_details->identity;
//                $password = rand(100000, 9999999);
//
//                $additional_data = [
//                    'first_name' => $student_details->full_name,
//                    'last_name' => $student_details->last_name,
//                    'company' => $student_details->designation,
//                    'username' => $nic,
//                    'phone' => $student_details->mobile,
//                ];
//                $succ = $this->ion_auth->register($identity, $password, $email, $additional_data, true);
//
//                if ($succ) {
//
//                    $email_content = [
//                        'student_id' => $student_details->temp_student_id,
//                        'full_name' => $student_details->full_name,
//                        'nic' => strtoupper($student_details->nic),
//                        'initials' => $student_details->initials,
//                        'password' => $password,
//                        'email' => $email,
//                    ];
//
//                    $message = $this->load->view("email/onboard_email", $email_content, true);
//                    $this->load->library('php_mailer');
//
//                    if($this->php_mailer->sendEmail($email, $cc= null, 'Myabc_restaurant- Your Student Portal Login Details', $message)) {
//                        $send_count++;
//                        $message = "Success !";
//                    } else {
//                        $fail_count++;
//                        $error_data = array(
//                            'member_id' => $member->member_id,
//                            'nic' => $member->nic,
//                            'remark' => 'Duplicate Email Address'
//                        );
//
//                        $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
//                        $message = "Duplicate Email Address";
//                    }
//                } else {
//                    $fail_count++;
//                    $error_data = array(
//                        'member_id' => $member->member_id,
//                        'nic' => $member->nic,
//                        'remark' => 'Duplicate Email Address'
//                    );
//
//                    $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
//                    $message = "Duplicate Email Address";
//                }
//
//            } else {
//
//                $fail_count++;
//                $error_data = array(
//                    'member_id' => $member->member_id,
//                    'nic' => $member->nic,
//                    'remark' => 'Not Insert !',
//                    'migrated'=>2
//                );
//
//                $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
//
//                $message = "Not Insert !";
//            }
//
//        }
//        else {
//
//            $fail_count++;
//            $error_data = array(
//                'member_id' => $member->member_id,
//                'nic' => $member->nic,
//                'remark' => 'Duplicate NIC !',
//                'migrated'=>2
//            );
//
//            $this->MemberToRegisterMod->save("tbl_error_register", $error_data);
//            $message = "Already Exist !";
//        }
//
//        //update onboard status
//        $update_data = array(
//            'onboard' => 2
//        );
//
//        $this->MemberToRegisterMod->update("tbl_member_info", $update_data,array('id'=>$member->id));
//
//        echo json_encode(array('status'=>true,'message'=>$message));
//    }


    public function register_to_users($password)
    {

        if ($password == 2323723349234343443) {

            //get member data
            $students = $this->MemberToRegisterMod->getValueAll("tbl_students_register", "*", "WHERE tbl_students_register.onboard=0 AND status='Approved'", null, null, null, "ORDER BY id DESC LIMIT 1000");

            foreach ($students as $student) {

                if($this->MemberToRegisterMod->getValueOne("users","*","WHERE username='".$student->nic."' OR email='".$student->email."'",null,null,null,null)) {

                    //update onboard status
                    $update_data = array(
                        'onboard' => 3
                    );

                    $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('id' => $student->id));

                }
                else{

                    //generate email hash
                    $email = $student->email;
                    $email_hash = $this->Ion_auth_model->hash_password($email);
                    $email_hash = rand(100000, 100000000) . str_replace('/', '', $email_hash);
                    $email_hash = rand(1000, 100000) . str_replace('$', '', $email_hash);

                    $tables = $this->config->item('tables', 'ion_auth');
                    $identity_column = $this->config->item('identity', 'ion_auth');
                    $this->data['identity_column'] = $identity_column;

                    $identity = $email;
                    $password = rand(100000, 9999999);

                    $additional_data = [
                        'first_name' => $student->full_name,
                        'last_name' => $student->last_name,
                        'company' => $student->designation,
                        'username' => $student->nic,
                        'phone' => $student->mobile,
                    ];

                    if($this->ion_auth->register($identity, $password, $email, $additional_data, true)) {

                        $email_content = [
                            'student_id' => $student->temp_student_id,
                            'member_id' => $student->member_id,
                            'full_name' => $student->full_name,
                            'nic' => strtoupper($student->nic),
                            'initials' => $student->full_name,
                            'created_at' => date("d F Y"),
                            'password' => $password,
                            'email' => $email,
                        ];

                        $message = $this->load->view("email/onboard_email", $email_content, true);
                        $this->load->library('php_mailer');

                        $this->php_mailer->sendUserCredentials($email, $cc = null, 'Myabc_restaurant- Your Student Portal Login Details', $message);

                        //update onboard status
                        $update_data = array(
                            'onboard' => 2
                        );

                        $this->MemberToRegisterMod->update("tbl_students_register", $update_data, array('id' => $student->id));
                    }
                }
                sleep(1);
            }
        }

        //get send and failed count
        echo "Successfully Sent !.";
    }

}
