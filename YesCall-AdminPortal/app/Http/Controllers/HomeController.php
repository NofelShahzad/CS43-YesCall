<?php

namespace App\Http\Controllers;

use App\CountryPackage;
use App\Credit;
use App\Http\Requests;
use App\Package;
use App\PackageDetail;
use App\PayAsYouGo;
use App\Phone;
use App\Rule;
use App\User;
use App\ContactUs;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
//        dd(Auth::user()->roles);
//        $role_user=\App\Rule::where('name','Student')->first();
//        $role_admin=\App\Rule::where('name','Admin')->first();
//        $role_author=\App\Rule::where('name','Teacher')->first();
//        $user1=new User();
//        $user1->name="waqar";
//        $user1->email='waqarulzafar192@gmail.com';
//        $user1->password=bcrypt('waqar1995');
//        $user1->save();
//        $user1->roles()->attach($role_author);


        return view('admin.index');
    }

    public function usersAdmins()
    {
        $user = "Admin";
        $data = User::WhereHas('roles', function ($qu) use ($user) {
            $qu->select('name')->where('name', $user);
        })->with('roles')->get();
//        dd('Helloo');
//        dd($data);
        return view('admin.useradmin', compact('data'));
    }

    public function usersStudents()
    {
        $data = User::WhereHas('roles', function ($qu) {
            $qu->select('name')->where('name', 'User');
        })->with('roles')->get();
//        dd($data);
        return view('admin.userstudents', compact('data'));
    }

    public function userTeachers()
    {
        $data = User::WhereHas('roles', function ($qu) {
            $qu->select('name')->where('name', 'Teacher');
        })->with('roles')->get();
//        dd($data);
        return view('admin.userteacher', compact('data'));
    }

    public function makeAdmin($id, $role)
    {
        if ($role == 'Admin') {

            $data = User::find($id);
            $data->roles()->detach();
            $userAdmin = Rule::where('name', 'Admin')->get()->first();
            $data->roles()->attach($userAdmin);
            Session::flash('success', 'Your User Shifted To Admin Successfully.');
            return redirect()->back();
        }
        if ($role == 'User') {
            $data = User::find($id);
            $data->roles()->detach();
            $userAdmin = Rule::where('name', 'User')->get()->first();
            $data->roles()->attach($userAdmin);
            Session::flash('success', 'Your User Shifted To Users Successfully.');
            return redirect()->back();
        }

    }

    public function newUser()
    {
        return view('admin.newuser');
    }

    public function newUserPost(Request $request)
    {
//        dd($request->roles);
//        dd($request->all());
        $validater = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|unique:users,email', 'pass' => 'required|min:3|confirmed',
             'status' => 'required']);
        if ($validater->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validater);
        }
//        if (Input::hasfile('filename')) {
//            $file = Input::file('filename');
//            $path = public_path('') . '/users';
//            $filename = $file->getClientOriginalName();
//            $filename = 'user' . random_int(0, 100) . $filename;
//            $file->move($path, $filename);
//
//        }
//        else{
//            $filename="No File Selected";
//        }
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->pass);
//        $data->gender = $request->gender;
        $data->contact = $request->phone;
//        $data->skype = $request->skype;
//        if(isset($filename)) {
//            $data->filename = $filename;
//        }
        $data->api_token=str_random(60);
        $data->status = $request->status;
        $data->save();

        foreach ($request->roles as $role) {
            $rl = Rule::where('name', $role)->get()->first();
            $data->roles()->attach($rl);
        }
        Session::put('msg', 'Your User Registered Successfully.');
        return redirect()->back();

    }

    public function delUser($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('msg', 'Your User Deleted Successfully');
        return redirect()->back();
    }

    public function updateUser($id)
    {
        $user = User::find($id);
        return view('admin.updateuser', compact('user'));
    }

    public function PostUpdateUser(Request $request, $id)
    {

        $this->validate($request, ['name' => 'required', 'email' => 'required', 'pass' => 'required|min:3|confirmed',
            'status' => 'required']);


        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->pass);
        $data->contact = $request->phone;
        $data->api_token=str_random(60);
        $data->status = $request->status;
        $data->update();
        $data->roles()->detach();
        foreach ($request->roles as $role) {
            $rl = Rule::where('name', $role)->get()->first();
            $data->roles()->attach($rl);
        }


        Session::flash('msg', 'User Data Successfully Updated');
        return redirect()->back();
    }
    public function makePackage(){
        return view('admin.makepackge');
    }
