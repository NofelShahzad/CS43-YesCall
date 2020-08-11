<!DOCTYPE html>
<html lang="en">


<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calling Services</title>
    <link rel="stylesheet" href="css/box-2.css">
    <!-- Bootstrap -->
    <link href="assets1/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets1/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="assets1/bower_components/flexslider/flexslider.css" rel="stylesheet">
    <link href="assets1/css/font-awesome.min.css" rel="stylesheet">
    <!-- Flags Select box -->
    <link href="assets1/css/dd.css" rel="stylesheet">
    <link href="assets1/css/flags.css" rel="stylesheet">
    <!-- End Flags Select Box -->
    <!--font-awesome-->
    

    <!--main css file-->
    <link href="assets1/css/style.css" rel="stylesheet">
    <link href="assets1/css/custom.css" rel="stylesheet">

    
    @yield('css')

</head>
<body data-spy="scroll">
<!--pre-loader-->
<div id="preloader"></div>
<!--pre-loader-->


<!--main menu-->
<!-- Static navbar -->
<header class="navbar navbar-inverse navbar-default navbar-fixed-top navbar-transparent">
    <div class="container">
        <div class="pull-right">
            @if(Auth::user())
            
                <a href="{{ url('recharge') }}" class="btn btn-navigation" style="background-color: #8a30ce;color: white;">Recharge</a>

            @endif
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('assets1/images/logo.png') }}" style="    height: 48px;
    margin-top: 0px;"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right scroll-to">
                @if(Auth::guest())
                <li class="active"><a href="#home">Home</a></li>
                <li><a href="#features">features</a></li>
                <li><a href="#packages_section">Pricing</a></li>
                <li><a href="#home">Sign Up</a></li>
                <li><a href="#LoginForm">Login</a></li>
                 @else
                    <li><a href="{{ url('/#packages_section') }}">Check Price</a></li>

                @endif
                    @if(Auth::user())
                        <li><a href="{{ url('logout') }}">Sign Out</a></li>
                        <li><a href="{{ url('userpanel') }}">User Panel</a></li>
                        <li class="respUserNav"><a href="#">Credit: <span style="color: #ff8886">${{ isset($balance)?$balance->balance:"0" }}</span></a></li>
                        <li class="respUserNav"><a href="#">SMS: <span style="color: #cc88ff">{{ isset($smsAndCalls)?$smsAndCalls->sms_balance:"0" }}</span></a></li>
                         <li><a href="{{ url('listphonenumbers') }}">Buy Number</a></li>
                        <li><a href="#"> <span>+{{ Auth::user()->phone?Auth::user()->phone->myphone->dial_code.Auth::user()->phone->myphone->phone:'No Number' }}</span></a></li>


                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</header>
<!--end main menu-->


<!--start header-->
@yield('content')
<!--collapse section end-->
<div id="gridSystemModal" class="modal fade box-model" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #141E30;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #243B55, #141E30);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #243B55, #141E30); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
                <span class="modal-title" id="gridModalLabel" style="color:white;">Modal title</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity:0.9!important">
                    <span style="color:white;opacity:0.9!important">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">

                    <div class="row">
                        <div class="col-md-2 col-example">
                        </div>
                        <div class="col-md-8 col-example " style="margin-top:20px">
                            <div class="call-animation">
                                <img class="from_image" src="{{ url('assets1\images\modal-logo.png') }}">
                            </div>
                        </div>
                        <div class="col-md-2 col-example " >
                        </div>
                    </div>
                    <br>

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2  col-example "></div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-example">
                            <div class="time mt-1">
                                <span><b class="timer">00:00</b></span><br>

                                <span><b class="caller_name">unknown</b></span><br>
                                &nbsp;
                                <span class="caller_phone">+923138867888</span>

                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-example"></div>
                    </div>
                    <div class="row mt-4 ">
                        <div class="col-md-12 col-example ">
                            <button class="mirco animated infinite fadeIn slow call_accept"><i class="fa fa-phone fa-rotate-145"></i></button>

                            <button class="volume call_reject ml-5 "><i class="fa fa-phone fa-rotate-180" style="transform: rotate(135deg)"></i></button>
                        </div>

                    </div>
                    <br>
                </div>
            </div>
            <div class="modal-footer">


            </div>
        </div>
    </div>
