@extends('layouts.app')
@section('title')
Hetero Health Care - Change Password
@endsection
@section('style')
@include('includes.style')
@endsection
@section('header')
@include('includes.header')
@endsection
@section('content') 

<section class="expense-inr d-flex w-100 justify-content-end align-items-strat">
    @include('includes.sidebar')

    <div class="right-page"> <!-- new section starts here -->
       <div class="chng-ps-hd"> 
       @include('includes.message')
        <h2>Change Password</h2> 
        <p>Please enter your current password and New Password.</p>
       </div>      
       <div class="chng-ps-inr">
        <form action="{{route('employee.password.submit')}}" method="post" id="password_form">
            <input type="hidden" name="request_type" value="NP">
            @csrf
            <div class="chng-box">
                <label for="">Current Password</label>
                <input type="password" class="" name="old_password" id="password" autocomplete="current-password"  placeholder="" required/>
                <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword"></i>
            </div>
            <div class="chng-box">
                <label for="">New Password</label>
                <input type="password" class="" name="new_password" id="password2" autocomplete="current-password"  placeholder="" required/>
                <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword2"></i>
            </div>
            <div class="chng-box">
                <label for="">Confirm Password</label>
                <input type="password" class="" name="confirm_password" name="password3" id="password3" required/>
            </div>
            <button class="chng-btn" type="submit">Save and Continue</button>
        </form>
       </div>
    </div><!-- new section ends here -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>

      $(document).ready(function(){  
        $("#password_form").validate({
            rules:{
             
                old_password:{
                    required:true,
                remote:{
                        url: "{{route('check.password')}}",
                        type: "GET",
                        data: {
                            password: function() {
                                return $( "#password" ).val();
                                },
                            
                                _token:'{{csrf_token()}}',
                            }
                        },
                },
                new_password:{
                    required:true,
                    minlength:4,
                    maxlength:20,
                },
                confirm_password:{
                    required:true,
                    equalTo:'#password2',
                }


            },messages:{
                  
                  old_password:{ 
                    remote:"Please enter correct passord",
                    },
                    confirm_password:{ 
                    remote:"Please Enter same password as new password",
                    },


                },
            submitHandler:function(form){
                   form.submit(); 
                },
        
        });

        $('#dob').datepicker();
      });

      const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function (e) {
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
this.classList.toggle('fa-eye');
});

const togglePassword2 = document.querySelector('#togglePassword2');
const password2 = document.querySelector('#password2');
togglePassword2.addEventListener('click', function (e) {
const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
password2.setAttribute('type', type);
this.classList.toggle('fa-eye');
});

  </script>
    
@endsection