@extends('layouts.app')
@section('title')
Hetero Health Care - Expence History
@endsection
@section('style')
@include('includes.style')
<style>
.error{
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
    <div class="right-page">
        <div class="r8-page-heading">
        @include('includes.message')
            <h2>Manage Contact Us</h2>
            
        </div>
        
        <!---->
        <div class="empl write_to_us">
           <!-- <h1>Write to us</h1> -->
           <form action="{{route('content.contact.submit')}}" method="post" id="contact_form">
               @csrf
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                <div class="fill-box">
                    <label for="">Technical Email</label>
                	<!-- <textarea placeholder="Remark"></textarea> -->
                    <input type="textnox" name="email_1" id="email_1" value="{{@$contact->email_1}}">
                </div>

                <div class="fill-box">
                    <label for="">Technical Phone </label>
                	<!-- <textarea placeholder="Remark"></textarea> -->
                    <input type="textnox" name="phone_1" id="phone_1" value="{{@$contact->phone_1}}">
                </div>

                <div class="fill-box">
                    <label for=""> Admin Email</label>
                	<!-- <textarea placeholder="Remark"></textarea> -->
                    <input type="textnox" name="email_2" id="email_2" value="{{@$contact->email_2}}">
                </div>

                

                <div class="fill-box">
                    <label for=""> Admin Phone</label>
                	<!-- <textarea placeholder="Remark"></textarea> -->
                    <input type="textnox" name="phone_2" id="phone_2" value="{{@$contact->phone_2}}">
                </div>
                </div>
                
               
                
                <div class="col-xl-12">
                    <button class="fill-submit" type="text">Submit</button>
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
        $("#contact_form").validate({
            rules:{
                email_1:{
                    required:true,  
                    email:true,
                    maxlength:60,
                },
                email_2:{
                    required:true, 
                    email:true,
                    maxlength:60, 
                },
                phone_1:{
                    required:true, 
                    maxlength:15,  
                },
                phone_2:{
                    required:true,
                    maxlength:15,   
                },
               
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

        

        
    });
</script>

@endsection