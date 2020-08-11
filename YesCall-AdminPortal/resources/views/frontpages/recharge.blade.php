@extends('mainpages.mainfront')
@section('content')
    <section class="hero-contact background-4" id="home" data-stellar-background-ratio="0.5">
        <div class="container">

        </div>
    </section>
    <section id="recharge_form_Section">
        <div class="container">

            <form method="post" action="{{ url('requestcredit') }}">
                <div class="form-group">
                    <label for="c_amount" style="font-size: 20px; padding-top: 10px;">Credit Amount In US Dollars $:</label>
                    <input type="number" placeholder="Enter Your Amount To Recharge..." name="c_amount" class="form-control" id="c_amount">
                </div>
                {{ csrf_field() }}
                <input type="submit" value="submit" class="btn btn-success">
                <h4>Requested Credit:$@if(Session::has('credit')){{ Session::get('credit') }} @endif</h4>
            </form>
            <br>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="business" value="smi2isilent@outlook.com">

                {{--<input type="hidden" value="GBP" name="currency_code">--}}
                <input type="hidden" name="custom" value="{{ encrypt('waqarulzafar') }}">
                <input type="hidden" name="return" value="{{ url('paypalcheckout') }}">
                <input type="hidden" name="item_name_1" value="Pay As You Go">
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="amount_1" value="{{ Session::has('credit')?Session::get('credit'):"" }}">

                <button type="submit" class="btn btn-lg btn-primary">Buy Now</button>

            </form>

        </div>
    </section>
@endsection