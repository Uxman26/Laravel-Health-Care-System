@extends('layouts.app')
@section('title','Error')
@section('links')
@include('includes.links')
<style type="text/css">
  .main-header{
    margin-top: -50px;
  }

 /* .parent-divddd { 
    margin-left: 60px;
}*/
  
</style>
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content') 
 <section class="sign-up-body">
    <div class="container">
      <div class="container" style="text-align: center; margin-top: 50px;">
        <div class="parent-divddd">
           <div class="mesg-cls">
              <span class="img-span"><img src="{{asset('public/error.png')}}" alt="error"></span>
              <h2 class="thankyou">Opps !</h2>
              @if(Session::has('error'))
                 <div class="alert alert-success" role="alert">
                    <p style="font-family: 'poppins';">{{ Session::get('error') }}</p>
                 </div>
              @endif
              <div class="col-lg-12">
                 <div class="sign-up-box">
                    <a href="{{ route('login') }}" class="sign-up-btn customer-signup-btn success_login">Go to Login</a>
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
@endsection