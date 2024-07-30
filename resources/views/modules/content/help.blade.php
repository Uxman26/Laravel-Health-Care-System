@extends('layouts.app')
@section('title')
Hetero Health Care - Help
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
            	<h2>Help</h2>
            	<p>incase you need any support or to share feedback. Kindly contact us</p>
            </div>
        </div>
        
    <div class="empl">
            <div class="row">
                
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box bbxna1">
                        <span><img src="{{asset('public/front_assets/images/iconnn1.png')}}" alt=""></span>
                        @if(@Auth::user()->user_type == 'A' || @Auth::user()->user_type == 'AA')
                        <a href="{{route('content.user.guide.list')}}">User Guide Manual <img src="{{asset('public/front_assets/images/round_rr.png')}}" alt=""></a>
                        @else
                        <a href="{{route('content.user.guide')}}">User Guide Manual <img src="{{asset('public/front_assets/images/round_rr.png')}}" alt=""></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box bbxna1">
                        <span><img src="{{asset('public/front_assets/images/iconnn2.png')}}" alt=""></span>
                        <a href="{{route('content.contact.show')}}">Contact <img src="{{asset('public/front_assets/images/round_rr.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box bbxna1">
                        <span><img src="{{asset('public/front_assets/images/iconnn3.png')}}" alt=""></span>
                        <a href="{{route('content.remark')}}">Feedback <img src="{{asset('public/front_assets/images/round_rr.png')}}" alt=""></a>
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