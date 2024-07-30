@extends('layouts.app')
@section('title')
Hetero Health Care - Expence History
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
    <div class="right-page policies_areaa">
        <div class="r8-page-heading">
        @include('includes.message')
            <h2>Feedback</h2>
            @if(auth()->user()->user_type == 'A' || auth()->user()->user_type == 'AA')
                <a href="{{route('content.remark.list')}}">Remarks List</a>
            @endif 
           
        </div>
        
        <!---->
        <div class="empl write_to_us">
           <h1>Write to us</h1>
           <form action="{{route('content.remark.submit')}}" method="post" id="remark_form">
               @csrf
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                	<textarea placeholder="Remark" name="remark"></textarea>
                </div>  
                
                <!-- <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                    <div class="fill-box">
                        <label for="">Supporting Document</label>
                        <div class="fill-box-file">
                            <input type="file">
                            <h3>Upload Document <img src="images/upload.png" alt=""></h3>
                        </div>
                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#myModal">4 File Uploaded</a>
                    </div>
                </div> -->
                
                <div class="col-xl-12">
                    <button class="fill-submit" type="text">Send</button>
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
        $("#remark_form").validate({
            rules:{
                remark:{
                    required:true,
                    maxlength:500,
                    
                },
               
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

       
        
    });
</script>
@endsection