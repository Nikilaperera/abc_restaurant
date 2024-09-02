<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  edit_column callback function in Codeigniter (Ignited Datatables)
 *
 * Grabs a value from the edit_column field for the specified field so you can
 * return the desired value.
 *
 * @access   public
 * @return   mixed
 */

if ( ! function_exists('check_status'))
{
    function check_status($status = '')
    {
        if($status=="Completed"){
            return "<span class='label label-success'>".$status."</span>";
        }else {
            return "<span class='label label-warning'>".$status."</span>";
        }

    }

}

/* End of file MY_datatable_helper.php */
/* Location: ./application/helpers/MY_datatable_helper.php */