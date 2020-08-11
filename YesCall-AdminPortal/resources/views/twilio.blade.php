<!doctype html>
<?php
$sid = "AC7e083d0dbd4cadf248eafe2f71dea263";
$token = "3a0e2a27290d6b02b3a9c635d4982fd0";
        $capability=new \Twilio\Jwt\ClientToken($sid,$token);
//$capability = new Services_Twilio_Capability($TWILIO_SID, $TWILIO_TOKEN);
$capability->allowClientOutgoing('AC7e083d0dbd4cadf248eafe2f71dea263');
$TOKENs= $capability->generateToken();
       // dd($TOKENs);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.4/twilio.min.js"></script>
    <script>
        var token="42473ac54a900f6e1e1c9029d1f31540";
        Twilio.Device.setup("{{ $TOKENs  }}");
        Twilio.Device.ready(function(device) {
            // The device is now ready
            console.log(device.getUserMedia());
            console.log("Twilio.Device is now ready for connections");
            var number = '923487347143';
            var connection = Twilio.Device.connect({
                phone: number
            }).error(function(e){
                console.log(e);
            });
        });
    </script>
</head>
<body>

</body>
</html>