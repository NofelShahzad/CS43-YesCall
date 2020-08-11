@extends('mainpages.mainfront')
@section('content')
    <section class="hero-contact background-4" id="home" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row vertical-align-child">

                <div class="col-sm-7">
                    <h1>The Best Quality International Calls</h1>
                    <div class="space-20"></div>
                    <p>
                        <ul class="signupBG_ul" style="list-style:none">
                            <li> ✓ Make Voice Calls</li>
                            <li> ✓ Send SMS</li>
                            <li> ✓ No Hidden Fee</li>
                            <li> ✓ Balance Never Expires</li>
                            <li> ✓ 100% Quality Guarantee</li>
                        </ul>
                    </p>
                    <div class="buttons scroll-to" style="margin-left:4%">
                        <a href="#packages_section" class="btn btn-primary btn-lg">Check SMS & Calling Rates</a>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-4">
                    <div class="form-bg">
                        <h5 class="text-uppercase text-center margin-b-20">Sign Up for free!</h5>
                        <form method="post" action="{{ url('signup') }}" class="mentos-register">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="text" name="name" class="form-control" placeholder="Full Name...." />
                                            @if($errors->has('name'))
                                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                        </div>
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="text" name="email" class="form-control" placeholder="Email Address...." />
                                            @if($errors->has('email'))
                                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="password" name="password" class="form-control" placeholder="Password" />
                                            @if($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                                        </div>
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="number" name="contact" class="form-control" placeholder="Contact Number" />
                                            @if($errors->has('contact'))
                                                <div class="alert alert-danger">{{ $errors->first('contact') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Session::has('msg'))
                                    <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                        <?php Session::forget('msg') ?>
                                    @endif
                                </div>
                                {{ csrf_field() }}
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" name="submit" class="btn btn-lg btn-block btn-dark"><span class="fas fa-sign-in-alt"></span>Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row vertical-align-child">
                <div class="col-sm-8"></div>
                <div class="col-sm-4">
                    <p style="color: white; text-align: center; font-size: 15px;">-or-</p>
                    <div class="form-bg" id="LoginForm">
                        <h5 class="text-uppercase text-center margin-b-20">Sign In</h5>
                        <form method="post" action="{{ url('login') }}" class="mentos-register">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="text" name="email" class="form-control" placeholder="Your Email....." />
                                            @if($errors->has('email'))
                                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 margin-btm-20">
                                            <input type="password" name="password" class="form-control" placeholder="Enter Password...." />
                                            @if($errors->has('passowrd'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>

                                </div>
                                {{ csrf_field() }}
                            </div>
                            <div class="row">
                               
                                <div class="col-sm-12 text-right">
                                    <button type="submit" name="submit" class="btn btn-lg btn-block btn-dark bt-">Log In</button>
                                </div>
                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end main header-->


    <!--features-->
    <section id="features">
        <div class="space-80"></div>
        <div class="container">
            <div class="row" >
                
                <div class="col-md-10 col-md-offset-2 text-center center-title margin-b-50">
                  <h2>Awesome features</h2>
                    <p class="lead">
                    We Support Calling Service All Over the World.
                       </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 margin-b-30 text-center">
                    <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\phione.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title ">Pay As You Call</h4>
                              <p class="card-text " style="padding-bottom:25px;padding-right:15px;padding-left:15px"> We only charge for the calls you make, when you make them. There is no monthly subscription fees or minimum payments.</p>
                              </div>
                    </div>
                    <!-- end row--one-->
                  
                </div><!--col-sm-4-->
                <div class="col-lg-4 col-md-4 col-sm-12 margin-b-30 text-center">
                     <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\timer.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title">Simpe Pricing</h4>
                              <p class="card-text" style="padding-bottom:25px;padding-right:15px;padding-left:15px"> We only charge you when you make phone calls based on call duration. There is no monthly service charges.</p>
                              </div>
                    </div>
                     <!-- end row--one-->
                  
                </div><!--col-sm-4-->
                <div class="col-lg-4 col-md-4 col-sm-12 margin-b-30 text-center">
                      <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\doller.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title">Call Every Where</h4>
                              <p class="card-text" style="padding-bottom:25px;padding-right:15px;padding-left:15px">  You can call from anywhere and everywhere where you want to and from</p>
                              </div>
                    </div>
                     <!-- end row--one-->
                 
                </div><!--col-sm-4-->
            </div><!--row-->
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 margin-b-30 text-center">
                      <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\tick.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title">Zero Hidden Fees</h4>
                              <p class="card-text" style="padding-bottom:25px;padding-right:15px;padding-left:15px">   There are no connection fees or any other type of hidden fees. You only pay when you make<br> phone calls</p>
                              </div>
                    </div>
                     <!-- end row--one-->
                   
                </div><!--col-sm-4-->
                <div class="col-lg-4 col-md-4 col-sm-12  margin-b-30 text-center">
                    <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\save.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title">Call Records</h4>
                              <p class="card-text" style="padding-bottom:25px;padding-right:15px;padding-left:15px">You can see a full record of your calls and your billing charges. We believe in honesty and <br>transparency.</p>
                              </div>
                    </div>
                </div><!--col-sm-4-->
                <div class="col-lg-4 col-md-4 col-sm-12  margin-b-30 text-center">
                    <div class="card" style="width:100%">
                        <img class="card-img-top" src="assets1\images\customer.JPG" alt="Card image cap">
                           <div class="card-body">
                              <h4 class="card-title">Customer Services</h4>
                              <p class="card-text" style="padding-bottom:25px;padding-right:15px;padding-left:15px"> We answer most queries within 24 hours. Please send us an email if you have any question and concerns. fa16-bcs-026@cuilahore.edu.pk</p>
							  
                              </div>
                    </div>
                </div><!--col-sm-4-->
            </div><!--row-->
        </div><!--container-->
    </section>
    <!--end of features-->
    <section id="packages_section">
        <div class="container">

            <div>
                <h1 class="pkg_heading">We Have Special Packages For Our Customers Check International Calling Rates</h1>
            </div><!-- End Column -->

            <!-- Contry selection box -->
            <div>
                <form action="" class="ctry_pkg_sel_form">
                    <div class="form-group">
                        <label>Choose Country</label>
                        <select name="countries" class="form-control" id="countries">
                            @foreach($interNationalPackages as $country)
                            <option value='{{ $country->id }}' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag {{ $country->iso2 }}" data-title="{{ $country->name }}">{{ $country->name }}</option>
                            {{--<option value='2' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag ae" data-title="United Arab Emirates">United Arab Emirates</option>--}}
                            {{--<option value='3' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag af" data-title="Afghanistan">Afghanistan</option>--}}
                            {{--<option value='ag' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag ag" data-title="Antigua and Barbuda">Antigua and Barbuda</option>--}}
                            {{--<option value='ai' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag ai" data-title="Anguilla">Anguilla</option>--}}
                            {{--<option value='al' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag al" data-title="Albania">Albania</option>--}}
                            {{--<option value='am' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag am" data-title="Armenia">Armenia</option>--}}
                        @endforeach
                        </select>
                    </div>
                </form>
            </div><!-- End Country section box -->

            <div class="row" id="package_detail" style="display: none;">
                <div class="col-sm-12">
                    <div class="pkg_container">
                        <h3 class="pkg_cat_title"><span id="country"></span> Cost Detail</h3>
                        <div class="pkg_body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="fa fa-phone"></span>
                                        <span class="text-center">Landline</span>
                                        <span class="text-center text-info">-/ Min</span>
                                    </td>
                                    <td class="pkg_price"><span class="land_line">0.76</span>  $</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-mobile"></span>
                                        <span class="text-center">Mobile</span>
                                        <span class="text-center text-info">-/ Min</span>
                                    </td>
                                    <td class="pkg_price"><span class="mobile_price">0.63</span>  $</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-comments-o"></span>
                                        <span class="text-center">Message</span>
                                        <span class="text-center text-info">-/ sms</span>
                                    </td>
                                    <td class="pkg_price"> <span class="sms">0.17</span> $</td>
                                </tr>
                            </table>
                            <form action="" class="text-center">
                                <input type="submit" class="btn btn-primary" value="TOP UP" style="background-color:background: #485563;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #29323c, #485563);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #29323c, #485563); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
                            </form>
                        </div>
                    </div>
                </div><!-- End Package Column -->


               <!-- End Package -->
            </div>
        </div><!-- End Container -->
    </section><!-- End Packages Section -->
    
    <!-- Privacy Policy -->
    <section class="privacy_section" id="privacySection">
        <div class="container">
            <div>
                <h1 class="text-center">Privacy Policy</h1>
				<br>
				<h6>Hamza Amin FA16-BCS-026</h6>
				<h6>Nofel Shahzad FA16-BCS-165</h6>
                <p>This privacy policy sets out how YesCall uses and protects any information that you give YesCall when you use this website.</p>
                <p>YesCall is committed to ensuring that your privacy is protected. Should we ask you to provide certain information by which you can be identified when using this website, then you can be assured that it will only be used in accordance with this privacy statement.</p>
                <p>YesCall may change this policy from time to time by updating this page. You should check this page from time to time to ensure that you are happy with any changes. This policy is effective from my project of COMSATS semester 8 under supervision of Dr Muhammad Hasanain Ch & Co-Supervisor Miss Mamoona Tasadduq.</p>

            </div>
        </div>
    </section>

    @endsection