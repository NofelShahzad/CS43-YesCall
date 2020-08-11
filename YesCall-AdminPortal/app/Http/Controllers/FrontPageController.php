<?php

namespace App\Http\Controllers;

use App\CallHistory;
use App\Contact;
use App\CountryPackage;
use App\Credit;
use App\Package;
use App\PackageDetail;
use App\PayAsYouGo;
use App\Phone;
use App\Rule;
use App\User;
use App\ContactUs;

use App\UserPhone;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\CurlClient;
use Twilio\Jwt\AccessToken;

use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Rest\Client;

class FrontPageController extends Controller
{
    //
    public function getToken(Request $request){



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

        $identity = $request->identity;

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


        return response($token->toJWT());
    }
    public function index(){
        $payAsyougo=PayAsYouGo::get()->last();
        $standard_package=Package::where('package_type','standard')->get()->last();
        $premiumPackage=Package::where('package_type','premium')->get()->last();
        $interNationalPackages=CountryPackage::all();

        return view('frontpages.index',compact('payAsyougo','standard_package','premiumPackage','interNationalPackages'));
    }
    public function userPanel(){
        $contacts=Contact::where('user_id',Auth::user()->id)->get();
        $balance=Credit::where('user_id',Auth::user()->id)->get()->last();
        $smsAndCalls=PackageDetail::where('user_id',Auth::user()->id)->get()->last();
        $callHistory=CallHistory::where('user_id',Auth::user()->id)->get();
        return view('frontpages.userpanel',compact('contacts','balance','smsAndCalls','callHistory'));
    }
    public function postContact(Request $request){
//        dd($request->all());
        $this->validate($request, ['name' => 'required', 'filename' => 'image']);
//        dd($request->all());
        if ($request->hasfile('filename')) {
            $file = Input::file('filename');
            $path = public_path('') . '/contact';
            $filename = $file->getClientOriginalName();
            $filename = 'contact' . random_int(0, 100) . $filename;
            $file->move($path, $filename);
            $data=new Contact();
            $data->name=$request->name;
            $data->number=$request->phone;
            $data->filename=$filename;
            $data->dial_code=$request->dial_code;
            $data->user_id=Auth::user()->id;
            $data->save();
            Session::put('msg','You Have Successfully Added The Contact');

        }

        Session::flash('active','t2');
        return redirect()->back();

    }
    public function recharge(){
        return view('frontpages.recharge');
    }
    public function requestCredit(Request $request){
        Session::put('credit',$request->c_amount);

        return redirect('/recharge');
    }
    public function call($id){
        $data=Contact::find($id);
        $countryCode=CountryPackage::where('dial_code',$data->dial_code)->get()->first();
        $credit=Credit::where('user_id',Auth::user()->id)->get()->last();
        $call=PackageDetail::where('user_id',Auth::user()->id)->get()->last();
//        dd($countryCode);
        return view('frontpages.call',compact('data','credit','call','countryCode'));
    }
    public function signUp(Request $request){

        $this->validate($request,['name'=>'required|min:3','email'=>'required|unique:users,email|email','password'=>'required|min:8|confirmed','contact'=>'required']);

        $data=new User();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->password=bcrypt($request->password);
        $data->contact=$request->contact;
        $data->status="Active";
        $data->api_token=str_random(60);
        $data->save();
        $user=User::where('email',$request->email)->get()->first();
//        dd($user);
        $role=Rule::where('name','User')->first();
        $data->roles()->attach($role);

      if(Auth::attempt(['email'=>$user->email,'password'=>bcrypt($user->password)])){
          return redirect('/userpanel');
      }
        Session::put('msg','You have Successfully Signed Up Now You Can Login');
           return redirect('/');
    }
    public function callLogs(){
//        $sid = "AC7e083d0dbd4cadf248eafe2f71dea263";
//        $token = "3a0e2a27290d6b02b3a9c635d4982fd0";
////        $data=new Client($sid,$token);
////        $data=new \Services_Twilio($sid,$token);
////        dd($data);
//        $client = new Client($sid, $token);
//        $curlOptions = [ CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false];
//        $client->setHttpClient(new CurlClient($curlOptions));
//        foreach($client->calls->read() as $call){
//            dd($call);
//        }
    }


