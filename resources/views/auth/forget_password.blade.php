@extends('layouts.app')
@section('title')
Expence Report
@endsection
@section('style')
@include('includes.style')
<style>
  .error{
    color: red !important;
  }
  </style>
@endsection



@section('content') 

<section class="log-paper d-flex justify-content-start align-items-strech">
        <div class="log-paper-left">
            <img src="{{asset('public/front_assets/images/log-lft-img.png')}}" alt="" class="log-lft-img">
            <div class="log-lft-inr">
                <a href="#" class="logo"><img src="{{asset('public/front_assets/images/logo1.png')}}" alt=""></a>
                <div class="log-lft-txt">
                    <h1>WELCOME</h1>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</p>
                </div>
                <h3>Lorem Ipsum . Lorem Ipsum . Lorem Ipsum</h3>
            </div>
        </div>
        <div class="log-paper-right">
            <div class="log-r8-inr">
              
                @include('includes.message')
                <h2>Forget Password</h2>
<p>Please use iconnect password to login into expense application.</p>
<p>To reset your password please visit to <a href="https://sso.heterohealthcare.com/iconnect/#/login">iconnect</a> </p>
                <!-- <p>Fill the details to access </p> -->
              <!--  <form action="{{route('employee.password.submit')}}" method="post" id="login_form" class="log-r8-frm">
                <input type="hidden" name="request_type" value="FP">
                  @csrf
                    <div class="log-frm-box mb-15">
                        <label for="id">Employee ID</label>
                        <input type="text" name="empID" id="empID" placeholder="Enter here" value="{{old('empID')}}">
                    </div>
                   
                    <a href="{{route('login')}}" class="forgot">Login</a>
                    <button type="submit" class="log-frm-btn" >Submit</button>
                </form>-->
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

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

      $(document).ready(function(){  

        $("#login_form").validate({
            rules:{
              empID:{
                    required:true,
                },
               
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

        
      });
  </script>
@endsection

