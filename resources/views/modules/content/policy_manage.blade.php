@extends('layouts.app')
@section('title')
Hetero Health Care - Expence History
@endsection
@section('style')
@include('includes.style')
<style>
#for_user-error{
    color:red;
}
    </style>
@endsection
@section('header')
@include('includes.header')
@endsection
@section('content')

<section class="expense-inr d-flex w-100 justify-content-end align-items-strat"> 
    @include('includes.sidebar')
    <div class="right-page policies_areaa">
        <div class="r8-page-heading">
        @include('includes.message')
            <h2>Manage Policy</h2>
            <a href="{{route('content.policy')}}">Back</a>
        </div>
        
        <!---->
        <div class="empl write_to_us">
           <h1>Upload Policy Files</h1>
           <form action="{{route('content.policy.submit')}}" method="post" id="policy_form" enctype="multipart/form-data">
           @csrf
            <div class="row">
          
                <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                    <div class="fill-box">
                        <label for="">Supporting Document</label>
                        <div class="fill-box-file">
                            <input type="file" name="file_name" id="file_name"  accept="application/pdf" >
                            <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                        </div>
                        <div style="color:blue;display:none" id="file_count"> </div>
                    </div>

                    <div class="fill-box">
                        <label for="">Document Title</label>
                            <input type="text" name="title" id="title" placeholder="document title">
                        
                    </div> 
               
               
                    <div class="fill-box">
                        <label for="">Policy for User</label>
                           <select class="form-select" name="for_user" id="for_user">
                               <option value="">Select User</option>
                               <option value="E">Employee</option>
                               <option value="A">Admin Head</option>
                               <option value="AA">Admin Assistant</option>
                               <option value="HR">HR</option>
                               <option value="ACA">Accountant Asst</option>
                               <option value="ACH">Accountant Head</option>
                               <option value="AHY">Accountant HYD</option>

                            </select>
                    </div>
                </div>
                
                <div class="col-xl-12">
                    <button class="fill-submit" type="text" id="submit_button">Send </button>
                </div>
          
            </div>
           </form>
        </div>

    <!--new 30.03.23 end-->
</div>
</section>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
$(document).ready(function(){  
    // $('#submit_button').click(function(){
    //     alert('132');
    // })
        $("#policy_form").validate({
            rules:{
                for_user:{
                    required:true,
                    
                },
                title:{
                    required:true,
                    maxlength:40,
                    
                },
               
                
            },
            submitHandler:function(form){
              
                        if ($("#file_name").val() == '') {
                            $('#file_count').html('Please upload atleat 1 file');
                            $('#file_count').css('display','block');
                            $('#file_count').css('color','red');
                            return false;
                        } else {
                            $('#user_img_error').css('display', 'none');
                            form.submit();
                        }
                  
                },
        
        });

        $('#file_name').change(function(e){
           
            console.log(e.target.files.length);
            $('#file_count').html(e.target.files.length+' files uploaded');
            $('#file_count').css('display','block');
            $('#file_count').css('color','blue');

        })

        
    });
</script>
@endsection