<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Twilio\TwiML\VoiceResponse;


class VoiceController extends Controller
{
    //

    public function call(Request $request){
        $response = new VoiceResponse();
        $dial = $response->dial('', ['callerId' => $request->From,
            'recordingStatusCallback' => url('recordingstatus')]);
        $dial->number($request->To);

        return Response::make($response, '200')->header('Content-Type', 'text/xml');

    }
    public function incomingHandle(Request $request){
//        Log::debug(json_encode($request->all()));
//        try {
//            $response = new Twiml();
//            $response->dial('', array(
//            ))->client( str_replace('+', "", $request->To));
////            $response->client('joe');
//        } catch (TwimlException $e) {
//        }
//
//
//        Log::debug(json_encode($request->all()));
//        return Response::make($response, '200')->header('Content-Type', 'text/xml');
//        print $response;

        $response = new VoiceResponse();
        $dial = $response->dial('');
//        $dial->number($request->To);
        $dial->client(str_replace('+', "", $request->To));
        return Response::make($response, '200')->header('Content-Type', 'text/xml');

    }

}
