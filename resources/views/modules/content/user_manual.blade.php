@extends('layouts.app')
@section('title')
Hetero Health Care - Guide
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

  <!--new 30.03.23-->
  <div class="right-page policies_areaa">
        <div class="r8-page-heading">
            <div class="rab_n1">
            	<h2>User Guide</h2>
            </div>
           
        </div>
       
        @if(@$emp_guide->isNotEmpty() && auth()->user()->user_type == 'E')
            <div class="empl">
            <h3>Employee User Guide</h3>
              
                <div class="row">
                @foreach(@$emp_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" download>
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                        </div>
                        </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        {{-- @if(@$admin_asst_guide->isNotEmpty() && auth()->user()->user_type == 'AA')
            <div class="empl">
            <h3>Admin Asst. Guide</h3>
              
                <div class="row">
                @foreach(@$admin_asst_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" target="_blank">
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                            
                        </div>
                    </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif --}}

        @if(@$hr_guide->isNotEmpty() && auth()->user()->user_type == 'HR')
            <div class="empl">
            <h3>HR Guide</h3>
              
                <div class="row">
                @foreach(@$hr_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" download>
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                        </div>
                        </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$acct_asst_guide->isNotEmpty() && auth()->user()->user_type == 'ACA')
            <div class="empl">
            <h3>Accountant Asst. Guide</h3>
              
                <div class="row">
                @foreach(@$acct_asst_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" download>
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                        </div>
                        </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        
        @if(@$acct_head_guide->isNotEmpty() && auth()->user()->user_type == 'ACH')
            <div class="empl">
            <h3>Accountant Asst. Guide</h3>
              
                <div class="row">
                @foreach(@$acct_head_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" download>
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                        </div>
                        </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$acct_hyd_guide->isNotEmpty() && auth()->user()->user_type == 'AHY')
            <div class="empl">
            <h3>Accountant Asst. Guide</h3>
              
                <div class="row">
                @foreach(@$acct_hyd_guide as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <a href="{{URL::to('storage/app/public/guide/'.@$data->file_name)}}" download>
                        <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                            <h3>User Guide {{@$key + 1}}</h3>
                        </div>
                        </a>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif
        
        
        <!-- <div class="empl">
           <h3>employee Policies</h3>
            <div class="row">
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="policies_areaa_box">
                        <span><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></span>
                        <h3>Policy 01</h3>
                        <a href="#">Delete</a>
                    </div>
                </div>
                
            </div>
        </div> -->

    </div>
    <!--new 30.03.23 end-->
</section>
@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')

@endsection