public function createPackage(){
    return view('admin.createpackage');
}
    public function submitPackage(Request $request){
        if($request->package_name=='pays'){
//            dd($request->all());
            $this->validate($request,['package_name'=>'required','pays_sms'=>'required|numeric','pays_calling_cost'=>'required|numeric']);
            $pays=new PayAsYouGo();
            $pays->package_type=$request->package_name;
            $pays->sms_amount=$request->pays_sms;
            $pays->calling_amount=$request->pays_calling_cost;
            $pays->save();
            Session::put('msg','You Have Added New Package');
            return redirect()->back();

        }elseif($request->package_name=='standard'){
            $this->validate($request,['package_name'=>'required','standard_sms'=>'required|numeric','how_many_calling_minutes'=>'required|numeric'
            ,'standard_cost'=>'required|numeric'
            ]);
            $standard=new Package();
            $standard->package_type=$request->package_name;
               $standard->how_many_sms=$request->standard_sms;
                $standard->how_many_minutes=$request->how_many_calling_minutes;
                $standard->cost=$request->standard_cost;
            $standard->save();
            Session::put('msg','You Have Added Successfully Standard Package');
            return redirect()->back();


        }elseif($request->package_name='premium'){
            $this->validate($request,['package_name'=>'required','premium_sms'=>'required|numeric','premium_cost'=>'required|numeric']);
            $standard=new Package();
            $standard->package_type=$request->package_name;
            $standard->how_many_sms=$request->premium_sms;
            $standard->how_many_minutes=$request->premium_calling_minutes;
            $standard->cost=$request->premium_cost;
            $standard->save();
            Session::put('msg','You Have Added Successfully Premium Package');
            return redirect()->back();

        }
    }
    public function viewPayAsYouGo(){
        $data=PayAsYouGo::orderBy('id','DESC')->paginate(100);
        return view('admin.payasyougo',compact('data'));

    }
    public function delPayAsYouGo($id){
        $data=PayAsYouGo::find($id);
        $data->delete();
        Session::put('msg','Your Package Deleted Successfully');
        return redirect()->back();
    }
    public function viewPackage(){
        $data=Package::orderBy('id','DESC')->paginate(100);
        return view('admin.viewpackage',compact('data'));
    }
    public function delPackage($id){
        $data=Package::find($id);
        $data->delete();
        Session::put('msg','Your Package Deleted Successfully.');
        return redirect()->back();
    }
    public function newCredit(){
        $data=User::all();
        return view('admin.newcredit',compact('data'));
    }
    public function submitCredit(Request $request){
//        dd($request->all());
        $this->validate($request,['user_id'=>'required','credit'=>'required']);
        $data=Credit::where('user_id',$request->user_id)->get()->last();
        if($data){
            $newBalance=new Credit();
            $newBalance->user_id=$request->user_id;
            $newBalance->debit=$request->credit;
            $newBalance->balance=$request->credit+$data->balance;
            $newBalance->save();
            Session::put('msg','You Have Successfully Added the credit to that user.');
            return redirect()->back();
        }else{
            $newBalance=new Credit();
            $newBalance->user_id=$request->user_id;
            $newBalance->debit=$request->credit;
            $newBalance->balance=$request->credit;
            $newBalance->save();
            Session::put('msg','You Have Successfully Added the credit to that user.');
    return redirect()->back();
        }
    }
    public function transaction($id){
        $data=Credit::where('user_id',$id)->get();
//        dd($data);
        return view('admin.transaction',compact('data'));
    }
    public function PackageTransaction($id){
        $data=PackageDetail::where('user_id',$id)->get();
//        dd($data);
        return view('admin.packagetransactions',compact('data'));
    }
    public function addInActiveUser($id){
        $data=User::find($id);
        $data->status='Inavtive';
        $data->update();
        Session::flash('msg','Your Use Added To In Active Successfully.');
        return redirect()->back();
    }

    public function getCredit(){
    }
    public function creatCountryPackage(){
        return view('admin.countrypackage');
    }
    public function submitCountryPackage(Request $request){
//        dd($request->all());
        $this->validate($request,['name'=>'required','ios2'=>'required','dail_code'=>'required|unique:country_packages,dial_code']);
        $data=new CountryPackage();
        $data->name=$request->name;
        $data->iso2=$request->ios2;
        $data->dial_code=$request->dail_code;
        $data->cost_per_sms=$request->cost_per_sms;
        $data->cost_per_minute=$request->minute_cost;
        $data->save();
        Session::put('msg','You Have Successfully Enter The International Cost.');
        return redirect()->back();
    }
    public function getCountryPackage(){
        $data=CountryPackage::all();
        return view('admin.getallpackages',compact('data'));
    }
    public function delCountryPackage($id){
        $data=CountryPackage::find($id);
        $data->delete();
        Session::put('msg','your Country Deleted Successfully');
        return redirect()->back();
    }
    public function updateCountryPackage($id){
        $data=CountryPackage::find($id);
        return view('admin.updatecountrypackage',compact('data'));
    }
    public function submitUpdateCountryPackage($id,Request $request){
        $data=CountryPackage::find($id);
        $data->cost_per_sms=$request->cost_per_sms;
        $data->cost_per_minute=$request->minute_cost;
        $data->update();
        Session::put('msg','Your Data Updated Successfully.');
        return redirect('getcountrypackage');
    }
    public function getContactUs(){
        $data=ContactUs::paginate(100);
        return view('admin.contactus',compact('data'));
    }
    public function delContactUs($id){
        $data=ContactUs::find($id);
        $data->delete();
        return redirect()->back();
    }



    public function newPhone(){

        return view('admin.newphone');
    }
    public function postNewphone(Request $request){
//    dd($request->all());
        $this->validate($request,['phone'=>'unique:phones']);
        $sid = "AC0e5e0e496f8d4171bdd91e850bfded36";
        $token = "05e68916fd15e029e713caeec217185e";
        try {
            $twilio = new Client($sid, $token);
        } catch (ConfigurationException $e) {
        }

//        $incoming_phone_number = $twilio->incomingPhoneNumbers('')
//            ->update(array(
//                    "accountSid" => "ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
//                    "smsUrl" => "http://demo.twilio.com/docs/sms.xml",
//                    "voiceUrl" => "http://demo.twilio.com/docs/voice.xml"
//                )
//            );

//working code start from here
//        $incoming_phone_number = $twilio->incomingPhoneNumbers
//            ->create(array(
//                    "friendlyName" => "My Company Line",
//                    "phoneNumber" => $request->dial_code.$request->minute_cost,
//                    "voiceMethod" => "GET",
//                    "voiceUrl" => url('incomecall')
//                )
//            );
//        $incoming_phone_number->update([ "voiceUrl" => url('incomecall'),"voiceMethod" => "GET"]);
     //working code end from here
        $newPhone=new Phone();
        $newPhone->phone=$request->minute_cost;
        $newPhone->cost=$request->cost;
        $newPhone->status='parked';
        $newPhone->dial_code=$request->dail_code;
        $newPhone->iso=$request->ios2;
        $newPhone->country=$request->name;
        $newPhone->save();
        Session::flash('msg','Phone Added Successfully...');
        return redirect()->back();
    }
    public function deletePhone($id){
        $delPhone=Phone::find($id);
        if ($delPhone){
            $delPhone->delete();
        }
        Session::flash('msg','Phone Deleted Successfully');
        return redirect()->back();
    }

    public function getAllPhone(){
        $data=Phone::all();
        return view('admin.allphone',compact('data'));
    }
    public function updatePhone($id){
        $data=Phone::find($id);
        return view('admin.updatephone',compact('data'));
    }
    public function postUpdatePhone(Request $request){
        $newPhone=Phone::find($request->id);
        $newPhone->phone=$request->minute_cost;
        $newPhone->cost=$request->cost;
        $newPhone->status='parked';
        $newPhone->dial_code=$request->dail_code;
        $newPhone->iso=$request->ios2;
        $newPhone->country=$request->name;
        $newPhone->update();
        Session::flash('msg','Phone Updated Successfully..');
return redirect()->back();
    }

}
