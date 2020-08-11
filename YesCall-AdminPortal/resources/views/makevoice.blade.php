<!DOCTYPE html>
<?php
$sid = "AC7e083d0dbd4cadf248eafe2f71dea263";
$token = "3a0e2a27290d6b02b3a9c635d4982fd0";
$capability=new \Twilio\Jwt\ClientToken($sid,$token);
//$capability = new Services_Twilio_Capability($TWILIO_SID, $TWILIO_TOKEN);
$capability->allowClientOutgoing('AP62f2e57ddf278edca09f4e4ca5df69fa');
$TOKENs= $capability->generateToken();
// dd($TOKENs);
?>
<html>
<head>
    <title>Hello Client Monkey Quicker Starter'</title>
    <script type="text/javascript"
            src="https://media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <link href="https://static0.twilio.com/packages/quickstart/client.css"
          type="text/css" rel="stylesheet" />
    <style>
        button#modifycall.call {
            margin-top: 5px;
        }
    </style>
    <script type="text/javascript">
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
            currentCallId = conn.parameters.CallSid;'' +
            console.log(conn.parameters.CallStatus);

            $("#modifycall").show();
        });
        Twilio.Device.disconnect(function (conn) {
            $("#log").text("Call ended");
        });
        Twilio.Device.incoming(function (conn) {
            $("#log").text("Incoming connection from " + conn.parameters.From);
            // accept the incoming connection and start two-way audio
            conn.accept();
        });
        function call() {
            // get the phone number or client to connect the call to
            const params = { To: '+923487347143' };

            console.log('Calling ' + params.To + '...');
            Twilio.Device.connect(params);
            var timer = new Timer();
            timer.start();
            timer.addEventListener('secondsUpdated', function (e) {
                $('#basicUsage').html(timer.getTimeValues().toString());
            });
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
        }
        function modifycall() {
            $.post('/getchildcallsidfromparent', {parentcallsid: currentCallId}, function (data) {
                console.log("retrieved callsid =  " + data + " from getchildcallsidfromparent, now calling modifycall");
                $.post('/modifycall', {callSid: data});
            });
        }
    </script>
</head>
<body>
<div>
    <button class="call" onclick="call();">
        Twilio Client Call
    </button>

    <button class="hangup" onclick="hangup();">
        Hangup (client)
    </button>

    <button class="call" onclick="agentcall();">
        Agent Forward Call
    </button>

    <input type="text" id="number" name="number"
           placeholder="Enter a phone number to call"/>

    <input type="text" id="agentnumber" name="agentnumber"
           placeholder="Enter a agent phone number (for Forward)"/>
</div>
<div id="log">Loading pigeons...</div>
<div class="upgrade">
    <button class="call" id="modifycall" onclick="modifycall();" style="display: none;">
        Modify to Conference
    </button>
</div>



</body>
</html>