<!DOCTYPE HTML>

<html>
<?php
$sid = "AC0e5e0e496f8d4171bdd91e850bfded36";
$token = "05e68916fd15e029e713caeec217185e";
$capability=new \Twilio\Jwt\ClientToken($sid,$token);
//$capability = new Services_Twilio_Capability($TWILIO_SID, $TWILIO_TOKEN);
$capability->allowClientOutgoing('AP136ce9f1d75e4de681ecddf21bfdcfa4');
$TOKENs= $capability->generateToken();
// dd($TOKENs);
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calling</title>
    <link rel="stylesheet" href="{{ url('assets1/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets1/css/custom.css') }}">

</head>
<body>
<div class="calling_body">
    <div class="calling_container">
        <div class="person_image_calling">
            @if($data->filename!="")
            <img src="{{ url('contact/'.$data->filename) }}">
            @else
                <img src="{{ url('assets1/images/man.png') }}">

            @endif
        </div>
        <input type="hidden" value="{{ $data->number }}" id="phone">
        <p class="calling_page_p" style="white !important">{{ $data->name }}</p>
        <p class="calling_page_p connection_status" id="log" style="color: white;margin-botom:10px !important" >Connecting...</p>
        <p class="calling_page_p connection_timer" id="timer" style="color: white;margin-botom:10px !important">00:00:00</p>
        <select class="calling_page_p connection_timer" id="package" style="margin-left:25%;color:black">
            {{--<option value="callPackage">Select From Calling Sec.. {{ isset($call)?$call->call_balance:"0" }}</option>--}}
            <option value="credit" selected>From Credit:${{ isset($credit)?$credit->balance:"0" }}</option>
        </select>
        <input type="hidden" id="calling_sec" value="{{ isset($call)?$call->call_balance:"0" }}">
        <input type="hidden" id="credit" value="{{ isset($credit)?$credit->balance:"0" }}">
        <input type="hidden" id="contact_id" value="{{ $data->id }}">
        <input type="hidden" id="country_code" value="{{ isset($countryCode)?$countryCode->cost_per_minute:"" }}">

        <div class="calling_page_options">
            <button  class="calling_page_buttons" id="btn-1" onclick="call()" ><span style="color:white;" class="fa fa-phone fa-2x"></span></button>
            <button  class="calling_page_buttons" id="mute"><span style="color:white;" class="fa fa-microphone fa-2x" id="mic"></span></button>
            <button  class="calling_page_buttons" id="btn-3" onclick="hangup()" ><span style="color:white;" class="fa fa-phone fa-2x"></span></button>
        </div>
    </div>
</div>


