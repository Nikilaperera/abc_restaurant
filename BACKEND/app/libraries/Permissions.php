<?php
/**
 * Created by PhpStorm.
 * User: S.Priyadarshan
 * Date: 27-Jun-16
 * Time: 12:05 PM
 */
?>
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Permissions
 *
 * Implementation by S.Priyadarshan
 *
 * @package    CodeIgniter
 * @subpackage libraries
 * @category   library
 * @version    1.0 <beta>
 * @author     S.Priyadarshan
 */
class Permissions
{
    public function __construct()
    {
        $this->load->library('ion_auth');
        $this->load->model('permissions_mod');
    }
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function check_permission($method = TRUE)
    {
        // If the 2nd parameter ($method) is false, then it will look for the index function in the db.
        // (Useful for check permission for the whole controller)
        // All AJAX requests will look for index
        if($this->input->is_ajax_request() || !$method)
        {
            $path_name = $this->router->module."/".$this->router->class . "/" . "index";
        }
        else
        {
            $path_name = $this->router->module."/".$this->router->class . "/" . $this->router->method;
        }

        $permission = 'access_permission'; // 'access_permission', 'add_permission', 'edit_permission', 'delete_permission' columns in `master_permissions` table in DB
        //$permission = $for . '_permission'; // 'access_permission', 'add_permission', 'edit_permission', 'delete_permission' columns in `master_permissions` table in DB
        $where = array("auth_system_modules.path" => $path_name, "auth_system_permissions.$permission" => 'YES');
        $permitted_users = $this->permissions_mod->check_permission($where);
        if (!$this->permissions_mod->in_user_has_permisson($permitted_users))
        {
            if($this->input->is_ajax_request())
            {
                echo json_encode(array('status' => FALSE, 'message' => "You are not authorized to perform this action."));
                exit;
            }

            $this->session->set_userdata('message', "Access Denied");
            redirect('/', 'refresh');
        }
    }
}
/* End of file Permissions.php */
/* Location: ./app/libraries/Permissions.php */