</div>

{{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gridSystemModal">Launch demo modal</button>--}}
<div id="myModal1" class="modal fade" role="dialog">
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
                <button class="btn btn-success msg"><img class="loader" style="height: 40px; display: none;" src="{{ url('assets1\images\modal-logo.png') }}">Send Message</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div><!-- End modal -->

<!--footer start-->
<footer id="footer" class="footer">
    <div class="space-50"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-3 margin-b-40">
                <h4>About us</h4>
                <ul class="list-unstyled">
                    <li><a href="#privacySection">Privacy & Policies</a></li>
                    <li><a href="#">Terms & conditions</a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-40">
                <h4>Social</h4>
                <ul class="list-unstyled">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Linkedin</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-40">
                <h4>Download App</h4>
                <p style="margin-top:36px">Available at Google store and Play <br><br>store</p>
                <a href="#"><img src="assets1/images/play-store.png" alt=""></a>

                <a href="#"><img src="assets1/images/app-store.png" alt=""></a>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-40">
                <h4>Contact us</h4>
                                    <div class="form-group">
                        <label>Your Email!</label>
                        <input type="email" id="email" placeholder="Enter Your Email here" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Your Message</label>
                        <textarea class="form-control" id="msg" rows="3" placeholder="Your Message"></textarea>
                    </div>
                    <input type="button" class="btn" id="sub" value="Send">
<!--                <div class="cleafix"></div>-->
        
                <br><div class="alert alert-success" id="altmsg" style="display:none;">Your message sent successfully we will contact you.</div>
               
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                &copy; Copyright 2020 FYP COMSATS.
            </div>
        </div>
    </div>
    <div class="space-50"></div>
</footer>
<!--footer end-->


<!--back to top-->
<a href="#" class="scrollToTop"><i class="ion-android-arrow-dropup-circle"></i></a>
<!--back to top end-->


<!-- jQuery plugins-->
<script src="assets1/bower_components/jquery/dist/jquery.min.js"></script>
<script src="assets1/js/jquery-migrate.min.js"></script>
<script src="assets1/js/jquery.easing.min.js"></script>
<script src="assets1/bootstrap/js/bootstrap.min.js"></script>
<script src="assets1/bower_components/flexslider/jquery.flexslider-min.js"></script>
<script src="assets1/js/modernizr.custom.97074.js" type="text/javascript"></script>
<script src="assets1/js/jquery.sticky.js"></script>
<script src="assets1/js/jquery.stellar.min.js"></script>
<script src="assets1/js/waypoints.min.js"></script>
<script src="assets1/js/jquery.counterup.min.js"></script>
<script src="assets1/js/template-custom.js" type="text/javascript"></script>
<script src="assets1/js/newsletter-custom.js" type="text/javascript"></script>
<script src="assets1/js/contact.js" type="text/javascript"></script>
<script src="assets1/js/jquery.dd.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets1/js/custom.js"></script>
<script src="{{ url('timer/easytimer.min.js') }}"></script>
<script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.6/twilio.min.js"></script>
@if(Auth::user())
@if(Auth::user()->phone)
<?php
$sid = "AC0e5e0e496f8d4171bdd91e850bfded36";
$token = "05e68916fd15e029e713caeec217185e";
$capability=new \Twilio\Jwt\ClientToken($sid,$token);
//$capability = new Services_Twilio_Capability($TWILIO_SID, $TWILIO_TOKEN);
//        dd(Auth::user()->phone?str_replace('+','',Auth::user()->phone->myphone->dial_code.Auth::user()->phone->myphone->phone):'hamza');
if (Auth::user()){

    $capability->allowClientIncoming(Auth::user()->phone?str_replace('+','',Auth::user()->phone->myphone->dial_code.Auth::user()->phone->myphone->phone):'waqar');

}
$TOKENs= $capability->generateToken();
// dd($TOKENs);
?>
    <script>
    
    
    </script>
<script>
    $(document).ready(function() {
        var bool=true;
        var timer = new Timer();

        var currentCallId = "";
        Twilio.Device.setup("{{ $TOKENs }}", {debug: true,sounds: {
                incoming: '{{ secure_url(url('rington/ring.mp3')) }}',
            }});
        Twilio.Device.ready(function (device) {
            $("#log").text("Client  is ready");
        });
        Twilio.Device.error(function (error) {
            $("#log").text("Error: " + error.message);
        });
        Twilio.Device.connect(function (conn) {
            $("#log").text("Successfully established call");
            console.log("client callsid = " + conn.parameters.CallSid);
            currentCallId = conn.parameters.CallSid;
            console.log(conn.status());
            $('#mute').click(function(e){
                if(bool==true){
                    $('#mic').removeClass('fa-microphone');
                    $('#mic').addClass('fa-microphone-slash');
                    conn.mute(bool);
                    bool=false;

                }else{
                    $('#mic').removeClass('fa-microphone-slash');
                    $('#mic').addClass('fa-microphone');
                    conn.mute(bool);
                    bool=true;

                }
            });
            conn.accept(function(e){
                console.log(e);
            });
            // conn.reject(function(e){
            //     console.log(e);
            // });
            console.log();

            $("#modifycall").show();
        });

        Twilio.Device.incoming(function (conn) {
            $("#log").text("Incoming connection from " + conn.parameters.From);
            console.log(conn.parameters.From);
            $('#gridSystemModal').modal('show');
            $('.caller_phone').text(conn.parameters.From);
            $.ajax({
                url:'inomingcallerdata',
                type:'get',
                data:{'from':conn.parameters.From},
                success:function (data) {
                    console.log(data);
                    if(data.dat.name!='') {
                        $('.caller_name').text(data.dat.name);
                    }else {
                        $('.caller_name').text('Unknown');

                    }
                    $( "img" )
                        .error(function() {
                            $( this ).attr( "src", "img/images%20(2).png" );
                        })
                        .attr( "src",'{{ url('/contact') }}/' +data.dat.filename );
                }
            });
            


            $('.call_accept').click(function (e) {
                conn.accept();
                timer.start();
                timer.addEventListener('secondsUpdated', function (e) {
                    $('.timer').html(timer.getTimeValues().toString());

                });
            });
            $('.call_reject').click(function (e) {
                conn.reject();
            })
        });


        $('.call_reject').click(function (e) {

            Twilio.Device.disconnectAll();
            timer.stop();
        })
        Twilio.Device.on('connect', function(error) {
            console.log(error.message);
            timer.start();
        });
        Twilio.Device.on('cancel', function(error) {
            console.log(error.message);
            timer.stop();
            // $('#gridSystemModal').modal('hide');
        });
        Twilio.Device.on('disconnect', function(error) {
            console.log(error.message);
            $('#gridSystemModal').modal('hide');
            timer.stop();
        });
        $('#sub').click(function(e){
            var email=$('#email').val();
            var msg=$('#msg').val();
            $.ajax({
                type:'GET',
                url:"/postcontactus",
                data:{'email':email,'msg':msg},
                success:function(data){
                    console.log(data);
                    $('#altmsg').show(1000);
                }
            })

        });


    });

</script>
@endif
@endif
@yield('scripts')

<script>
    $(document).ready(function (e) {
        $("#countries").msDropdown();
        $('#countries').change(function(e){
//console.log($(this).val());
            $('#package_detail').hide();
            $.ajax({
                type:'GET',
                url:'getcountry',
                data:{id:$(this).val()},
                success:function(data){
                    $('#package_detail').show(1000);
                    $('#country').text(data.name);
                    $('.mobile_price').text(data.cost_per_minute);
                    $('.sms').text(data.cost_per_sms);
                    $('.land_line').text(data.cost_per_minute)
                }
            });
        });
    })
</script>

</body>


</html>
