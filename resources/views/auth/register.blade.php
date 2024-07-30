@extends('layouts.app')
@section('title')
Jdmea
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
    <img src="{{asset('public/front_assets/images/login-pagebg.png')}}" alt="" class="login-pagebg sign-bg">
    <div class="container">
    @include('includes.message')
      <div class="login-inr">
        <div class="login-paper">
          <div class="login-hdr">
            <h2>Create Account</h2>
            <p>Please fill in the below fields to continue</p> 
          </div>
  
          <div class="login-form">
            <form action="{{route('do.register')}}" method="post" id="reg_form">
              @csrf
              <div class="name">
                <div class="log-inpt">
                  <label for="first_name" class="">First Name</label>
                  <input type="text" name="first_name" id="first_name" placeholder="" >
                </div>
                <div class="log-inpt">
                  <label for="last_name" class="">Last Name</label>
                  <input type="text" name="last_name" id="last_name" placeholder="" >
                </div>
              </div>
              <div class="log-inpt">
                <label for="email" class="">Email address</label>
                <input type="email" name="email" id="email" placeholder="" >
              </div>
              <div class="log-inpt">
                <label for="phone" class="">Phone (Optional)</label>
                <input type="tel" name="phone" id="phone" placeholder="" >
              </div>
              <div class="name align-items-start">
                <div class="log-inpt">
                  <label for="password" class="">Password</label>
                  <input type="password" class="" name="password" id="password" autocomplete="current-password"  placeholder="" >
                  <i class="fa fa-eye-slash" aria-hidden="true"  id="togglePassword"></i>
                </div>
                <div class="log-inpt"> 
                  <label for="confpassword" class="">Confirm Password</label>
                  <input type="password" class="" name="password2" id="password2" autocomplete="current-password"  placeholder="" >
                  <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword2"></i>
                </div>
              </div>
              <div class="by-click">
                <p>by clicking submit, I understand and agree to Jdmea’s <a href="#">Privacy Notice</a> and <a href="#">Terms of Use</a> for creating an Account</p>
              </div>
              <div class="log-btn-sec">
              <button type="submit" class="log-sbmt">Submit</button>
                <span>or</span>
                <a href="{{route('login')}}" class="go-sign">Login your account</a>
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
        $("#reg_form").validate({
            rules:{
              first_name:{
                    required:true,
                    maxlength:30,
                },
                last_name:{
                    required:true,
                    maxlength:30,
                },
                email:{
                  required:true,
                    email:true,
                    maxlength:100,
                    remote:{
                            url: "{{route('check.email.unique')}}",
                            type: "GET",
                            data: {
                                    email: function() {
                                    return $( "#email" ).val();
                                    },
                                    _token:'{{csrf_token()}}',
                                }
                            }
				},
                phone:{
                      number:true,
                      minlength:8,
                      maxlength:15,
                      remote:{
                              url: "{{route('check.phone.unique')}}",
                              type: "GET",
                              data: {
                                  ph_number: function() {
                                      return $( "#phone" ).val();
                                      },
                                      _token:'{{csrf_token()}}',
                                  }
                              }
                },
                password:{
                    required:true,
                    minlength:6,
                    maxlength:60,
                },
                password2:{
                    required:true,
                    minlength:6,
                    equalTo:"#password",
                },
            },messages:{
                  email:{
                    remote:"Email is already registered",
                  },
                  phone:{
                    remote:"Number is already registered",
                  },

                },
            submitHandler:function(form){
                   form.submit();
                },
        
        });
        $("#first_name").keypress(function (e) { 
        //if the letter is not digit then display error and don't type anything 
        // if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) { 
        //     return false; 
        // } 
      
        if (e.which >= 65 && e.which <= 90 || e.which >= 97 && e.which <= 122 || e.which == 32) { 
            return true; 
        }else{
            return false;
        }
        });  

        $("#last_name").keypress(function (e) { 
            //if the letter is not digit then display error and don't type anything 
            if (e.which >= 65 && e.which <= 90 || e.which >= 97 && e.which <= 122 || e.which == 32) { 
            return true; 
        }else{
            return false;
        }
        }); 
      });
  </script>
@endsection

