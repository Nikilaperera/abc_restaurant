<?php

$this->load->model('permissions_mod');
$this->load->library('kcrud');
$current_user = $this->session->userdata('user_id');

?>

<ul id="sidebarnav" class="main-menu">
    <li class="">
        <a href="<?php echo base_url('dashboard'); ?>">
            <div class="icon-w">
                <div class="icon-speedometer"></div>
            </div>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- get active main modules -->
    <?php
    $where="";
    $join="";

    if($current_user ==1){
        $where="WHERE access_permission='YES' AND auth_system_module_sections.status=1";
    }
    else{
        $where="WHERE access_permission='YES' AND auth_system_module_sections.status=1 AND auth_system_permissions.user_id=".$current_user;
    }

    $join="JOIN auth_system_modules ON auth_system_modules.id=auth_system_permissions.module_id JOIN auth_system_module_sections ON auth_system_module_sections.id=auth_system_modules.section";
    foreach($this->kcrud->getValueAll("auth_system_permissions","auth_system_module_sections.id,auth_system_module_sections.title,auth_system_module_sections.icon,auth_system_permissions.module_id",$where,null,$join,"GROUP BY auth_system_modules.section","ORDER BY auth_system_modules.section ASC") as $main1){

        ?>
        <li class="has-arrow has-sub-menu">
            <a href="javascript:;">
                <div class="icon-w">
                    <div class="<?php echo $main1->icon; ?>"></div>
                </div>
                <span><?php echo ucfirst(strtolower($main1->title)); ?></span>
            </a>
                 <div class="sub-menu-w <?php echo ucfirst(strtolower($main1->title)); ?>" >

                <div class="sub-menu-i">
                    <?php

                    $where1="";
                    $join1="";

                    if($current_user ==1){
                        $where1="WHERE auth_system_module_sections.id=".$main1->id." AND access_permission='YES' AND auth_system_modules.status='Enabled'";
                    }
                    else{
                        $where1="WHERE auth_system_module_sections.id=".$main1->id." AND access_permission='YES' AND auth_system_modules.status='Enabled' AND auth_system_permissions.user_id=".$current_user;
                    }

                    $join1="JOIN auth_system_modules ON auth_system_modules.id=auth_system_permissions.module_id JOIN auth_system_module_sections ON auth_system_module_sections.id=auth_system_modules.section";
                    $menus=$this->kcrud->getValueAll("auth_system_permissions","auth_system_modules.id,auth_system_modules.name,auth_system_modules.icon,auth_system_modules.path",$where1,null,$join1,"GROUP BY auth_system_permissions.module_id","ORDER BY auth_system_modules.order ASC");

                    $arr_menu=array_chunk($menus,6);

                    foreach($arr_menu as $sub1){
                        ?>
                        <ul class="sub-menu">
                            <?php
                            foreach($sub1 as $sub2){

                                if($this->permissions_mod->chk_module_permisson_data($sub2->path, $current_user)){

                                    $exp_url=explode("/",$sub2->path);

                                    ?>
                                    <li>
                                        <a href="<?php echo base_url($sub2->path); ?>" style="<?php if ($this->uri->segment(3) == $exp_url[2] && $this->uri->segment(2) == $exp_url[1]){ ?>background: #0b97c4; <?php } ?>">
                                            <i class="<?php echo $sub2->icon; ?>"></i> <?php $exp = explode("-", $sub2->name);
                                            echo ltrim($exp[1], " "); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </li>
    <?php }?>

    <!--TODO ~~~~~Techpack~~only-->
    <?php $groups_emp=array('employee_user'); if ($this->ion_auth->in_group($groups_emp)){ ?>
        <?php $path = "salary_settings_con/get_payslips";
        if ($this->permissions_mod->chk_module_permisson_data($path, $current_user)) { ?>
            <li class="<?php if ($this->uri->segment(2) == "get_payslips") { echo 'active'; } ?>">
                <a class="waves-effect waves-dark"  href="<?php echo base_url('hr_payroll/salary_settings_con/get_payslips'); ?>">
                    <i class="fa fa-calendar-check-o"></i> <span  class="hide-menu"> Pay Slips </span>
                </a>
            </li>
        <?php } ?>
        <?php $path = "leave_self_management/index";
        if ($this->permissions_mod->chk_module_permisson_data($path, $current_user)) { ?>
            <li class="<?php if ($this->uri->segment(2) == "leave_self_management") { echo 'active'; } ?>">
                <a class="waves-effect waves-dark"  href="<?php echo base_url('hr_payroll/leave_self_management'); ?>">
                    <i class="fa fa-calendar-check-o"></i> <span  class="hide-menu"> Self Leave Management </span>
                </a>
            </li>
        <?php } ?>

        <?php $path = "hr_pay_reports/emp_attendance_details";
        if ($this->permissions_mod->chk_module_permisson_data($path, $current_user)) { ?>
            <li class="<?php if ($this->uri->segment(3) == "emp_attendance_details") { echo 'active'; } ?>">
                <a class="waves-effect waves-dark"  href="<?php echo base_url('reports/hr_pay_reports/emp_attendance_details'); ?>"><i class="fa fa-table"></i><span  class="hide-menu"> Employee Attendance Report</span></a>
            </li>
        <?php } ?>
        <?php if(PROJECTS!=0) { ?>
            <?php $path = "project_reports/projects_summary";
            if ($this->permissions_mod->chk_module_permisson_data($path, $current_user)) { ?>
                <li class="<?php if ($this->uri->segment(3) == "projects_summary") { echo 'active'; } ?>">
                    <a class="waves-effect waves-dark"  href="<?php echo base_url('reports/project_reports/projects_summary'); ?>"><i class="fa fa-table"></i><span  class="hide-menu"> Projects Report</span></a>
                </li>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</ul>