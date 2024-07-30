@extends('layouts.app')
@section('title','Success')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')

<!--pager-section end-->
<section class="block2 section_padding suc-bg">
    <div class="container" style="    margin-top: 8rem!important;
    margin-bottom: 4rem!important;">
        <div class="contact_section">
            <div class="row align-items-center" style="width:fit-content; margin: 0 auto;">
                <div class="col-lg-12">
                    <div class="parent-divddd">
                        <div class="mesg-cls">
                            <span class="img-span"><img src="{{asset('public/images/success.png')}}"
                                    alt="success"></span>
                            <h2 class="thankyou">Success !</h2>
                            @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                <p style="font-family: 'poppins';">{{ session('success') }}</p>
                            </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="signer ">
                                    <a href="{{ route('login') }}"
                                        class="sign-up-btn customer-signup-btn success_login ">Go to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
@include('includes.scripts')