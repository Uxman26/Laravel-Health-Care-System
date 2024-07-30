@extends('layouts.app')
@section('title')
Hetero Health Care - Policies
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
            	<h2>Policies</h2>
            	<!-- <p>16 Policies</p> -->
            </div>
            <a href="{{route('content.policy.edit')}}">Add New Policy</a>
        </div>
       
        @if(@$emp_poli->isNotEmpty())
            <div class="empl">
            <h3>Employee Policies</h3>
              
                <div class="row">
                @foreach(@$emp_poli as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}"  onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$admin_asst_poli->isNotEmpty())
            <div class="empl">
            <h3>Admin Asst. Policies</h3>
              
                <div class="row">
                @foreach(@$admin_asst_poli as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}" onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$hr_poli->isNotEmpty())
            <div class="empl">
            <h3>HR Policies</h3>
              
                <div class="row">
                @foreach(@$hr_poli as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}"  onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$acct_asst->isNotEmpty())
            <div class="empl">
            <h3>Accountant Asst. Policies</h3>
              
                <div class="row">
                @foreach(@$acct_asst as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}"  onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        
        @if(@$acct_head_poli->isNotEmpty())
            <div class="empl">
            <h3>Accountant Head. Policies</h3>
              
                <div class="row">
                @foreach(@$acct_head_poli as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}"  onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
                    </div> 
                    @endforeach
                </div>
               
            </div>
        @endif

        @if(@$acct_hyd_poli->isNotEmpty())
            <div class="empl">
            <h3>Accountant HYD. Policies</h3>
              
                <div class="row">
                @foreach(@$acct_hyd_poli as $key=>$data)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="policies_areaa_box">
                        <span><a href="{{URL::to('storage/app/public/policy/'.@$data->file_name)}}" target="_blank"><img src="{{asset('public/front_assets/images/pdf_icon.png')}}" alt=""></a></span>
                            <h3>{{@$data->file_name}}</h3>
                            <a href="{{route('content.policy.delete',['id'=>@$data->id])}}"  onclick="return confirm('are you sure want to delete this policy?')">Delete</a>
                        </div>
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