@extends('mainpages.mainfront')
@section('css')
    <link href="assets1/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="assets1/bower_components/flexslider/flexslider.css" rel="stylesheet">
    <link href="assets1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets1/css/intlTelInput.css" rel="stylesheet">
    <link href="{{ url('assets1/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dailer/style.css') }}" rel="stylesheet" type="text/css">
<style>
    .buy-button{
        margin-right: 19px;
        background-color: #84599b;
        color: white;
        border-radius: 5px;
        border: 1px solid;
        padding: 10px 53px;
   
         transition:0.7s;
    }
    .buy-button:hover{
        color:white !important;
        box-shadow:none;
        transition:0.7s;
               box-shadow: 0 0 10px rgba(0,0,0,0.7);
       -moz-box-shadow: 0 0 10px rgba(0,0,0,0.7);
     -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.7);
-o-box-shadow: 0 0 10px rgba(0,0,0,0.7);
    }
</style>
@endsection
@section('content')
    <section class="hero-contact background-4" id="home" data-stellar-background-ratio="0.5">
        <div class="container">

        </div>
    </section>
    @if(Session::has('msg'))
        <div style="margin-top: 30px;" class="alert alert-success">{{ Session::get('msg') }}</div>
        <?php Session::forget('msg') ?>
    @endif
    <section id="tabs" class="tabs-section">
        <!--<div class="space-80"></div>-->
        <div class="container">
            <!--<div class="row">
                <div class="col-md-8 col-md-offset-2 text-center center-title margin-b-30">
                    <!--<h2>Here is User Panel</h2>-->
            <!--<p class="lead">
<!-- User panel Here You Can Make Call Add Contact Number. -->
            <!-- </p>-->
            <!-- </div>

        </div>-->
            <h2 class="text-center" style="margin-top:10px">BUY A NUMBER</h2>
            <div class="row" style="margin-top:20px">
                <div class="col-md-1"></div>
                <div class="col-md-8 col-md-offset-2">
                    @foreach($data as $phone)
                    <div class="number-list" style="margin-bottom: 30px;border-radius:5px;border:1px solid #0006;padding:12px;box-shadow: 0 0 10px rgba(0,0,0,0.6);">
                        <table style="width: 100%;">
                         <tr>
                             <td style="font-size: 18px;font-weight: bolder;"> &nbsp;&nbsp;&nbsp;Phone:</td>
                         </tr>
                            <tr>
                                <td > &nbsp;&nbsp;&nbsp;{{ $phone->dial_code.$phone->phone }}</td>
                                 <td style="text-align: right;margin-right:20px; !important" colspan="2"><a href="{{ url('buynumber/'.$phone->id) }}" class="buy-button">Buy Now</a></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bolder;">&nbsp;&nbsp;&nbsp; United State</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bolder;">&nbsp;&nbsp;&nbsp; Price : <span style="font-weight: bolder;">S{{ $phone->cost }}</span></td>
                            </tr>
                        </table>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        <div class="text-center">
            {{ $data->links() }}
        </div>
            <div class="space-50"></div>
    </section>
    <!--end tab section-->

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
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
                    <button class="btn btn-success msg"><img class="loader" style="height: 40px; display: none;" src="{{ url('loader.gif') }}">Send Message</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div><!-- End modal -->


@endsection
@section('scripts')
    <script ></script>
    {{--<script src="assets/js/contact.js" type="text/javascript"></script>--}}
    <script src="assets1/js/intlTelInput.min.js" type="text/javascript"></script>
    <script src="assets1/js/utils.js" type="text/javascript"></script>
    <script>
        $("#phone").intlTelInput();
        $('#phone').keyup(function(){
            var intlNumber = $("#phone").intlTelInput("getNumber"); // get full number eg +17024181234
            $('#number').val(intlNumber);
            var countryData = $("#phone").intlTelInput("getSelectedCountryData");
            console.log(countryData);
            var dialCode=countryData.dialCode;
            var ios2=countryData.iso2;
            var country=countryData.name;
            $('#dailCode').val(dialCode)
            console.log(dialCode);
//        var countryData = $("#phone").intlTelInput("getSelectedCountryData"); // get country data as obj
            console.log(intlNumber);
        });

        //    var countryCode = countryData.code; // get the actual code eg 1 for US
        //    countryCode = "+" + countryCode; // convert 1 to +1
        //
        //    var newNo = intlNumber.replace(countryCode, "(" + coountryCode+ ")" );
        //    console.log(countryData);
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var msgNumber;
            $('.sendmsg').click(function(e){
                console.log($(this).children('input').val());
                msgNumber=$(this).children('input').val();
                $('#msgBody').val('');
                $('#modalfooter').css('display','none');

            });
            $('.msg').click(function(e){
                console.log(msgNumber);
                var msgBody=$('#msgBody').val();
                console.log(msgBody);
                $('.loader').css('display','block');
                if(msgBody!=""){
                    $.ajax({
                        url:'/sendmessage',
                        type:'GET',
                        data:{number:msgNumber,msg:msgBody},
                        success:function(data){
                            $('#modalfooter').css('display','block');
                            $('#modalfooter').append("<div class='alert alert-danger'>"+data.msg+"</div>");
                            $('.loader').css('display','none');
                        }
                    });
                }else{
                    alert('Please Enter The Message')
                }
//            $.ajax({
//
//            });
            });

            $("#telNumber").intlTelInput();
            var number;
            var countryCode;

            $('.num').click(function () {
                var num = $(this);
                var text = $.trim(num.find('.txt').clone().children().remove().end().text());
                var telNumber = $('#telNumber');
                $(telNumber).val(telNumber.val() + text);
                number=$("#telNumber").intlTelInput('getNumber');
                var countryData = $("#telNumber").intlTelInput("getSelectedCountryData");
                console.log(countryData);
                countryCode=countryData.dialCode;

                console.log(number);


            });
            $('.dailcall').click(function(e){
                window.open('dailercall/'+number+"/"+countryCode,"MsgWindow", "width=500px,height=600px");
            })

        });
    </script>
@endsection