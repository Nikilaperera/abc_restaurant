<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php if (isset($page_title)) { echo $page_title;} ?> | Arrow HRMS - Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/node_modules/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/node_modules/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/node_modules/bootstrap-duallistbox-4/dist/bootstrap-duallistbox.min.css" rel="stylesheet" type="text/css" />
    <!--V2-->
    <link href="<?php echo base_url(); ?>assets/css/custom_2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/icon_fonts_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/icon_fonts_assets/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/icon_fonts_assets/dripicons/webfont.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/dist/jquery.min.js"></script>
    <?php

    ?>
   <style>
        <?php if(COLOR_THEME!="" && BT_COLOR!="" && MENU_H_COLOR!=""){ ?>
        .top-bar.color-scheme-dark{
            background: <?php echo COLOR_THEME; ?> !important;
        }

        .cta-w.purple {
            background-image: url("<?php echo base_url(); ?>assets/img/cta-pattern-light.png"), -webkit-gradient(linear, left top, left bottom, from(<?php echo COLOR_THEME; ?>), to(<?php echo BT_COLOR; ?>));
            background-image: url("<?php echo base_url(); ?>assets/img/cta-pattern-light.png"), linear-gradient(-180deg, <?php echo COLOR_THEME; ?> 0%, <?php echo BT_COLOR; ?> 100%);
            background-size: cover;
            color: #fff;
        }
        .top-bar .logged-user-w .logged-user-menu {
            background: <?php echo BT_COLOR; ?>;
        }
        .page-head-title-wrap {
            background-color: <?php echo BT_COLOR; ?> !important;
        }

        .modal-header {
            background: <?php echo BT_COLOR; ?> !important;
        }
        .modal-title {
            color:#fff;
        }
        .modal-backdrop.show {
            opacity: 0.6;
        }
        .modal-backdrop {
            background-color: <?php echo COLOR_THEME; ?>;
        }
        .label_new_append {
            background:<?php echo COLOR_THEME; ?>; color:#fff; padding:0.2rem 0.5rem;display: inline-block;
        }
        /*.form-control {
            border: 1px solid <?php echo COLOR_THEME; ?>  !important;
        }
        input[type="text"], select, textarea {
            border: 1px solid <?php echo COLOR_THEME; ?> !important;
        }*/

        .menu-mobile.color-scheme-dark {
            background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo COLOR_THEME; ?>), to(<?php echo MENU_H_COLOR; ?>));
            background-image: linear-gradient(to bottom, <?php echo COLOR_THEME; ?> 0%, <?php echo MENU_H_COLOR; ?> 100%);
            background-repeat: repeat-x;
            background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo COLOR_THEME; ?>), to(<?php echo MENU_H_COLOR; ?>));
            background-image: linear-gradient(to bottom, <?php echo COLOR_THEME; ?> 0%, <?php echo MENU_H_COLOR; ?> 100%);
        }

        .menu-mobile .mm-logo-buttons-w .mm-logo img {
            width: auto !important;
            height: 55px !important;
        }

        .menu-w.sub-menu-style-over.sub-menu-color-bright ul.main-menu > li.active > a {
            background-color: <?php echo MENU_H_COLOR; ?>;
        }

        .menu-w ul.main-menu > li .icon-w {
            color: <?php echo MENU_H_COLOR; ?>;
        }
        .menu-w.sub-menu-style-over .sub-menu-w {
            background-color: <?php echo MENU_H_COLOR; ?>;
        }
        <?php } ?>
    </style>
</head>
<body class="menu-position-top full-screen with-content-panel"   onload="startTime()">
<!--<body class="menu-position-side menu-side-left full-screen"   onload="startTime()">-->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Arrow HRMS</p>
    </div>
