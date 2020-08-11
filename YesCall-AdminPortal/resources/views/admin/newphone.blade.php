
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
    <link href="{{ url('assets1/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="assets1/css/intlTelInput.css" rel="stylesheet">

@endsection
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->

            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Enter Available Phone Numbers
                <small>Enter New Availble Phone numbers.</small>
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="note note-success">
                        <h3>Note</h3>
                        <p>You can add new number to your database.</p>
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
                            <form action="{{ url('/postnewphone') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="single" class="control-label">Select Country And Enter Phone</label>
                                    <input type="tel" id="phone" placeholder="Enter Purchased Phone" class="form-control">
                                </div>
                                <div class="pays">
                                    <div class="form-group">
                                        <label for="single" class="control-label">Number Price $:</label>
                                        <input type="text" name="cost" placeholder="Enter Number Price...." id="single" class="form-control">
                                        {{--@foreach($students as $student)--}}
                                        {{--<option value="{{ $student->id }}">{{ $student->name }}</option>--}}
                                        {{--@endforeach--}}
                                        <input type="hidden" name="minute_cost" id="number">
                                        <input type="hidden" name="dail_code" id="dialCode">
                                        <input type="hidden" name="ios2" id="ios2">
                                        <input type="hidden" name="name" id="countryName">
                                    </div>

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
    <script src="assets1/js/intlTelInput.min.js" type="text/javascript"></script>
    <script src="assets1/js/utils.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets1/js/custom.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            utilsScript: "../../build/js/utils.js?1560794689211"
        });
        $('#phone').keyup(function(){
            var intlNumber = $("#phone").val(); // get full number eg +17024181234
            $('#number').val(intlNumber);
//        var countryData = $("#phone").intlTelInput("getSelectedCountryData"); // get country data as obj
            console.log(intlNumber);
            var countryData = iti.getSelectedCountryData();
            console.log(countryData);
            var dialCode=countryData.dialCode;
            var ios2=countryData.iso2;
            var country=countryData.name;
            $('#dialCode').val(dialCode);
            $('#ios2').val(ios2);
            $('#countryName').val(country);
        });
    </script>
    <!-- BEGIN THEME LAYOUT SCRIPTS
@endsection


