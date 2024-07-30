@extends('layouts.app')
@section('title','User|Forgot Password')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')

<div class="login-pager mt-99">
    <img src="{{ asset('public/images/log-bg-yel.png') }}" alt="" class="log-bg" />
    <div class="container log-pgr-inr">
        <div class="log-paper">
            <div class="log-top">
                <div class="log-hdr">
                    <h3>Forgot Password?</h3>
                    <p>Not to worry. Just enter your email address below and we'll send you an instruction email for recovery.</p>
                </div>
                <div class="log-form">
                @include('includes.message')
                
                <form  method="POST" action="{{url('password/email')}}" class="login_form" id="register-form">
                            @csrf
                            <div class="serach-radio new_radios">
                            
                            <div class="radio-box">
                                <input type="radio" name="type" value="student" id="student" checked>
                                <label for="student">I am a student</label>
                            </div>
                            <div class="radio-box">
                                <input type="radio" name="type" value="tutor" id="tutor">
                                <label for="tutor">I am tutor</label>
                            </div>
                           </div>
                            <div class="log-inpt-grp" id="for_student">
                            {{--<div class="student_froms_inputs student_froms_inputs gender-slct">
                                            <label>Whatsapp number </label>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="inputs_spans gender-slct  new_asets">
                                                        <div class="row">
                                                            <div class="col-md-2 col-sm-3 col-3 cols">
                                                                <div class="student_froms_inputs gender-slct">

                                                                    <select name="phonecode" id="siteID"
                                                                        class="form-control abcd select2-hidden-accessible ">
                                                                        @foreach($phonecodes as $phonecode)
                                                                        <option value="{{$phonecode->id}}"
                                                                            {{$phonecode->phonecode == 91 ? 'selected' : ''}}
                                                                            phonecode="{{ $phonecode->phonecode }}"
                                                                            id="shop-country">
                                                                            +{{$phonecode->phonecode}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10 col-sm-9 col-9 cols new_assists">
                                                                <input type="text" name="whatsapp" id="whatsapp"
                                                                    value="{{ old('whatsapp') }}"
                                                                    placeholder="Enter here" />
                                                                <label for="whatsapp" generated="true"
                                                                    class="error new_whats_erroes"></label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>--}}

                            <label for="mob-email" class="form-label">Whatsapp number</label>
                            <input id="whatsapp" type="text" class="rm_form_fild" placeholder="Enter your Whatsapp number" name="whatsapp" value="{{ old('whatsapp') }}">
                        </div>  
                        <div class="log-inpt-grp" id="for_tutor" style="display:none;">
                            <label for="mob-email" class="form-label">Email address</label>
                            <input id="email" type="email" class="rm_form_fild" placeholder="Enter your Email addres here" name="email" value="{{ old('email') }}">
                        </div>

                        <button type="submit" class="log-submt" id="submit">Submit</button>
                        <p class="newer"> Remember your password? <a href="{{route('login')}}" class="link_rm">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script src="{{asset('public/js/jquery.validate.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    validator = $('.login_form').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            whatsapp: {

                 required: true,
                 number: true,
            }
        },
        submitHandler: function(form) {
            form.submit();
        },
    });

    $('#student').on('click',function(){
             $('#whatsapp').rules('add','required'); 
             $('#email').rules('remove','required'); 
             $('#for_student').css('display','block');
             $('#for_tutor').css('display','none');
        })
        $('#tutor').on('click',function(){
             $('#email').rules('add','required'); 
             $('#whatsapp').rules('remove','required'); 
             $('#for_tutor').css('display','block');
             $('#for_student').css('display','none');
        })
});
</script>
<script>
$(document).ready(function() {
    $(".abcd").select2();
});
</script>

@endsection