</div>
<div class="all-wrapper solid-bg-all">
    <div class="layout-w">
        <div class="top-bar color-scheme-dark">
            <div class="logo-w">
                <a class="logo" href="#">
                    <?php
                    if(COMPANY_LOGO!="") {
                        $logo = "uploads/logo/".COMPANY_LOGO;
                    } else {
                        $logo = "assets/images/logo.png";
                    }
                    ?>
                    <img src="<?php echo base_url().$logo; ?>" class="light-logo" alt="homepage" style="height: 55px" />
                </a>
            </div>
            <div class="top-menu-controls">
                <div id="clockdate" style="margin-right: 10px">
                    <div class="clockdate-wrapper" style="color: #fff">
                        <div id="clock-head"></div>
                        <div id="date-head"></div>
                        <?php 
                        //$groups_emp = array('payroll');
                       // if($this->ion_auth->in_group($groups_emp)){

                            if($this->session->userdata('payroll_name')){
                                echo $this->session->userdata('payroll_name');
                            }
                            else{
                                echo 'Main Payroll';
                            }
                        // }
                        ?>
                    </div>
                </div>


                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;text-decoration: none;" onclick="updateNotify()">
                            <span class="label label-pill label-danger count" id="notify-count" style="border-radius:10px;display: none"></span>
                            <span class="fa fa-bell" style="font-size:18px;"></span></a>
                        <ul class="dropdown-menu" style="    transform: translate3d(-105px, 30px, 0px);top: 0px;left: 0px;width: 300px;background-image: linear-gradient(to left bottom, #ffffff, #ffffff, #ffffff, #ffffff, #FFFFFF);height: 300px"></ul>
                    </li>
                </ul>
                <!--Play Notification Music-->
                <!--<audio id="myAudio">
                    <source src="<?php /*echo base_url(); */?>assets/audio/chime.ogg" type="audio/ogg">
                    <source src="<?php /*echo base_url(); */?>assets/audio/chime.mp3" type="audio/mpeg">
                </audio>-->
                <!--Play Notification Music-->

                <div class="logged-user-w">
                    <div class="logged-user-i">
                        <div class="avatar-w">
                            <img alt="" src="<?php echo base_url(''); ?>assets/img/avatar1.jpg"><span style="color: #fff"> <?php echo USER_NAME; ?></span>
                        </div>
                        <div class="logged-user-menu color-style-bright">
                            <div class="logged-user-avatar-info">
                                <div class="avatar-w">
                                    <img alt="" src="<?php echo base_url(''); ?>assets/img/avatar1.jpg">
                                </div>
                                <div class="logged-user-info-w">
                                    <div class="logged-user-name">
                                        <?php echo USER_NAME; ?>
                                    </div>
                                    <div class="logged-user-role" style="min-width: 100px">

                                    </div>
                                </div>
                            </div>
                            <div class="bg-icon">
                                <i class="os-icon os-icon-wallet-loaded"></i>
                            </div>
                            <?php

                             $groups_emp = array('admin');
                            if ($this->ion_auth->in_group($groups_emp)) { ?>
                                <ul id="payroll_types"></ul>                            
                            <?php }               

                             ?>
                            <ul>
                                <li>
                                    <a href="<?php echo base_url(''); ?>auth/change_password"><i class="os-icon os-icon-user-male-circle2"></i><span style="font-size: 12px;">Change Password</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(''); ?>auth/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
            <div class="mm-logo-buttons-w">
                <a class="mm-logo" href="#"><?php
                    if(COMPANY_LOGO!="") {
                        $logo = "uploads/logo/".COMPANY_LOGO;
                    } else {
                        $logo = "assets/images/logo.png";
                    }
                    ?>
                    <img src="<?php echo base_url().$logo; ?>" class="light-logo" alt="homepage" style="width: 100% !important; height: auto!important; max-height: 55px !important;" /></a>
                <div class="mm-buttons">
                    <div class="content-panel-open">
                        <div class="os-icon os-icon-grid-circles"></div>
                    </div>
                    <div class="mobile-menu-trigger">
                        <div class="os-icon os-icon-hamburger-menu-1"></div>
                    </div>
                </div>

            </div>
            <div class="menu-and-user">
                <!--------------------
                START - Mobile Menu List
                -------------------->
                <?php include 'main_menu.php'?>
                <!--------------------
                END - Mobile Menu List
                -------------------->
                <!--<div class="mobile-menu-magic">
                    <h4>
                    </h4>
                    <p>
                    </p>
                    <div class="btn-w">
                        <a class="btn btn-white btn-rounded" href="" target="_blank"></a>
                    </div>
                </div>-->
            </div>
        </div>
        <!--------------------
        END - Mobile Menu
        --------------------><!--------------------
        START - Main Menu
        -------------------->
        <div class="menu-w color-scheme-dark color-style-default menu-position-top menu-layout-compact  sub-menu-style-flyout sub-menu-color-dark selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
            <!--<div class="logo-w" style="display: block">
                <a class="logo" href="#">
                    <?php
/*                    if(COMPANY_LOGO!="") {
                        $logo = "uploads/logo/".COMPANY_LOGO;
                    } else {
                        $logo = "assets/images/logo.png";
                    }
                    */?>
                    <img src="<?php /*echo base_url().$logo; */?>" class="light-logo" alt="homepage" style="width: 100% !important; height: auto!important; max-height: 45px !important;" />
                </a>
            </div>-->
           <!-- <h1 class="menu-page-header">
            </h1>-->
            <?php include 'main_menu.php'?>
            <!--<div class="side-menu-magic">
                <h4>

                </h4>
                <p>
                </p>
                <div class="btn-w">
                </div>
            </div>-->

        </div>
        <!--------------------
        END - Main Menu
        -------------------->
        <div class="content-w">
            <div class="content-i">
                <div class="content-box">