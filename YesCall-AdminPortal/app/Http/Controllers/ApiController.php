<?php

namespace App\Http\Controllers;

use App\CallHistory;
use App\Contact;
use App\CountryPackage;
use App\Credit;
use App\PackageDetail;
use App\Rule;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\CurlClient;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Rest\Client;

class ApiController extends Controller
{
    //

    public function getView(){
        return view('apiloging');
    }
    public function creatUser(Request $request){
//        return response('hellooo');
//        $this->validate($request,['name'=>'required|min:3','email'=>'required|unique:users,email|email','password'=>'required|min:8|confirmed','contact'=>'required']);
//dd("hello");
//        $validator=Validator::make($request->all(),['name'=>'required|min:3','email'=>'required|unique:users,email|email','password'=>'required|min:8|confirmed','contact'=>'required']);
//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 200);
//        }
        $data=new User();
        $data->name=$request->name;

        $data->email=$request->email;
        $data->password=bcrypt($request->password);
        $data->contact=$request->contact;

        $data->api_token=str_random(60);
        $data->status="Active";
        $data->save();

        $user=User::where('email',$request->email)->get()->first();
//        dd($user);
        $role=Rule::where('name','User')->first();
        $user->roles()->attach($role);
        $token=$this->getToken();

        $myData=['name'=>$data->name,'api_token'=>$data->api_token,'is_login'=>true];

        return response(
            array(
                'status' => true,
                'data' => $myData,
                'msg' => "Registered Successfully",
                'balance'=>0,
                'capability_token'=>$token,
                'is_login'=>true
            ), 200
        );


    }
    public function login(Request $request){
//        $this->validate($request,['email'=>'required','password'=>'required']);
//        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
//
//            return response('success');
//        } else {
//            return response('error');
//        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email',$request->email)->first();
            $data = array(
                "is_login" => true,
                "name" => $user->name,
                "api_token" => $user->api_token,
                'user_id'=>$user->id,

            );
            $balance=Credit::where('user_id',$user->id)->get()->last();
            $token=$this->getToken();
            return response(
                array(
                    'status' => true,
                    'data' => $data,
                    'msg' => "Login Successfully",
                    'balance'=>$balance,
                    'capability_token'=>$token
                ), 200
            );
        }
    }


    public function getToken(){



        $sid    = "AC0e5e0e496f8d4171bdd91e850bfded36";
        $token  = "05e68916fd15e029e713caeec217185e";
        try {
            $twilio = new Client($sid, $token);
        } catch (ConfigurationException $e) {
        }

        $new_key = $twilio->newKeys
            ->create();
//        dd($new_key->toArray());
        $twilioAccountSid = "AC0e5e0e496f8d4171bdd91e850bfded36";
        $twilioApiKey = $new_key->sid;
        $twilioApiSecret=$new_key->secret;
//        dd($new_key);

//        $capability=new \Twilio\Jwt\ClientToken($sid,$token);
////$capability = new Services_Twilio_Capability($TWILIO_SID, $TWILIO_TOKEN);
//        $capability->allowClientOutgoing('AP136ce9f1d75e4de681ecddf21bfdcfa4');
//        $capability->allowClientIncoming($request->identity);
//        $TOKENs= $capability->generateToken();
//

//        $identity = $request->identity;
        $identity = '+19173382784';

// Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );
//        dd($token);

// Create Voice grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid('AP136ce9f1d75e4de681ecddf21bfdcfa4');

// Optional: add to allow incoming calls
        $voiceGrant->setIncomingAllow(true);
//        $voiceGrant->set
//        $voiceGrant->setPushCredentialSid('CRf8d112e75aabc9ebf1f1980902340a4d');
        $voiceGrant->setPushCredentialSid('CR88c3e6628c6f126ec7a84274c3dacb2c');
// Add grant to token
        $token->addGrant($voiceGrant);


// render token to string
//        echo $token->toJWT();


        return $token->toJWT();
    }
    public function loginform(){
        return view('apiloging');
    }
    public function getContacts(){
        if(Auth::guard('api')->user()) {
            $data = Contact::where('user_id',Auth::guard('api')->user()->id)->get();
        return response(['contacts'=>$data]);
        }else{
            $data1=Contact::where('user_id',Input::get('user_id'))->get();
            return response(['contacts'=>$data1]);
        }
    }


    public function checkCredit(){
        if(Auth::guard('api')->user()) {

            $balance=Credit::where('user_id',Auth::guard('api')->user()->id)->get()->last();
            if ($balance) {
                $response['balance'] = $balance->balance;
            }else{
                $response['balance']=0;
            }
            return response($response);
        }else{

            return response(['balance'=>'0'],401);
        }
    }
    public function checkRate(Request $request){
        $code=$request->code;
        $rate=CountryPackage::where('dial_code',$code)->get()->first();
        if ($rate){

return response(['data'=>$rate]);
        }else{
//            return response(['data'=>[]]);
        return response(['dat']);
        }
    }
    public function postContact(Request $request){

        $validator=Validator::make($request->all(),['name' => 'required', 'filename' => 'image','dial_code'=>'required']);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
//        dd($request->all());
        if(Auth::guard('api')->user()){
        if ($request->hasfile('filename')) {
            $file = Input::file('filename');
            $path = public_path('') . '/contact';
            $filename = $file->getClientOriginalName();
            $filename = 'contact' . random_int(0, 100) . $filename;
            $file->move($path, $filename);
        }
        $data=new Contact();
        $data->name=$request->name;
        $data->number=$request->phone;
        if(isset($filename)){
        $data->filename=$filename;}else{
            $data->filename="";
        }
        $data->dial_code=$request->dial_code;
        $data->user_id=Auth::guard('api')->user()->id;
        $data->save();
            return response(['msg'=>'Contact Saved Successfully...']);
    }else{
            return response('Un Authorized user');


            }

    return response(['msg'=>'Contact Added Successfully...']);

    }
    public function getUserId(){
        if(Auth::gaurd('api')->user()) {
            return response(['user' => Auth::guard('api')->user()]);
        }else{
            return response(['msg','user is not authenticated...']);
        }
//        if(Auth::user()){
//            return response(['user_id'=>Auth::user()->id]);
//        }else{
//            return response('no user loged in');
//        }
    }
    public function logOut(){

    }