    public function buyNumber($id){
        $credit=Credit::where('user_id',Auth::user()->id)->get()->first();
        $checkphone=UserPhone::where('phone_id',$id)->get()->first();
        if ($checkphone){

            Session::flash('msg','You Already have a phone number');
            return redirect()->back();
        }
        if ($credit){
            if($credit->balance<=0){
                Session::flash('msg','You have insufficient credit to but this number');
                return redirect()->back();
            }else{
                $phone=Phone::find($id);
                $phone->status='taken';
                $phone->update();
                $transaction=new Credit();
                $transaction->user_id=Auth::user()->id;
//                $transaction->desc='Buy phone number '.$phone->phone. 'of country'.$phone->country;
                $transaction->credit=$phone->cost;
                $transaction->balance=$credit->balance-$phone->cost;
                $transaction->save();
                $newUserPhone=new UserPhone();
                $newUserPhone->user_id=Auth::user()->id;
                $newUserPhone->phone_id=$phone->id;
                $newUserPhone->save();
                Session::flash('msg','Number bought successfully..');
                return redirect('userpanel');
            }
        }else{
            Session::flash('msg','You have insufficient credit to but this number');
            return redirect()->back();
        }
        return redirect()->back();

    }
    public function listPhone(){
        $data=Phone::where('status','parked')->paginate(10);
        return view('frontpages.listphone',compact('data'));
    }
    public function inomingCallerData(Request $request){
        $contacts=Contact::where('user_id',Auth::user()->id)->where('number',$request->from)->get()->first();
        return response(['dat'=>$contacts]);
    }
    public function paypalChechout(Request $request){
//        dd($request->all());
        $data=Credit::where('user_id',Auth::user()->id)->get()->last();
        if($data){
            $newBalance=new Credit();
            $newBalance->user_id=Auth::user()->id;
            $newBalance->debit=Session::get('credit');
            $newBalance->balance=Session::get('credit')+$data->balance;
            $newBalance->save();
            Session::put('msg','You Have Successfully Added the credit');
            return redirect('/userpanel');
        }else{
            $newBalance=new Credit();
            $newBalance->user_id=Auth::user()->id;
            $newBalance->debit=Session::get('credit');
            $newBalance->balance=Session::get('credit');
            $newBalance->save();
            Session::put('msg','You Have Successfully Added the credit');
            return redirect('/userpanel');
        }
    }
    public function paypalChechoutPackage(Request $request){
//        dd($request->all());
        $data=Package::find($request->item_name2);
//        dd($data);
        $package=PackageDetail::where('user_id',Auth::user()->id)->get()->last();
        if($package){
            $transaction=new PackageDetail();
            $transaction->user_id=Auth::user()->id;
            $transaction->sms_debit=$data->how_many_sms;
            $transaction->call_debit=$data->how_many_minutes*60;
            $transaction->sms_balance=$package->balance+$data->how_many_sms;
            $transaction->call_balance=$package->balance+($data->how_many_minutes*60);
            $transaction->save();
            Session::put('msg','You Have Successfully Purchased Sms And Calling Minutes');
            return redirect('/userpanel');
        }else{

            $transaction=new PackageDetail();
            $transaction->user_id=Auth::user()->id;
            $transaction->sms_debit=$data->how_many_sms;
            $transaction->call_debit=$data->how_many_minutes*60;
            $transaction->sms_balance=$data->how_many_sms;
            $transaction->call_balance=$data->how_many_minutes*60;
            $transaction->save();
            Session::put('msg','You Have Successfully Purchased Sms And Calling Minutes');
            return redirect('/userpanel');
        }
    }
    public function getUpdatedMinutes(Request $request){
        $data=PackageDetail::find($request->id);
        $data->call_credit=$data->call_credit+1;
        $data->call_balance=$data->call_balance-1;
        $data->update();
        if(isset($request->history_id)){
        $history=CallHistory::find($request->history_id);
        $history->call_ended_at=time();
        $history->update(); }

        return response($request->time);
    }
    public function getIdOfPackageDetail(Request $request){
        $olddata=PackageDetail::where('user_id',$request->id)->get()->last();
        if($olddata){
//        $data=new PackageDetail();

            $id=PackageDetail::insertGetId(['user_id'=>$request->id,'call_credit'=>1,'call_balance'=>$olddata->call_balance-1]);
            if(isset($request->contact_id)) {
                $contactHistoryId = CallHistory::insertGetId(['user_id' => $request->id, 'contact_id' => $request->contact_id, 'call_started_at' => time(), 'call_ended_at' => time()]);
                return response(['id'=>$id,'contact_history_id'=>$contactHistoryId]);
            }else{
                return response(['id'=>$id]);

            }

        }
    }
    public function getIdOfCredit(Request $request){
    
        
            $oldData=Credit::where('user_id',$request->id)->get()->last();

            $id=Credit::insertGetId(['user_id'=>$request->id,'credit'=>$request->country_cost/60,'balance'=>($oldData->balance-($request->country_cost/60))]);
            if(isset($request->contact_id)) {
                $contactHistoryId = CallHistory::insertGetId(['user_id' => $request->id, 'contact_id' => $request->contact_id, 'call_started_at' => time(), 'call_ended_at' => time()]);
                return response(['id'=>$id,'contact_history_id'=>$contactHistoryId]);
            }else{
                return response(['id'=>$id]);
            }

        
    }
    public function getUpdateCreditSeconds(Request $request){
    
        $data=Credit::find($request->id);
        $data->credit=$data->credit+($request->country_cost/60);
        $data->balance=$data->balance-($request->country_cost/60);
        $data->update();
        if(isset($request->history_id)){
        $history=CallHistory::find($request->history_id);
        $history->call_ended_at=time();
        $history->update();}
        return response('updated');
    }
    public function dailCall($number,$code){
        $credit=Credit::where('user_id',Auth::user()->id)->get()->last();
        $call=PackageDetail::where('user_id',Auth::user()->id)->get()->last();
        $countryCode=CountryPackage::where('dial_code',$code)->get()->first();
//        dd($countryCode);
//        dd($call);
        return view('frontpages.dailcall',compact('call','credit','number','countryCode'));
    }
    public function getCountryDetail(){
       $id=Input::get('id');
        $data=CountryPackage::find($id);
        return response($data);
    }
    public function sendmessage(){
      $number=Input::get('number');
       $msg=Input::get('msg');
        $sid = "AC7e083d0dbd4cadf248eafe2f71dea263";
        $token = "3a0e2a27290d6b02b3a9c635d4982fd0";
        $data=new Client($sid,$token);
//        $data=new \Services_Twilio($sid,$token);
//        dd($data);
        try {
            $client = new Client($sid, $token);
            $curlOptions = [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false];
            $client->setHttpClient(new CurlClient($curlOptions));
            $client->messages
                ->create(
                    $number,
                    array(
                        "from" => "+448081781565",
                        "body" => $msg,
                        // "mediaUrl" => "http://www.example.com/cheeseburger.png"
                    )
                );
            return response(['msg'=>'Message Sent Successfully']);
        }catch (TwilioException $e){
            return response(['msg'=>$e->getMessage()]);
        }

    }
    public function postContactUs(){
        $email=Input::get('email');
        $msg=Input::get('msg');
        $data=new ContactUs();
        $data->email=$email;
        $data->msg=$msg;
        $data->save();
        return response("helloo");
    }
}
