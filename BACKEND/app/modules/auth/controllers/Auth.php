<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends RestController
{
    public $data = [];

    public function __construct()
    {
        $module = 'SystemPermissions';

        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->library(['kcrud']);
        $this->load->library(['api_auth']);
        $this->load->library(['system_log']);
        $this->load->helper(['url', 'language']);



        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');





    }

    /**
     * Redirect if needed, otherwise display the user list
     */

    public function isAuthenticate_get()
    {
        if ($this->api_auth->isNotAuthenticated()) {

            $status = false;

            $this->response($status);
        } else {
            $status = true;
            $this->response($status);
        }
    }

    public function index_get()
    {
        $module_id = 6;
        $access = $this->api_auth->checkModuleViewAccess($module_id);
        if(!($access)) {
            $err = array(
                'status' => false,
                'message' => 'you are not view access for this page',
            );
            $this->response($err, 401);
        }

        // if (!$this->ion_auth->logged_in()) {
        // 	// redirect them to the login page
        // 	//redirect('auth/login', 'refresh');
        // 	$responseData = array(
        // 		'status' => false,
        // 		'message' => 'you are not login to access this page',

        // 	);
        // 	return $this->response($responseData, 400);
        // } else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        // {
        // 	// redirect them to the home page because they must be an administrator to view this
        // 	$responseData = array(
        // 		'status' => false,
        // 		'message' => 'You must be an administrator to view this page.',

        // 	);
        // 	return $this->response($responseData, 400);
        // 	//show_error('You must be an administrator to view this page.');
        // } else {

        $this->data['title'] = $this->lang->line('index_heading');

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        //list the users
        $this->data['users'] = $this->ion_auth->users()->result();

        //USAGE NOTE - you can do more complicated queries like this
        //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();

        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }


        //  $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'index', $this->data);
        return $this->response($this->data['users'], 200);
    }
    /**
     * Log the user in
     */
    public function login_post()
    {


        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE) {

            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                $user = $this->ion_auth->user()->row();

                $userId = $this->ion_auth->get_user_id();
                // var_dump($user);
                // die();
                $user_groups = $this->ion_auth->get_users_groups($userId)->result();
                $bearerToken = $this->api_auth->generateToken($userId);
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());

                $responseData = array(
                    'status' => true,
                    'message' => $this->ion_auth->messages(),
                    'loggin' => $this->ion_auth->logged_in(),
                    'group' => $user_groups,
                    'isAdmin' => $this->ion_auth->is_admin(),
                    'token' => $bearerToken


                );

                $res = [
                    'message' => 'user login',

                ];
                $this->system_log->create_system_log('login', 'Success', $res['message'], $userId);

                return $this->response($responseData, 200);
            } else {
                $userId = $this->ion_auth->get_user_id();

                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $responseData = array(
                    'status' => false,
                    'message' => $this->ion_auth->errors(),

                );
                $res = [
                    'message' => 'user login',

                ];
                $this->system_log->create_system_log('login', 'Failed', $res['message'], $userId);
                return $this->response($responseData, 401);
                //redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            ];

            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
            ];

            $responseData = array(
                'status' => false,
                'message' => $this->data['message'],

            );
            return $this->response($responseData, 401);
            // $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
        }
    }


    public function get_user_groups_get()
    {
        $userId = $this->api_auth->getUserId();
        $user_groups = $this->ion_auth->get_users_groups($userId)->result();
        return $this->response($user_groups, 200);

    }


    /**
     * Log the user out
     */
    public function logout_post()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $this->ion_auth->logout();

        // redirect them to the login page
        $responseData = array(
            'status' => true,
            'message' => $this->ion_auth->logout(),

        );
        return $this->response($responseData, 401);
        //redirect('auth/login', 'refresh');
    }

    /**
     * Change password
     */
    public function change_password_post()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            $responseData = array(
                'status' => false,
                'message' => 'you are not login to reset password',

            );
            return $this->response($responseData, 400);
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === FALSE) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = [
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            ];
            $this->data['new_password'] = [
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['new_password_confirm'] = [
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['user_id'] = [
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            ];

            // render
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    /**
     * Forgot password
     */
    public function forgot_password()
    {
        $this->data['title'] = $this->lang->line('forgot_password_heading');

        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() === FALSE) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
            ];

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $this->data['title'] = $this->lang->line('reset_password_heading');

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE) {
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = [
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['new_password_confirm'] = [
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['user_id'] = [
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                ];
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
            } else {
                $identity = $user->{$this->config->item('identity', 'ion_auth')};

                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);

                    show_error($this->lang->line('error_csrf'));

                } else {
                    // finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = FALSE)
    {
        $activation = FALSE;

        if ($code !== FALSE) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Deactivate the user
     *
     * @param int|string|null $id The user ID
     */
    public function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() === FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();
            $this->data['identity'] = $this->config->item('identity', 'ion_auth');

            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    /**
     * Create a new user
     */
    public function create_user_post()
    {
        $module_id = 6;
        $access = $this->api_auth->checkModuleAddAccess($module_id);
        if (!($access)) {
            $err = array(
                'status' => false,
                'messgae' => 'you are not authorized for perform this action',
            );
            $this->response($err, 401);
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');

        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');

        }

        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

//		if ($this->form_validation->run() === TRUE) {

        $email = strtolower($this->input->post('email'));
        $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
        $password = $this->input->post('password');

        $additional_data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'status' => $this->input->post('status')
        ];

        if ($insert_id = $this->ion_auth->register($identity, $password, $email, $additional_data, false)) {

            // print_r($insert_id);die();
            $data_groups = array(
                'user_id'=> $insert_id,
                'group_id'=>$this->input->post('groups')
            );

            $this->kcrud->save("users_groups",$data_groups);

            $res = [
                'message' => 'user register',
            ];

            $this->system_log->create_system_log('Register users', 'Success', $res['message']);

            if ($this->input->post('groups')) {
                // $this->ion_auth->remove_from_group('', $id);

                $groupData = $this->input->post('groups');



                // if (isset($groupData) && !empty($groupData)) {
                //$groups = explode(',', $groupData);
                $data_array = json_decode($groupData, true);
                // print_r($insert_id);die();
                foreach ($data_array as $grp) {
                    $this->ion_auth->add_to_group($grp, $insert_id);
                }


                // }
            }

            return $this->response($res, 200);

        } else {
            return $this->response(400);
        }

//		} else {
//			$responseData = array(
//				'status' => false,
//				'message' => 'validation fail',
//
//
//			);
//			$res = [
//				'message' => 'user register',
//
//			];
//			$this->system_log->create_system_log('Register users', 'Failed', $res['message']);
//
//			return $this->response($responseData, 400);
//
//			//}
//		}

    }



    /**
     * Redirect a user checking if is admin
     */
    public function redirectUser()
    {
        if ($this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
        redirect('/', 'refresh');
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function edit_user_post($id)
    {
        $module_id = 6;

        $access = $this->api_auth->checkModuleUpdateAccess($module_id);
        // if (!($access)) {
        // 	$err = array(
        // 		'status' => false,
        // 		'messgae' => 'you are not authorized for perform this action',
        // 	);
        // 	$this->response($err, 401);
        // }
        //	$this->data['title'] = $this->lang->line('edit_user_heading');

        // if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
        // 	redirect('auth', 'refresh');
        // }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result_array();
        $identity_column = $this->config->item('identity', 'ion_auth');
        $tables = $this->config->item('tables', 'ion_auth');
        //USAGE NOTE - you can do more complicated queries like this
        //$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();


        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_phone_label'), 'trim');
        // $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            // if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
            // 	show_error($this->lang->line('error_csrf'));

            // }

            // print_r($this->input->post('password'));die();

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($identity_column !== 'email') {
                // $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');

            } else {
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');

            }

//			if ($this->form_validation->run() === TRUE) {
            $data = [
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'company' => $this->input->post('company'),
                'active' => $this->input->post('status'),

            ];

            // update the password if it was posted
            if ($this->input->post('password')) {
                if($this->input->post('password')==$this->input->post('password_confirm')){
                    $data['password'] = $this->input->post('password');
                }
                else{
                    return $this->response(null, 500);
                }

            }

            // Only allow updating groups if user is admin
            if ($this->ion_auth->is_admin()) {
                // Update the groups user belongs to
                if ($this->input->post('groups')) {
                    // $this->ion_auth->remove_from_group('', $id);

                    $groupData = $this->input->post('groups');



                    if (isset($groupData) && !empty($groupData)) {
                        //$groups = explode(',', $groupData);
                        $data_array = json_decode($groupData, true);

                        foreach ($data_array as $grp) {

                            $this->ion_auth->add_to_groupup($grp, $id);
                        }


                    }
                }

            }

            // check to see if we are updating the user
            if ($this->ion_auth->update($user->id, $data)) {
                //echo 'hi group';
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                //echo 'hi group';
                // $this->redirectUser();
                $responseData = array(
                    'status' => true,
                    'message' => 'user updated!',

                );
                $res = [
                    'message' => 'user update',

                ];
                $this->system_log->create_system_log('Register users update', 'Success', $res['message']);
                //2023-01-07
                $groupData = $this->input->post('groups');
                $this->ion_auth->add_to_groupup($groupData,$id);
                return $this->response($responseData, 200);

            } else {
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                //$this->redirectUser();
                $responseData = array(
                    'status' => false,
                    'message' => 'user not updated!',

                );
                $res = [
                    'message' => 'Users Update',

                ];
                $this->system_log->create_system_log('Register users update', 'Failed', $res['message']);
                return $this->response($responseData, 400);
            }

//			} else {
//				$responseData = array(
//					'status' => false,
//					'message' => 'validation fails!',
//
//				);
//				return $this->response($responseData, 400);
//			}

        } else {
            $responseData = array(
                'status' => false,
                'message' => 'empty fields!',
            );
            return $this->response($responseData, 400);
        }
    }
    /**
     * Create a new group
     */
    public function create_group_post()
    {
        $module_id = 6;
        $access = $this->api_auth->checkModuleAddAccess($module_id);
        if (!($access)) {
            $err = array(
                'status' => false,
                'messgae' => 'you are not authorized for perform this action',
            );
            $this->response($err, 401);
        }
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

        if ($this->form_validation->run() === TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
            }
        }

        // display the create group form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['group_name'] = [
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name'),
        ];
        $this->data['description'] = [
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
        ];

        $this->_render_page('auth/create_group', $this->data);

    }
    // public function get_all_groups_get()
    // {
    // 	$groupList = $this->ion_auth->groups()->result();


    // 	return $this->response($groupList, 200);
    // }

    /**
     * Edit a group
     *
     * @param int|string $id
     */
    public function edit_group_post($id)
    {
        $module_id = 6;

        $access = $this->api_auth->checkModuleUpdateAccess($module_id);
        if (!($access)) {
            $err = array(
                'status' => false,
                'messgae' => 'you are not authorized for perform this action',
            );
            $this->response($err, 401);
        }
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {

            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group(
                    $id, $_POST['group_name'],
                    array(
                        'description' => $_POST['group_description']
                    )
                );

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                    redirect("auth", 'refresh');
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $this->data['group_name'] = [
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
        ];
        if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
            $this->data['group_name']['readonly'] = 'readonly';
        }

        $this->data['group_description'] = [
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        ];

        $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return [$key => $value];
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @param string     $view
     * @param array|null $data
     * @param bool       $returnhtml
     *
     * @return mixed
     */
    public function _render_page($view, $data = NULL, $returnhtml = FALSE) //I think this makes more sense
    {

        $viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $viewdata, $returnhtml);

        // This will return html on 3rd argument being true
        if ($returnhtml) {
            return $view_html;
        }
    }

}
