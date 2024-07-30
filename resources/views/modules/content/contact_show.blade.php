@extends('layouts.app')
@section('title')
Hetero Health Care - Contact
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
            <div class="rab_n1">
            	<h2>Help > Contact</h2>
            	<p>Incase you need any support or to share feedback. Kindly contact us</p>
            </div>
            @if(auth()->user()->user_type == 'A' || auth()->user()->user_type == 'AA')
            <a href="{{route('content.contact.edit')}}">Edit Contact info</a>
            @endif
        </div>
        
        <div class="empl">
            <div class="row">
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="technical_teamm">
                  <h1>Technical Team</h1>
                  <h2> <img src="{{asset('public/front_assets/images/call.png')}}" alt="">{{@$contact->phone_1}}</h2>
                  <h2> <img src="{{asset('public/front_assets/images/emaill.png')}}" alt="">{{@$contact->email_1}}</h2>
                </div>
                
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="padding-top:30px">
                <div class="technical_teamm">
                  <h1>Admin Team</h1>
                  <h2> <img src="{{asset('public/front_assets/images/call.png')}}" alt="">{{@$contact->phone_2}}</h2>
                  <h2> <img src="{{asset('public/front_assets/images/emaill.png')}}" alt="">{{@$contact->email_2}}</h2>
                </div>
                
                </div>
                
            </div>
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

@endsection