<!DOCTYPE html>

<html lang="en">
<meta charset="utf-8">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ url('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{ url('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{ url('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{ url('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->



<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

    <meta charset="utf-8" />
    <title>Calling App Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    @yield('css')
    <link rel="shortcut icon" href="favicon.ico" />
<!-- END HEAD -->
<style>
    .iti {
        position: relative;
        display: inline-block;
        width: 100%;
    }
</style>
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ url('dashboard') }}">
                    <img src="{{ url('images/yes_call.png') }}" alt="logo" style="margin-top: 10px; max-width: 30px;" class="img-responsive" /></a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">

                        
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ url('users/') }}" />
                            <span class="username username-hide-on-mobile"> {{ '' }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>

                            <li>
                                <a href="{{ url('logout') }}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-quick-sidebar-toggler">
                        <a href="javascript:;" class="dropdown-toggle">
                            <i class="icon-logout"></i>
                        </a>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            
            <div class="page-sidebar navbar-collapse collapse">
               
                <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                   
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <li class="sidebar-toggler-wrapper hide">
                        <div class="sidebar-toggler">
                            <span></span>
                        </div>
                    </li>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                   
                    <li class="sidebar-search-wrapper">
                      
                  <!--      <form class="sidebar-search  " action="#" method="POST">
                            <a href="#" class="remove">
                                <i class="icon-close"></i>
                            </a>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                            <a href="#" class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </a>
                                        </span>
                            </div>
                        </form> -->
                        <!-- END RESPONSIVE QUICK SEARCH FORM -->
                    </li>
                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-home"></i>
                            <span class="title">Dashboard</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start active open">
                                <a href="{{ url('dashboard') }}" class="nav-link ">
                                    <i class="icon-bar-chart"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-user"></i>
                            <span class="title">Users</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start">
                                <a href="{{ url('newuser') }}" class="nav-link ">
                                    <i class="fa fa-user"></i>
                                    <span class="title">New User</span>
                                    {{--<span class="selected"></span>--}}
                                </a>
                            </li>
                            <li class="nav-item start">
                                <a href="{{ url('admins') }}" class="nav-link ">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Super Admins</span>
                                    {{--<span class=""></span>--}}
                                </a>
                            </li>
                            <li class="nav-item start ">
                                <a href="{{ url('userss') }}" class="nav-link ">
                                    <i class="icon-graph"></i>
                                    <span class="title">Users</span>
                                    {{--<span class="badge badge-danger">5</span>--}}
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="title">Packages</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item">
                                <a href="{{ url('createpackage') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">Create Package</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('payasyougo') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">Pay As You Go.</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('viewpackages') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">Standard & Premium</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="title">International Calling</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item">
                                <a href="{{ url('createcountrypackage') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">Create Calling Package</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('getcountrypackage') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">All Countries Calling Packages</span>
                                    <span class="selected"></span>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="title">Phone Numbers</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item">
                                <a href="{{ url('newphone') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">New</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('getallphone') }}" class="nav-link ">
                                    <i class="fa fa-graduation-cap"></i>
                                    <span class="title">All Phones</span>
                                    <span class="selected"></span>
                                </a>
                            </li>


                        </ul>
                    </li>


                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-money"></i>
                            <span class="title">Add Credit</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="{{ url('newcredit') }}" class="nav-link ">
                                    <i class="fa fa-money"></i>
                                    <span class="title">Add Credit To User</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item start open">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-money"></i>
                            <span class="title">Contact Us</span>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="{{ url('getcontactus') }}" class="nav-link ">
                                    <i class="fa fa-money"></i>
                                    <span class="title">Contact us Messages</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="heading">
                        <h3 class="uppercase">Options</h3>
                    </li>


                </ul>
                <!-- END SIDEBAR MENU -->
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->



        @yield('content')
        <!-- END SIDEBAR -->

            <div class="page-footer">
                <div class="page-footer-inner"> 2020 &copy; Yes Call
                    <a target="_blank" href="#">Visit Site</a> &nbsp;|&nbsp;
                    <a href="#" title="" target="_blank"></a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- BEGIN CONTENT -->

            <script src="{{ url('/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="{{ url('/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="{{ url('/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
            <script src="{{ url('/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
            <!-- Google Code for Universal Analytics -->
        @yield('scripts')
        <!-- End -->

            <!-- Google Tag Manager -->
            <!-- End -->
</body>
</html>