<script src="{{ url('assets1/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('assets1/js/custom.js') }}"></script>
<script src="{{ url('timer/easytimer.min.js') }}"></script>
<script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.6/twilio.min.js"></script>
<script type="text/javascript">


    var validNavigation = false;
    function wireUpWindowUnloadEvents() {
        /*
         * List of events which are triggered onbeforeunload on IE
         * check http://msdn.microsoft.com/en-us/library/ms536907(VS.85).aspx
         */

        // Attach the event keypress to exclude the F5 refresh
        $(document).on('keypress', function(e) {
            if (e.keyCode == 116){
                validNavigation = true;
            }
        });

        // Attach the event click for all links in the page
        $(document).on("click", "a" , function() {
            validNavigation = true;
        });

        // Attach the event submit for all forms in the page
        $(document).on("submit", "form" , function() {
            validNavigation = true;
        });

        // Attach the event click for all inputs in the page
        $(document).bind("click", "input[type=submit]" , function() {
            validNavigation = true;
        });

        $(document).bind("click", "button[type=submit]" , function() {
            validNavigation = true;
        });

    }



    function windowCloseEvent()
    {
        window.onbeforeunload = function() {
            if (!validNavigation){
                callServerForBrowserCloseEvent();
            }
        }
    }



    function callServerForBrowserCloseEvent()
    {
        //�...Do you operation here
        alert('hi');
    }

    var bool=true;
    var timer = new Timer();

    var currentCallId = "";
    Twilio.Device.setup("{{ $TOKENs }}", {debug: true});
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
        conn.reject(function(e){
            console.log(e);
        });


        console.log();

        $("#modifycall").show();
    });
    Twilio.Device.disconnect(function (conn) {
        $("#log").text("Call ended");
        timer.stop();
    });
    Twilio.Device.incoming(function (conn) {
        $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
    });
    function call() {
        // get the phone number or client to connect the call to
        var userID="{{ Auth::user()->id }}";
        var calling_sec=$('#calling_sec').val();
        var credit=$('#credit').val();
        var contact_id=$('#contact_id').val();
        var countryCost=$('#country_code').val();
        var historyId;
        console.log("country:"+countryCost);

        if($('#package').val()=='credit'){
           if(countryCost!=""){
            if(credit<=0){
                alert('InSufficient Credit');
            }else{
                var packageid1;
                var params = {To: $('#phone').val(),From:'+{{ Auth::user()->phone?(Auth::user()->phone->myphone->dial_code.Auth::user()->phone->myphone->phone):'14387933439' }}'};

                console.log($('#phone').val());
                $.ajax({
                    type: "POST",
                    url: "/getidofcredit",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{'id':userID,'contact_id':contact_id,'country_cost':countryCost},
                    success:function(data){
                        console.log(data);
                        packageid1=data.id;
                        historyId=data.contact_history_id;
                    }
                });

                console.log('Calling ' + params.To + '...');
                Twilio.Device.connect(params);

                timer.start();
                timer.addEventListener('secondsUpdated', function (e) {
                    $('#timer').html(timer.getTimeValues().toString());
                    $.ajax({
                        type: "POST",
                        url: "/getupdatedsecondscredits",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:{id:packageid1,'history_id':historyId,'time':timer.getTimeValues().toString(),'country_cost':countryCost},
                        success:function(data){
                            console.log(data);
                        }

                    });
                });
            }}else{
               alert("Sorry! Country Unavailable Right Now....");
           }

        }else if($('#package').val()=='callPackage'){

            if(calling_sec<=0){
                alert('InSufficient Minutes for Calling....');

            }else{
                var packageid;
                const params = { To: $('#phone').val() };
                console.log($('#phone').val());
                $.ajax({
                    type: "POST",
                    url: "/getidofpackagedetail",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{'id':userID,'contact_id':contact_id},
                    success:function(data){
                        console.log(data);
                        packageid=data.id;
                        historyId=data.contact_history_id;


                    }
                });

                console.log('Calling ' + params.To + '...');
                Twilio.Device.connect(params);

                timer.start();
                timer.addEventListener('secondsUpdated', function (e) {
                    $('#timer').html(timer.getTimeValues().toString());
                    $.ajax({
                        type: "POST",
                        url: "/getupdatedminutes",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         data:{id:packageid,'time':timer.getTimeValues().toString(),'history_id':historyId},
                        success:function(data){
                            console.log(data);
                        }

                    });
                });
            }

        }
        console.log(userID);

    }
    function agentcall() {
        // get the phone number or client to connect the call to
        params = {"AgentNumber": $("#agentnumber").val(),
            "CustomerNumber": $("#number").val()};
        $.post('/dialpstn', params, function (data) {
            console.log("data returned = " + data);
            currentCallId = data;
            $("#modifycall").show();
            //endable button to modify this call to move it to a conference
        });
        //do stuff here, like return the call sid for future manipulation
    }
    function hangup() {
        Twilio.Device.disconnectAll();
        timer.stop();
    }
    function modifycall() {
        $.post('/getchildcallsidfromparent', {parentcallsid: currentCallId}, function (data) {
            console.log("retrieved callsid =  " + data + " from getchildcallsidfromparent, now calling modifycall");
            $.post('/modifycall', {callSid: data});
        });
    }
</script>
</body>
</html>