//    public function dialCall(Request $request){
//        $code=$request->country_code;
//
//        return response()->json(['credit'=>$credit,'country_package'=>$countryCode]);
//
//    }

    public function postCallHistory(Request $request){
    if(Auth::guard('api')->user()){

        $credit=Credit::where('user_id',Auth::gaurd('api')->user()->id)->get()->last();
//        $call=PackageDetail::where('user_id',Auth::gaurd('api')->user()->id)->get()->last();
        $countryCode=CountryPackage::where('dial_code',$request->dial_code)->get()->first();

        $oldData=Credit::where('user_id',$request->id)->get()->last();
        if(!$oldData){
            return response(['msg'=>'You Have Not Enough Balance']);
        }

        $id=Credit::insertGetId(['user_id'=>Auth::gaurd('api')->user()->id,'credit'=>$countryCode->country_cost/60,'balance'=>($oldData->balance-($countryCode->country_cost/60))]);
        if(isset($request->contact_id)) {
            $contactHistoryId = CallHistory::insertGetId(['user_id' => $request->id, 'contact_id' => $request->contact_id, 'call_started_at' => time(), 'call_ended_at' => time()]);
            return response(['credit_id'=>$id,'contact_history_id'=>$contactHistoryId]);
        }else{
            return response(['id'=>$id]);
        }

    }else{
        return response('Unauthorize');
    }
    }
    public function updateSeconds(Request $request){
        //request->id & request->history_id $request->country_cost
        if(Auth::guard('api')->user()){
            $data=Credit::find($request->id);
            $data->credit=$data->credit+($request->country_cost/60);
            $data->balance=$data->balance-($request->country_cost/60);
            $data->update();
            if(isset($request->history_id)){
                $history=CallHistory::find($request->history_id);
                $history->call_ended_at=time();
                $history->update();}
            return response('updated');
        }else{
            return response('unauthorized');
        }
    }


    public function callHistory(){
        if(Auth::guard('api')->user()){
            $data=CallHistory::with('contacts')->where('user_id',Auth::guard('api')->user()->id)->get();
        return response()->json($data);
        }
    }


    public function getCountryDetail(){
        $id=Input::get('id');
        $data=CountryPackage::find($id);
        return response()->json($data);
    }
    public function paypalCheckOut(){
        $data=Credit::where('user_id',Auth::user()->id)->get()->last();
        if($data){
            $newBalance=new Credit();
            $newBalance->user_id=Auth::guard('api')->user()->id;
            $newBalance->debit=Session::get('credit');
            $newBalance->balance=Session::get('credit')+$data->balance;
            $newBalance->save();

            return response(['msg'=>'You Bought The Credit Successfully..']);

        }else{
            $newBalance=new Credit();
            $newBalance->user_id=Auth::guard('api')->user()->id;
            $newBalance->debit=Session::get('credit');
            $newBalance->balance=Session::get('credit');
            $newBalance->save();

            return response(['msg'=>'You Bought The Credit Successfully..']);
        }
    }
    public function sendSMS(Request $request){
        $number=Input::get('number');
        $msg=Input::get('msg');
        $account_sid = "AC0e5e0e496f8d4171bdd91e850bfded36";
        $auth_token = "05e68916fd15e029e713caeec217185e";



// A Twilio number you own with SMS capabilities
        $twilio_number = "+19173382784";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            '+'.$number,
            array(
                'from' => $twilio_number,
                'body' => $msg
            )
        );

        return response(['msg'=>'Message Sent Successfully']);
    }

}
