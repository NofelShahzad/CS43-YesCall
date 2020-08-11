@extends('mainpages.mainadmin')
@section('css')
    @endsection


@section('content')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <div class="theme-panel hidden-xs hidden-sm">
                <div class="toggler"> </div>
                <div class="toggler-close"> </div>
                <div class="theme-options">
                    <div class="theme-option theme-colors clearfix">
                        <span> THEME COLOR </span>
                        <ul>
                            <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                            <li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue"> </li>
                            <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                            <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                            <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                            <li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2"> </li>
                        </ul>
                    </div>
                    <div class="theme-option">
                        <span> Theme Style </span>
                        <select class="layout-style-option form-control input-sm">
                            <option value="square" selected="selected">Square corners</option>
                            <option value="rounded">Rounded corners</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Layout </span>
                        <select class="layout-option form-control input-sm">
                            <option value="fluid" selected="selected">Fluid</option>
                            <option value="boxed">Boxed</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Header </span>
                        <select class="page-header-option form-control input-sm">
                            <option value="fixed" selected="selected">Fixed</option>
                            <option value="default">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Top Menu Dropdown</span>
                        <select class="page-header-top-dropdown-style-option form-control input-sm">
                            <option value="light" selected="selected">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Mode</span>
                        <select class="sidebar-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Menu </span>
                        <select class="sidebar-menu-option form-control input-sm">
                            <option value="accordion" selected="selected">Accordion</option>
                            <option value="hover">Hover</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Style </span>
                        <select class="sidebar-style-option form-control input-sm">
                            <option value="default" selected="selected">Default</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Position </span>
                        <select class="sidebar-pos-option form-control input-sm">
                            <option value="left" selected="selected">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Footer </span>
                        <select class="page-footer-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url('dashboard') }}">Dashboard</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Form Stuff</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">

                        </ul>
                    </div>
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Register New User
                <small>You Can Add And Assign Role To Your New User.You can Also Assign Multiple Role To a User.</small>
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->

                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <!-- END SAMPLE FORM PORTLET-->

                    <div class="col-md-8 ">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-green">
                                    <i class="icon-pin font-green"></i>
                                    <span class="caption-subject bold uppercase">New User</span>
                                </div>

                            </div>
                            <div class="portlet-body form">
                                <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/registernewuser') }}">
                                    {{ csrf_field() }}
                                    <div class="form-body">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" id="form_control_1">
                                            <label for="form_control_1">Name</label>
                                            <span class="help-block">Enter Name Of The User.</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="email" value="{{ old('email') }}" class="form-control" name="email" id="form_control_1">
                                            <label for="form_control_1">Email</label>
                                            <span class="help-block">Enter User Email here...</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="password" name="pass" value="{{ old('pass') }}" class="form-control" id="form_control_1">
                                            <label for="form_control_1">Password</label>
                                            <span class="help-block">Enter User Password here...</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="password" value="{{ old('pass_confirmation') }}" name="pass_confirmation" class="form-control" id="form_control_1">
                                            <label for="form_control_1">Confirm Password</label>
                                            <span class="help-block">Comfirm Password here...</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" id="form_control_1">
                                            <label for="form_control_1">Phone</label>
                                            <span class="help-block">Enter User Phone Number here...</span>
                                        </div>

                                        <div class="form-group form-md-line-input form-md-floating-label has-info">
                                            <select name="roles[]" class="form-control edited" multiple id="form_control_1">
                                                <option value="User" selected>User</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                            <label for="form_control_1">Select Role Of User.</label>
                                        </div>

                                        <div class="form-group form-md-line-input form-md-floating-label has-info">
                                            <select name="status" class="form-control edited" id="form_control_1">
                                                <option value="Active" selected>Active</option>
                                                <option value="Inavtive">In Active</option>

                                            </select>
                                            <label for="form_control_1">Select User Status..</label>
                                        </div>

                                    <div class="form-actions noborder">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <button type="reset" class="btn default">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if(Session::has('msg'))
                           <div class="alert alert-success">{{ Session::get('msg') }}</div>
                         <?php
                            Session::forget('msg');
                            ?>
                        @endif
                        @if($errors->any())
                            @foreach($errors->all() as $er)
                                <div class="alert alert-danger col-md-8">{{ $er }}</div>
                                <div class="clearfix"></div>
                                @endforeach
                                @endif

    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
     </div>
                </div></div></div></div>


@endsection

@section('scripts')
    @endsection