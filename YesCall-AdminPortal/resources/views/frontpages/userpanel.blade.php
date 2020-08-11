@extends('mainpages.mainfront')
@section('css')
    <link href="assets1/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="assets1/bower_components/flexslider/flexslider.css" rel="stylesheet">
    <link href="assets1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets1/css/intlTelInput.css" rel="stylesheet">
    <link href="{{ url('assets1/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dailer/style.css') }}" rel="stylesheet" type="text/css">
<style>
    .num{
         transition: background 0.8s;
    }
    .num:active{
       background-color: #2ac1f9;
  background-size: 100%;
  transition: background 0s;
    }

    .iti {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .iti input, .iti input[type=text], .iti input[type=tel] {
        position: relative;
        z-index: 0;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-right: 36px;
        margin-right: 0;
        background-color: #232324;
        color: #fff6fc;
        font-weight: bolder;
        font-size: 20px;
    }
    .iti__flag-box, .iti__country-name {
        margin-right: 6px;
        color: black;
    }
</style>
    @endsection
@section('content')
    <section class="hero-contact background-4" id="home" data-stellar-background-ratio="0.5" >
        <div class="container">

        </div>
    </section>
    @if(Session::has('msg'))
        <div style="margin-top: 30px;" class="alert alert-success">{{ Session::get('msg') }}</div>
        <?php Session::forget('msg') ?>
    @endif
    <section id="tabs" class="tabs-section">
        <!--<div class="space-80"></div>-->
        <div class="container">

            <h2 class="text-center" id="man-text" style="position:absolute;top:30%;left:40%;z-index:2;color:white">Here is User Panel</h2>
            <div class="row">
               <div class="col-md-1"></div>
                <div class="col-md-8 col-md-offset-2">
                    <ul class="list-inline tabs-nav">
                        <li role="presentation" @if(Session::has('active'))@if(Session::get('active')=="t1") {{ "class='active'" }} @endif @endif><a href="#t1" aria-controls="t1" role="tab" data-toggle="tab">Contact List</a></li>
                        <li role="presentation" @if(Session::has('active'))@if(Session::get('active')=="t2") class="active" @endif @endif><a href="#t2" aria-controls="t2" role="tab" data-toggle="tab">Add New Contact</a></li>
                        <li role="presentation"><a href="#t3" aria-controls="t3" role="tab" data-toggle="tab">Call History</a></li>
                        <li role="presentation"><a href="#t4" aria-controls="t4" role="tab" data-toggle="tab">Dailer</a></li>
                    </ul>
                    <div class="tab-content " style="margin-top:23px">
                        <div role="tabpanel" class="tab-pane active" id="t1"; style="padding:10px">
                            @if(!count($contacts))
                                <div class="center" style="margin-top:10px">You Have No Contacts</div>

                            @endif
                            <table class="table table-hover contact_list">

                                @foreach($contacts as $contact)
                                <tr style="margin-bottom:10px !important">
                                    <td><img src="{{ url('contact/'.$contact->filename) }}" onError="this.onerror=null;this.src='{{ url('assets1/images/man.png') }}';" class="userpanel_avatar"></td>

                                    <td>
                                        <span>{{ $contact->name }}</span>
                                        <span class="contact_number">{{ $contact->number }}</span>
                                    </td>
                                    <td><a href="{{ url('call/'.$contact->id) }}" class="call"><span class="fa fa-phone fa-2x" style="margin-top:6px"></span></a></td>
                                    <td><a href="#" data-toggle="modal" data-target="#myModal" class="sendmsg"><input type="hidden" value="{{ $contact->number }}"><span class="fa fa-envelope-o fa-2x" style="margin-top:8px"></span></a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div><!-- End First Tab -->

                        <!-- Second Tab -->
                        <div role="tabpanel" class="tab-pane" id="t2" >
                            <form enctype="multipart/form-data" method="post" action="{{ url('postcontact') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="name" placeholder="Enter Name Of The Person" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Number:</label>
                                    <input type="tel" id="phone" class="form-control" style="width:100% !important;">
                                    <input type="hidden" name="phone" id="number">
                                    <input type="hidden" name="dial_code" id="dailCode">
                                </div>
                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <div class="input-group">
                                                    <span class="input-group-btn" style="border:1px solid #0003;border-collapse:collapse ">
                                                        <span class="btn btn-default btn-file">
                                                            Browse� <input name="filename" type="file" id="imgInp" style="border-collapse:collapse">
                                                        </span>
                                                    </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload'/>
                                </div>
                                <input type="submit" value="Add Contact" class="btn btn-danger">
                            </form>
                        </div><!-- End Second Tab -->

                        <!-- Third Tab -->
                        <div role="tabpanel" class="tab-pane" id="t3">
                            <table class="table table-hover contact_list">
                                <tr>
                                    <th>Img</th>
                                    <th>Name/Contact</th>
                                    <th>Call Duration</th>
                                    <th>Call Time</th>
                                    <th>Call Him/Her</th>
                                    <th>Send Message</th>
                                </tr>
                                @foreach($callHistory as $cals)
                                <tr>
                                    <td><img src="{{ url('contact/'.$cals->contacts->filename) }}" onError="this.onerror=null;this.src='{{ url('assets1/images/man.png') }}';" class="userpanel_avatar"></td>
                                    <td>
                                        <span>{{ $cals->contacts->name }}</span>
                                        <span class="contact_number">{{ $cals->contacts->number }}</span>
                                    </td>
                                    <?php
                                    $start=\Carbon\Carbon::createFromTimestamp($cals->call_started_at);
                                    $end=\Carbon\Carbon::createFromTimestamp($cals->call_ended_at);
                                    $now=\Carbon\Carbon::now();

                                    ?>
                                    <td>
                                        <span class="fa fa-clock-o"></span>
                                        <span>{{ $start->diffInSeconds($end) }} Seconds</span>
                                    </td>
                                    <td>
                                        <span class="fa fa-clock-o"></span>
                                        <span>{{ $start->diffForHumans($now) }}</span>
                                    </td>
                                    <td><a href="{{ url('call/'.$cals->contacts->id) }}" class="call"><span class="fa fa-phone fa-2x"></span></a></td>
                                    <td><a href="#" data-toggle="modal" data-target="#myModal" class="sendmsg"><input type="hidden" value="{{ $cals->contacts->number }}"><span class="fa fa-envelope-o fa-2x"></span></a></td>
                                </tr>
                                    @endforeach

                            </table>
                        </div><!-- End Third Tab -->
                        <div role="tabpanel" class="tab-pane" id="t4" ;>

                                <div class="row" style="text-align:center">
                                    <div class=" phone" >
                                        <div class="row1" >
                                            <div style="max-width:340px; margin:auto; background:#232324;
">
                                                <input type="tel" name="name" id="telNumber" class="form-control tel" value="" / >
                                                <div class="num-pad"  style="margin-left:23px;margin-top:40px">
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt" style="margin-top:11px">
                                                                1
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                2 <span class="small">
                                    <p>
                                        ABC</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                3 <span class="small">
                                    <p>
                                        DEF</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                4 <span class="small">
                                    <p>
                                        GHI</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                5 <span class="small">
                                    <p>
                                        JKL</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                6 <span class="small">
                                    <p>
                                        MNO</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                7 <span class="small">
                                    <p>
                                        PQRS</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                8 <span class="small">
                                    <p>
                                        TUV</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                9 <span class="small">
                                    <p>
                                        WXYZ</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt" style="margin-top:14px">
                                                                *
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt">
                                                                0 <span class="small">
                                    <p>
                                        +</p>
                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="num">
                                                            <div class="txt" style="margin-top:11px">
                                                                #
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                               
                                                <button type="button" class="btn btn-success dailcall btn-lg" style="margin-bottom:8px;padding:10px 10px !important;background-color:#3de067;border-radius:200px;width:60px;height:60px;margin-top:20px;" id="calll"><span style="color:white;margin-top:7px" class="fa fa-phone fa-2x"></span></button>
                                            </div>
                                        </div>



                                        </div>
                                        <div class="clearfix">
                                        </div>


                                </div><!-- End Second Tab -->

                    </div>
                </div>
            </div>
        </div>
        <div class="space-50"></div>
    </section>
    <!--end tab section-->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enter Message</h4>
                </div>
                <div class="modal-body">
                    <!-- Message Box -->
                    <div class="form-group">
                        <textarea class="form-control" id="msgBody" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer" >
                    <div id="modalfooter"></div>
                    <!-- Submit Btn -->
                    <button class="btn btn-success msg"><img class="loader" style="height: 40px; display: none;" src="{{ url('loader.gif') }}">Send Message</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div><!-- End modal -->


    @endsection
@section('scripts')
<script ></script>
{{--<script src="assets/js/contact.js" type="text/javascript"></script>--}}
<script src="assets1/js/intlTelInput.min.js" type="text/javascript"></script>
<script src="assets1/js/utils.js" type="text/javascript"></script>
<script src="assets1/js/intlTelInput-jquery.js" type="text/javascript"></script>
<script>
    $("#phone").intlTelInput();
    $('#phone').keyup(function(){
        var intlNumber = $("#phone").intlTelInput("getNumber"); // get full number eg +17024181234
        $('#number').val(intlNumber);
        var countryData = $("#phone").intlTelInput("getSelectedCountryData");
        console.log(countryData);
        var dialCode=countryData.dialCode;
        var ios2=countryData.iso2;
        var country=countryData.name;
        $('#dailCode').val(dialCode)
        console.log(dialCode);
//        var countryData = $("#phone").intlTelInput("getSelectedCountryData"); // get country data as obj
        console.log(intlNumber);
    });

//    var countryCode = countryData.code; // get the actual code eg 1 for US
//    countryCode = "+" + countryCode; // convert 1 to +1
//
//    var newNo = intlNumber.replace(countryCode, "(" + coountryCode+ ")" );
//    console.log(countryData);
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var msgNumber;
        $('.sendmsg').click(function(e){
           console.log($(this).children('input').val());
            msgNumber=$(this).children('input').val();
            $('#msgBody').val('');
            $('#modalfooter').css('display','none');

        });
        $('.msg').click(function(e){
            console.log(msgNumber);
            var msgBody=$('#msgBody').val();
            console.log(msgBody);
            $('.loader').css('display','block');
            if(msgBody!=""){
                $.ajax({
                   url:'/sendmessage',
                    type:'GET',
                    data:{number:msgNumber,msg:msgBody},
                    success:function(data){
                        $('#modalfooter').css('display','block');
                        $('#modalfooter').append("<div class='alert alert-danger'>"+data.msg+"</div>");
                        $('.loader').css('display','none');
                    }
                });
            }else{
            alert('Please Enter The Message')
            }
//            $.ajax({
//
//            });
        });

      // var inputIntel=  $("#telNumber").intlTelInput();
        var input = document.querySelector("#telNumber");
        var iti = window.intlTelInput(input, {
            utilsScript: "../../build/js/utils.js?1560794689211"
        });

        var number;
        var countryCode;
        $('#telNumber').keyup(function (e) {
            // $(this).trigger('close:countrydropdown');
            var num = $(this);
            var text = $.trim(num.find('.txt').clone().children().remove().end().text());
            var telNumber = $('#telNumber');
            $(telNumber).val(telNumber.val() + text);
            number=iti.getNumber();;
            var countryData = iti.getSelectedCountryData();
            console.log(countryData);
            countryCode=countryData.dialCode;
            if(e.key=='Enter'){
                var isValid = iti.isValidNumber();
                if (isValid){
                window.open('dailercall/'+number+"/"+countryCode,"MsgWindow", "width=500px,height=600px");
                    }else {
                    alert('Please Enter a Valid Phone number');
                    return;
                }
                }



        });
        $('.num').click(function () {
            var num = $(this);
            var text = $.trim(num.find('.txt').clone().children().remove().end().text());
            var telNumber = $('#telNumber');
            $(telNumber).val(telNumber.val() + text);
            number=iti.getNumber();;
            var countryData = iti.getSelectedCountryData();
            console.log(countryData);
            countryCode=countryData.dialCode;

            console.log(number);


        });
        $('.dailcall').click(function(e){
            var isValid = iti.isValidNumber();
            if (isValid){
                window.open('dailercall/'+number+"/"+countryCode,"MsgWindow", "width=500px,height=600px");
            }else {
                alert('Please Enter a Valid Phone number');
                return;
            }
        })

    });
</script>
@endsection