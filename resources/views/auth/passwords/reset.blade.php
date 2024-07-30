@extends('layouts.app')
@section('title')
Jdmea - Reset Password
@endsection
@section('style')
@include('includes.style')
<style>
  .error{
    color: red !important;
  }
  </style>
@endsection


@section('header')
@include('includes.header')
@endsection

@section('content') 

<section class="login-page">
    <img src="{{asset('public/front_assets/images/login-pagebg.png')}}" alt="" class="login-pagebg">
    <div class="container">
   
      <div class="login-inr">
        <div class="login-paper">
        @include('includes.message')
          <div class="login-hdr">
            <h2>Reset Password</h2>
          </div>
  
          <div class="login-form">
            <form action="{{route('do.reset.password')}}" method="post" id="login_form">
              @csrf
              <input type="hidden" name="user_id" id="user_id" value="{{@$user->id}}">
              <input type="hidden" name="vcode" id="vcode" value="{{@$vcode}}">
              <div class="log-inpt">
                <label for="password" class="">Password</label>
                <input type="password" class="" name="password" id="password" autocomplete="current-password"  placeholder="" required/>
                <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword"></i>
              </div>
              <div class="log-inpt">
                <label for="confirm_password" class="">Confirm - Password</label>
                <input type="password" class="" name="confirm_password" id="password2" autocomplete="current-password"  placeholder="" required/>
                <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword2"></i>
              </div>
              
              <div class="log-btn-sec">
                <button type="submit" class="log-sbmt">Submit</button>
                
              </div>            
            </form>
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
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

      $(document).ready(function(){  
        $("#login_form").validate({
            rules:{
                password:{
                    required:true,
                    minlength:6,
                    maxlength:60,
                },
                confirm_password:{
                    required:true,
                    minlength:6,
                    maxlength:60,
                    equalTo:"#password",
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });
      });
  </script>
@endsection

