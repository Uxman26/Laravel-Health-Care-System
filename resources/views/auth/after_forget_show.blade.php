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
              
                {{--@include('includes.message') --}}
                <h2>Forget Password</h2>
                <p>Your request to the admin for a new password has been sent. You will receive an SMS with your password shortly </p>
                <a href="{{'login'}}" class="log-frm-btn btn btn-primary mt-3" id="login_submit">Done</a>
               
            </div>
        </div>
    </section>

@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')

@endsection

