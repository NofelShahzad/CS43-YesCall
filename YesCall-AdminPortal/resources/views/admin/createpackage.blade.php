
    @extends('mainpages.mainadmin')
@section('css')
    <link href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->

            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Package
                <small>Make Packages For Users.</small>
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="note note-success">
                        <h3>Note</h3>
                        <p>This is Area Where You Can Make Packages</p>
                    </div>
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-social-dribbble font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Make A Latest Package</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-cloud-upload"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form action="{{ url('/submitpackage') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="single" class="control-label">Select Package</label>
                                    <select id="single" name="package_name" class="form-control select2">
                                        {{--@foreach($admins as $admin)--}}
                                            {{--<option value="{{ $admin->id }}">{{ $admin->name }}</option>--}}
                                        {{--@endforeach--}}
                                        <option value="pays">Pay As You Go</option>
                                        <option value="standard">Standard Package</option>
                                        <option value="premium">Premium Package</option>

                                    </select>
                                </div>
                                <div class="pays">
                                <div class="form-group">
                                    <label for="single" class="control-label">Cost per Sms $:</label>
                                   <input type="text" name="pays_sms" id="single" class="form-control">
                                        {{--@foreach($students as $student)--}}
                                            {{--<option value="{{ $student->id }}">{{ $student->name }}</option>--}}
                                        {{--@endforeach--}}

                                </div>

                                <div class="form-group">
                                    <label for="default1" class="control-label">Calling Cost Per 60 Seconds.</label>
                                    <input id="" name="pays_calling_cost" type="text" class="form-control" placeholder="Enter Calling Cost $..."> </div>
                                </div>
                                <div class="standard" style="display: none;">

                                    <div class="form-group">
                                        <label for="single" class="control-label">How Many SMS</label>
                                        <input type="text" name="standard_sms" id="single" class="form-control">
                                        {{--@foreach($students as $student)--}}
                                        {{--<option value="{{ $student->id }}">{{ $student->name }}</option>--}}
                                        {{--@endforeach--}}

                                    </div>

                                    <div class="form-group">
                                        <label for="default1" class="control-label">How Many Calling Minutes.</label>
                                        <input id="" name="how_many_calling_minutes" type="text" class="form-control" placeholder="Enter Calling Cost $..."> </div>
                                    <div class="form-group">
                                        <label for="default1" class="control-label">Total Cost $:</label>
                                        <input id="" name="standard_cost" type="text" class="form-control" placeholder="Enter Calling Cost $..."> </div>
                                </div>
                                <div class="premium" style="display: none;">

                                    <div class="form-group">
                                        <label for="single" class="control-label">How Many Sms</label>
                                        <input type="text" id="single" name="premium_sms" class="form-control" placeholder="Enter Sms">
                                        {{--@foreach($students as $student)--}}
                                        {{--<option value="{{ $student->id }}">{{ $student->name }}</option>--}}
                                        {{--@endforeach--}}

                                    </div>

                                    <div class="form-group">
                                        <label for="default1" class="control-label">How Many Calling Minutes</label>
                                        <input id="" name="premium_calling_minutes" type="text" class="form-control" placeholder="Enter Calling Minutes..."> </div>
                                    <div class="form-group">
                                        <label for="default1" class="control-label">Total Cost</label>
                                        <input id="" name="premium_cost" type="text" class="form-control" placeholder="Enter Total $..."> </div>


                                </div>

                                  </div>
                        <input type="submit" class="btn btn-success">
                                </div>



                            </form>
                            @if(count($errors))
                                @foreach($errors->all() as $er)
                                    <div class="alert alert-danger col-md-4">{{ $er }}</div>
                                @endforeach
                            @endif
                            @if(Session::has('msg'))
                                <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                <?php Session::forget('msg'); ?>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>


@endsection
@section('scripts')
    <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        $('#default1').timepicker({maxHours:24,showMeridian:false}).on('changeTime.timepicker', function(e) {
            console.log('The time is ' + e.time.value);
            console.log('The hour is ' + e.time.hours);
            console.log('The minute is ' + e.time.minutes);
            console.log('The meridian is ' + e.time.meridian);
        });

        $('#default2').timepicker({maxHours:24,showMeridian:false}).on('changeTime.timepicker', function(e) {
            console.log('The time is ' + e.time.value);
            console.log('The hour is ' + e.time.hours);
            console.log('The minute is ' + e.time.minutes);
            console.log('The meridian is ' + e.time.meridian);
        });

        $('#single').change(function(e){
           console.log($(this).val());
            var value=$(this).val();
            if(value=='standard'){
//                $('.premium').hide();
                $('.pays').hide();
                $('.premium').hide();
                $('.standard').show();

            }
            if(value=='premium'){
//                $('.premium').hide();
                $('.pays').hide();
                $('.standard').hide();
                $('.premium').show();
            }
            if(value=='pays'){
//                $('.premium').hide();

                $('.standard').hide();
                $('.premium').hide();
                $('.pays').show();
            }
        })
    </script>
    <!-- BEGIN THEME LAYOUT SCRIPTS
@endsection


