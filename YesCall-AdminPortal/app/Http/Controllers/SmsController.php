<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Twilio\Http\CurlClient;
use Twilio\Rest\Client;
use Twilio\Twiml;


class SmsController extends Controller
{
    //
    public function sendSms(){

        $sid = "AC7e083d0dbd4cadf248eafe2f71dea263";
        $token = "3a0e2a27290d6b02b3a9c635d4982fd0";
        $data=new Client($sid,$token);
//        $data=new \Services_Twilio($sid,$token);
//        dd($data);
        $client = new Client($sid, $token);
        $curlOptions = [ CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false];
        $client->setHttpClient(new CurlClient($curlOptions));
        $from_phone="+441404565040";

            $phone_number= "+923487347143";
        $callback_url="http://demo.twilio.com/welcome/voice/";
        $userPhone = Input::get('userPhone');
        $encodedSalesPhone = '+441404565040';

        // Set URL for outbound call - this should be your public server URL
//        $host = parse_url(url(''), PHP_URL_HOST);
        $host=url('outbound/'.$encodedSalesPhone);
        try {
            $client->calls->create(
                '03487347143', // The visitor's phone number
               //'+441404565040', // A Twilio number in your account
               '+448081781565',
                array(
                    "url" => ''
                )
            );
            echo $client;
        } catch (Exception $e) {
            // Failed calls will throw
            return $e;
        }
//        try {
//            $call = $client->calls->create($phone_number,$from_phone, array("url" => "https://demo.twilio.com/welcome/voice/"));
//
//            print 'Call queued with Twilio';
//        } catch (\Exception $ex) {
//            print 'Twilio error: ' . $ex->getMessage();
//        }
//        try {
//            // Initiate a new outbound call
//            $call = $client->account->calls->create(
//            // Step 4: Change the 'To' number below to whatever number you'd like
//            // to call.
//                "+923487347143",
//
//                // Step 5: Change the 'From' number below to be a valid Twilio number
//                // that you've purchased or verified with Twilio.
//                "+1334-518-3209",
//
//                // Step 6: Set the URL Twilio will request when the call is answered.
//                array("url" => "http://demo.twilio.com/welcome/voice/")
//            );
//            echo "Started call: " . $call->sid;
//        } catch (Exception $e) {
//            echo "Error: " . $e->getMessage();
//        }

//        $client->messages
//            ->create(
//                "+923487347143",
//                array(
//                    "from" => "+1334-518-3209",
//                    "body" => "Let's grab lunch at Milliways tomorrow!",
//                   // "mediaUrl" => "http://www.example.com/cheeseburger.png"
//                )
//            );
        return response("Success");
    }
    public function sendVoice(){
        return view('twilio');
    }
    public function makeVoice(){
        return view('makevoice');
    }
    public function callResponse(){
        $response = new Twiml();
        $response->say('Hello World');
        $response->play('https://api.twilio.com/Cowbell.mp3');


       return response($response, 200)
            ->header('Content-Type', 'text/xml');

    }
}
