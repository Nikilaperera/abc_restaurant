<?php

?>
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class System_log
{
    public function __construct()
    {
        $this->load->library('ion_auth');
        $this->load->library('Api_auth');
        $this->load->model('System_log_mod');
        date_default_timezone_set("Asia/Colombo");
        $this->current_time = date('Y-m-d H:i:s');
    }
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function create_system_log($action, $status, $log_message, $user_id = null)
    {
        $current_user_id = $user_id == null ?$this->api_auth->getUserId() : $user_id;
        $admin_log = array(
            'user_id' => $current_user_id,
            'date_time' => $this->current_time,
            'ip_address' => $this->input->ip_address(),
            'action' => $action,
            'status' => $status,
            'log_message' => $log_message
        );
        // var_dump($admin_log);
        // die();
        $this->System_log_mod->create_system_log($admin_log);
    }
}
