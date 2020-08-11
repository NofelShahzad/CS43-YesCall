<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

date_default_timezone_set('Asia/Karachi');

//admin Start
Route::get('dashboard','HomeController@index');
    //->middleware('roles:Admin');
Route::get('admins','HomeController@usersAdmins');
    //->middleware('roles:Admin');
Route::get('userss','HomeController@usersStudents');
//->middleware('roles:Admin');
//Route::get('teachers','HomeController@userTeachers');//->middleware('roles:Admin');
Route::get('assignrole/{id}/{role}','HomeController@makeAdmin')->middleware('roles:Admin');
Route::get('newuser','HomeController@newUser')->middleware('roles:Admin');
Route::post('registernewuser','HomeController@newUserPost')->middleware('roles:Admin');
Route::get('deleteuser/{id}','HomeController@delUser')->middleware('roles:Admin');
Route::get('update/{id}','HomeController@updateUser')->middleware('roles:Admin');
Route::post('postupdateuser/{id}','HomeController@PostUpdateUser')->middleware('roles:Admin');
Route::post('makepackage','HomeController@makePackage')->middleware('roles:Admin');
Route::get('createpackage','HomeController@createPackage')->middleware('roles:Admin');
Route::post('submitpackage','HomeController@submitPackage')->middleware('roles:Admin');
Route::get('payasyougo','HomeController@viewPayAsYouGo')->middleware('roles:Admin');
Route::get('deletepayasyougo/{id}','HomeController@delPayAsYouGo')->middleware('roles:Admin');
Route::get('viewpackages','HomeController@viewPackage')->middleware('roles:Admin');
Route::get('deletepackage/{id}','HomeController@delPackage')->middleware('roles:Admin');
Route::get('newcredit','HomeController@newCredit')->middleware('roles:Admin');
Route::post('submitcredit','HomeController@submitCredit')->middleware('roles:Admin');
Route::get('transactions/{id}','HomeController@transaction')->middleware('roles:Admin');
Route::get('packagetransactions/{id}','HomeController@PackageTransaction')->middleware('roles:Admin');
Route::get('addinactiveuser/{id}','HomeController@addInActiveUser')->middleware('roles:Admin');
Route::get('getcontactus','HomeController@getContactUs')->middleware('roles:Admin');
Route::get('deletecontactus/{id}','HomeController@delContactUs')->middleware('roles:Admin');
//country package
Route::get('createcountrypackage','HomeController@creatCountryPackage')->middleware('roles:Admin');
Route::post('submitcountrypackage','HomeController@submitCountryPackage')->middleware('roles:Admin');
Route::get('getcountrypackage','HomeController@getCountryPackage')->middleware('roles:Admin');
Route::get('deletecountry/{id}','HomeController@delCountryPackage')->middleware('roles:Admin');
Route::get('updatecountrypackage/{id}','HomeController@updateCountryPackage')->middleware('roles:Admin');
Route::post('submitupdaetcountrypackage/{id}','HomeController@submitUpdateCountryPackage')->middleware('roles:Admin');


Route::get('newphone','HomeController@newPhone')->middleware('roles:Admin');
Route::post('postnewphone','HomeController@postNewphone')->middleware('roles:Admin');
Route::get('getallphone','HomeController@getAllPhone')->middleware('roles:Admin');
Route::get('updatephone/{id}','HomeController@updatePhone')->middleware('roles:Admin');
Route::post('postupdatephone','HomeController@postUpdatePhone')->middleware('roles:Admin');
Route::get('deletephone/{id}','HomeController@deletePhone')->middleware('roles:Admin');
//country package end
//admin end
Route::get('sendmsg','SmsController@sendSms');
Route::get('callresponse','SmsController@callResponse');
Route::get('sendvoice','SmsController@sendVoice');
Route::get('makecall','SmsController@makeVoice');


Route::auth();

Route::get('/home', 'HomeController@index');
//front page Controller
Route::get('/', 'FrontPageController@index');
Route::get('/gettoken', 'FrontPageController@getToken');

Route::get('/getcountry', 'FrontPageController@getCountryDetail');

Route::get('userpanel', 'FrontPageController@userPanel')->middleware('roles:User');
Route::post('postcontact','FrontPageController@postContact')->middleware('roles:User');
Route::get('recharge','FrontPageController@recharge')->middleware('roles:User');
Route::post('requestcredit','FrontPageController@requestCredit')->middleware('roles:User');
Route::post('getupdatedminutes','FrontPageController@getUpdatedMinutes')->middleware('roles:User');
Route::post('getidofpackagedetail','FrontPageController@getIdOfPackageDetail')->middleware('roles:User');
Route::post('getidofcredit','FrontPageController@getIdOfCredit')->middleware('roles:User');
Route::post('getupdatedsecondscredits','FrontPageController@getUpdateCreditSeconds')->middleware('roles:User');


Route::post('getupdatedsecondscredits','FrontPageController@getUpdateCreditSeconds')->middleware('roles:User');
Route::get('listphonenumbers','FrontPageController@listPhone')->middleware('roles:User');
Route::get('buynumber/{id}','FrontPageController@buyNumber')->middleware('roles:User');

Route::get('call/{id}','FrontPageController@call')->middleware('roles:User');
Route::get('dailercall/{number}/{code}','FrontPageController@dailCall')->middleware('roles:User');
Route::get('sendmessage','FrontPageController@sendmessage')->middleware('roles:User');

Route::post('signup','FrontPageController@signUp');
Route::get('calllogs','FrontPageController@callLogs');
Route::post('paypalcheckout','FrontPageController@paypalChechout');
Route::post('paypalcheckoutpackage','FrontPageController@paypalChechoutPackage');
Route::get('postcontactus','FrontPageController@postContactUs');


Route::post('/outbound/{salesPhone}', function ($salesPhone) {
    // A message for Twilio's TTS engine to repeat
    $sayMessage = 'Thanks for contacting our sales department. Our
        next available representative will take your call.';

    $twiml = new Twilio\Twiml();
    $twiml->say($sayMessage, array('voice' => 'alice'));
    $twiml->dial($salesPhone);

    $response = Response::make($twiml, 200);
    $response->header('Content-Type', 'text/xml');
    return $response;
});



//apis
//Route::resource('/apiregisteruser','ApiController@creatUser')->middleware('auth:api');

Route::get('/callresponse','VoiceController@call');
Route::get('/incomecall','VoiceController@incomingHandle');
Route::group(array('prefix' => 'api'), function() {
    Route::resource('creatuser','ApiController@creatUser');
//    Route::get('loginform','ApiController@loginform');
    Route::post('login','ApiController@login');
    Route::get('getuserid','ApiController@getUserId');
    Route::post('/getcontacts','ApiController@getContacts');
    Route::post('/postcontact','ApiController@postContact');
    Route::get('/logout','ApiController@logOut');
    Route::get('/callhistory','ApiController@callHistory');
    Route::post('/postcallhistory','ApiController@postCallHistory');
    Route::get('/dialcall','ApiController@dialCall');
    Route::get('/updaetsecnods','ApiController@updateSeconds');
    Route::post('/checkcredit','ApiController@checkCredit');
    Route::post('/checkrates','ApiController@checkRate');
    Route::post('sendSMS','ApiController@sendSMS');

});

//api end