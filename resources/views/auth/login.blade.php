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
                    <h1>EXPENSES</h1>
                    <p>Embark on Smart Expense Management by Hetero Healthcare Digital touch!</p>
                </div>
                <h3>Simplify, Approve, Compensate.</h3>
            </div>
        </div>
        <div class="log-paper-right">
            <div class="log-r8-inr">
              
                @include('includes.message')
                <h2>LOG IN</h2>
                <p>Fill the details to access </p>
                <form action="{{route('do.login')}}" method="post" id="login_form" class="log-r8-frm">
                    @csrf
                    
                    <div class="log-frm-box mb-15">
                        <label for="id">Employee ID</label>
                        <input type="text" name="empID" id="empID" placeholder="Enter here" value="{{old('empID')}}">
                    </div>
                    <div class="log-frm-box">
                        <label for="password" class="">Password</label>
                        <input type="password" name="password" autocomplete="current-password" id="id_password" placeholder="**********">
                        <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
                    </div>
                    <a href="{{route('forget.password')}}" class="forgot">Forgot Password</a>
                    <button type="submit" class="log-frm-btn" id="login_submit">Log In</button>
                </form>
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
                password:{
                    required:true,
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

        // $("body").on('click','#login_submit',function(){

        //     $('.api_error').hide();
        //     var userName = $('#empID').val();
        //     var password = $('#id_password').val();
        //     //console.log('login ',userName,password)

        //     var reqData = {
        //             "userName":userName,
        //             "password":password,
        //             "application":"login",
        //             "_token":"{{@csrf_token()}}",
        //             "jsonrpc": 2.0
        //         };

        //         axios.post('https://sso.heterohcl.com/stage/loginaction/login', reqData)
        //         .then(function (response) {
        //             if(response.data.status) {
        //                 console.log(response);

        //                 document.getElementById("name").value = response.data.user.name;
        //                 document.getElementById("personal_MOBILE").value = response.data.user.personal_MOBILE;
        //                 document.getElementById("designation").value = response.data.user.designation;
        //                 document.getElementById("department").value = response.data.user.department;
        //                 document.getElementById("division").value = response.data.user.division;

        //                 var form = document.getElementById("login_form");
        //                 form.submit();

        //             } else {
        //                 $('.api_error').show();
        //             }
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });


        // });

      });
  </script>
@endsection

