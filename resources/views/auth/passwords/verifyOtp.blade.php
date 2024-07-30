@extends('layouts.app')
@section('title','OTP Verification')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')

<section class="extra_margin"></section>

<section class="student_signup">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="main-center-div">
                    <div class="upper-login">
                        <div class="login_headings">
                            
                            @include('includes.message')

                            <h1>OTP Verifiction for WhatsApp Number</h1>
                            <p>
                                We have sent 6 digit otp to your whatsApp number xxxxx
                                xxx{{ substr(@$whatsapp,8,2) }}, it is valid for 10 minutes! please enter your otp
                                code below.
                            </p>
                            {{--<h3>One Time Password - {{@$otp}}</h3>--}}
                            
                        </div>

                        <h5 class="otp_error error text-center" style="display: none;color:red;">Please enter correct otp</h5>
                        <div class="signup_froms otp_vers">
                            @guest
                            <form id="otpForm" method="POST" action="{{ route('user.reset.password.verify') }}">
                            @endguest
                            @csrf
                                <div class="row">
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(1)" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(2)" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(3)" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(4)" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(5)" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <div class="student_froms_inputs">
                                            <input class="otp" type="text" name="otp[]" min="0" maxlength="1" oninput="digitValidate(this)" onkeyup="tabChange(6)" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                    <input type="hidden" name="whatsapp_otp" id="whatsapp_otp" value="" />
                                    <input type="hidden" name="user_id" class="rm_form_fild" value="{{@$userid}}">
                                        <button type="submit" class="submis_btns" href="student-signup-step-3.html">
                                            continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="login_lowers">
                        <div class="top_ups"></div>

                        <div class="btms-login">
                            <p>
                                Did not recieve verification code yet? <br />
                                @guest
                                <a href="{{ route('resend.otp',[md5($userid)]) }}">
                                    <img src="{{asset('public/images/rotate-ccw.png')}}" class="hovern" />
                                    <img src="{{asset('public/images/rotate-ccw1.png')}}" class="hoverb" />
                                    Resend OTP</a>
                                @endguest
                                @auth
                                <a href="{{ route('student.resend.otp',[md5($userid)]) }}">
                                    <img src="{{asset('public/images/rotate-ccw.png')}}" class="hovern" />
                                    <img src="{{asset('public/images/rotate-ccw1.png')}}" class="hoverb" />
                                    Resend OTP</a>
                                @endauth
                                
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script src="{{asset('public/js/jquery.validate.js')}}"></script>
<script>
$(document).ready(function() {
    $(document).ready(function() {

        $("#otpForm").validate({
            rules: {
                otp: {
                    required: true,
                    number: true,
                }
            },
            messages: {
                otp: {
                    remote: 'Please enter OTP'
                }
            },

            submitHandler: function(form) {
                var values = [];
                var otp='';
                $("input[name='otp[]']").each(function() {
                    if($(this).val().length > 0){
                        otp += $(this).val();
                        values.push($(this).val());
                    }
                });
                $('#whatsapp_otp').val(otp);
                if(values.length == 6){
                    $('.otp_error').hide();
                    form.submit();
                }else{
                    $('.otp_error').show();
                    return false;
                }
                
                
                //form.submit();
            },

        });


    });
    
});
</script>

@endsection