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


@section('header')
@include('includes.header')
@endsection
@section('content') 

<section class="expense-inr d-flex w-100 justify-content-end align-items-strat">
@include('includes.sidebar')




    <div class="right-page">
        <div class="r8-page-heading">
        @include('includes.message')
            <h2>Expenses Report</h2>
            <p>Fill and Submit the weekly expenses form for further actions:</p>
            <h4>NOTE : GST charges are not reimbursed in case of no GST number</h4>
        </div>
        <form action="{{route('employee.report.submit')}}" method="post" id="report_form" enctype="multipart/form-data">
            @csrf
        <div class="empl">
           <h3>employee details</h3>
             
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Employee ID</label>
                        <h3>{{auth()->user()->empID}}</h3>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="emp_id" id="emp_id" value="{{auth()->user()->empID}}">
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Employee Name</label>
                        <h3>{{auth()->user()->name}}</h3>
                    </div>
                    <input type="hidden" name="emp_name" id="emp_name" value="{{auth()->user()->name}}">
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Designation</label>
                        <h3>{{auth()->user()->designation}}</h3>
                    </div>
                    <input type="hidden" name="designation" id="designation" value="{{auth()->user()->designation}}">
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Headquaters</label>
                        <h3>Hydrabaad</h3>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Division</label>
                        <h3>{{auth()->user()->division}}</h3>
                    </div>
                </div>
            </div>
           
        </div>


        <div class="exp-date">
            <h3>Select Date <img src="{{asset('public/front_assets/images/calendar-white.png')}}" alt=""></h3>
            <ul class="d-flex justify-content-start align-items-center">
                <li><label for="">11-08-2023</label></li>
                <li><label for="">12-08-2023</label></li>
                <li><label for="" class="active">13-08-2023</label></li>
                <li><label for="">14-08-2023</label></li>
                <li><label for="">15-08-2023</label></li>
                <li><label for="">16-08-2023</label></li>
                <li><label for="">17-08-2023</label></li>
            </ul>
        </div>
        <input type="hidden" name="start_date" id="start_date" >
        <input type="hidden" name="end_date" id="end_date" >


        <div class="r8-filler-inr">
           <div class="fill-inr-box fill1">
              
                <div class="row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box fill-date">
                            <label for="">Date</label>
                            <input type="text" placeholder="Enter Here" value="" name="day_date" id="day_date" readonly>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xl-4  col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Travelled From</label>
                            <input type="text" placeholder="Enter City Name" name="travel_from" id="travel_from">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Travelled To</label>
                            <input type="text" placeholder="Enter City Name" name="travel_to" id="travel_to" >
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Overnight at</label>
                            <input type="text" placeholder="Enter City Name" name="overnight_at" id="overnight_at" >
                        </div>
                    </div>
                </div>
            
           </div> 
           <div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Rail/Air</h4>
              <input type="hidden" id="rail_count" value="1">
                <div class="row rail_row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare" name="rail_base_fare[]" id="rail_base_fare_1" class="rail_base_fare" oninput="changeRail(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount" name="rail_gst_amount[]" id="rail_gst_amount_1" class="rail_gst_amount" oninput="changeRail(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total" name="rail_total[]" id="rail_total_1" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number" name="rail_gst_number[]" id="rail_gst_number_1">
                        </div>
                    </div>
                    <input type="hidden" name="rail_doc_count[]" id="rail_doc_count_1" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="rail_doc[]" id="rail_doc_1" onchange="chnageRailDoc(1,this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                            <span style="color:blue;display:none" id="rail_doc_1_count_show">   </span>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark" name="rail_remark[]" id="rail_remark_1">
                        </div>
                    </div>
                </div>


               
            
            <a href="javascript:;" id="rail_add_more" class="add-more">Add More</a>
           </div>

           <div class="fill-inr-box fill3">
            <div class="fill-top d-flex justify-content-start align-items-center">
                <h4><span></span>Taxi/Bus/Rickshaw</h4>

                   
            </div>           
              
                <div class="row taxi_row">
               
                <select class="form-select" aria-label="Default select example" name="taxi_select[]" id="taxi_select">
                    {{-- <option selected>Organization</option> --}}
                    <option value="1">Taxi</option>
                    <option value="2">Bus</option>
                    <option value="3">Rickshaw</option>
                  </select>
                 
                  <input type="hidden" id="taxi_count" value="1">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare"  name="taxi_base_fare[]" id="taxi_base_fare_1" oninput="changeTaxi(1)">
                        </div>
                    </div>
                    <div class="col-xl-2  col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="taxi_gst_amount[]" id="taxi_gst_amount_1" oninput="changeTaxi(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="taxi_total[]" id="taxi_total_1" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="taxi_gst_number[]" id="taxi_gst_number_1">
                        </div>
                    </div>
                    <input type="hidden" name="taxi_doc_count[]" id="taxi_doc_count_1" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="taxi_doc[]" id="taxi_doc_1" onchange="chnageTaxiDoc(1,this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="taxi_doc_1_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="taxi_remark[]" id="taxi_remark_1">
                        </div>
                    </div>
                </div>
            
            <a href="javascript:;" id="taxi_add_more" class="add-more">Add More</a>
           </div>

           <div class="fill-inr-box fill4 fill-grey">
            <h4><span></span>Hotel</h4>          
            <input type="hidden" id="hotel_count" value="1">
                <div class="row hotel_row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Hotel Name</label>
                            <input type="text" placeholder="Hotel Name"  name="hotel_name[]" id="hotel_name_1">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <input type="text" placeholder="City Name"  name="hotel_city[]" id="hotel_city_1">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)</label>
                            <input type="text" placeholder="Base Fare"  name="hotel_base_fare[]" id="hotel_base_fare_1" oninput="changeHotel(1)">
                            <span class="rem">*Per day Limit is 2000.00</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="hotel_gst_amount[]" id="hotel_gst_amount_1" oninput="changeHotel(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="hotel_total[]" id="hotel_total_1" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="hotel_gst_number[]" id="hotel_gst_number_1">
                        </div>
                    </div>
                    <input type="hidden" name="hotel_doc_count[]" id="hotel_doc_count_" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="hotel_doc[]" id="hotel_doc_1" onchange="chnageHotelDoc(1,this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="hotel_doc_1_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="hotel_remark[]" id="hotel_remark_1">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        
                    </div>
                </div>
            
            <a href="javascript:;" id="hotel_add_more" class="add-more">Add More</a>
           </div>


           <div class="fill-inr-box fill5">
            <h4><span></span>Laundry Charges</h4>          
              
                <div class="row laundry_row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Laundry Name</label>
                            <input type="text" placeholder="Laundry Name"  name="laundry_name" id="laundry_name">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <input type="text" placeholder="City Name"  name="laundry_city" id="laundry_city">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)</label>
                            <input type="text" placeholder="Base Fare"  name="laundry_base_fare" id="laundry_base_fare">
                            <span class="rem">*Per day Limit is 2000.00</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="laundry_gst_amount" id="laundry_gst_amount">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="laundry_total" id="laundry_total" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="laundry_gst_number" id="laundry_gst_number">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="laundry_doc[]" id="laundry_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                            
                        </div>
                        <span style="color:blue;display:none" id="laundry_doc_count_show">   </span>
                        
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="laundry_remark" id="laundry_remark" >
                        </div>
                    </div>
                </div>
            
           </div>



           <div class="fill-inr-box fill6 fill-grey">
            <h4><span></span>Breakfast</h4>          
              
                <div class="row">
                    <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount</label>
                            <input type="text" placeholder="Amount"  name="breakfast_amount" id="breakfast_amount">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="breakfast_doc[]" id="breakfast_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="breakfast_doc_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="breakfast_remark" id="breakfast_remark" >
                        </div>
                    </div>
                </div>
            
           </div>
           <div class="fill-inr-box fill6">
            <h4><span></span>Lunch</h4>          
              
                <div class="row">
                    <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount</label>
                            <input type="text" placeholder="Amount"  name="lunch_amount" id="lunch_amount">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="lunch_doc[]" id="lunch_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="lunch_doc_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="lunch_remark" id="lunch_remark">
                        </div>
                    </div>
                </div>
            
           </div>
           <div class="fill-inr-box fill6 fill-grey">
            <h4><span></span>Dinner</h4>          
              
                <div class="row">
                    <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount</label>
                            <input type="text" placeholder="Amount"  name="dinner_amount" id="dinner_amount">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="dinner_doc[]" id="dinner_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="dinner_doc_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="dinner_remark" id="dinner_remark">
                        </div>
                    </div>
                </div>
            
           </div>
           <div class="fill-inr-box fill5">
            <h4><span></span>Phone</h4>          
              
                <div class="row">
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Hotel Name</label>
                            <input type="text" placeholder="Hotel Name"  name="phone_name[]" id="phone_name">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <input type="text" placeholder="City Name"  >
                        </div>
                    </div> -->
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare (Exclude GST)</label>
                            <input type="text" placeholder="Base Fare"  name="phone_base_fare" id="phone_base_fare">
                            <span class="rem">*Per day Limit is 2000.00</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="phone_gst_amount" id="phone_gst_amount">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="phone_total" id="phone_total" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="phone_gst_number" id="phone_gst_number">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="phone_doc[]" id="phone_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="phone_doc_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="phone_remark" id="phone_remark">
                        </div>
                    </div>
                </div>
            
           </div>
           <div class="fill-inr-box fill5 fill-grey">
            <h4><span></span>Local Convayence</h4>          
              
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Local Name</label>
                            <input type="text" placeholder="Local Name"  name="local_name" id="local_name">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <input type="text" placeholder="City Name"  name="local_city" id="local_city">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)</label>
                            <input type="text" placeholder="Base Fare"  name="local_base_fare" id="local_base_fare">
                            <span class="rem">*Per day Limit is 2000.00</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="local_gst_amount" id="local_gst_amount">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="local_total" id="local_total" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="local_gst_number" id="local_gst_number">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file"  name="local_doc[]" id="local_doc" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="local_doc_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="local_remark" id="local_remark">
                        </div>
                    </div>
                </div>
            
           </div>
           <div class="fill-inr-box fill3">
            <div class="fill-top d-flex justify-content-start align-items-center">
                <h4><span></span>Miscellaneous</h4>

                <!-- <select class="form-select" aria-label="Default select example" >
                    <option selected>Organization</option>
                    <option value="1">Taxi</option>
                    <option value="2">Bus</option>
                    <option value="3">Rickshaw</option>
                  </select> -->
            </div>           
            <input type="hidden" id="misce_count" value="1">
                <div class="row misce_row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare"  name="misce_base_fare[]" id="misce_base_fare_1" oninput="changeMisce(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="misce_gst_amount[]" id="misce_gst_amount_1" oninput="changeMisce(1)">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="misce_total[]" id="misce_total_1" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="misce_gst_number[]" id="misce_gst_number_1">
                        </div>
                    </div>
                    <input type="hidden" name="misce_doc_count[]" id="misce_doc_count_1" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="misce_doc[]" id="misce_doc_1" onchange="chnageMisceDoc(1,this)"  data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="misce_doc_1_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="misce_remark[]" id="misce_remark_1">
                        </div>
                    </div>
                    <div class="col-xl-12">
                       
                    </div>
                </div>
            
            <a href="javascript:;" id="misce_add_more" class="add-more">Add More</a>
           </div>

           <div class="fill-inr-box fill-grand">
            <h2>Grand Total </h2>
            <div class="row">
                <div class="col-xl-12">
                    <div class="empl-box">
                        <input type="text" placeholder="Enter Here" name="grand_total_show" id="grand_total_show" value="00"  readonly>
                        <span> Rupees Only</span>
                        <h4>Attach receipt for each expenditure. Explain details of unusal items.Explain purpose of eah trip</h4>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12">
                    <div class="fill-box">
                        <label for="">City</label>
                        <input type="text" placeholder="Enter City Name"  name="day_city" id="day_city">
                    </div> 
                </div>
                <div class="col-xl-8 col-lg-7 col-md-8 col-sm-6 col-12">
                    <div class="fill-box">
                        <label for="">Purpose</label>
                        <input type="text" placeholder="Enter Purpose"  name="day_purpose" id="day_purpose">
                    </div> 
                </div>
                <div class="col-xl-12"> 
                    <button type="submit" class="fill-submit" type="text">Submit</button>
                </div>
            </div>
           </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#day_date').datepicker({
        maxDate:0,
        dateFormat:"yy-mm-dd",
    });

      $(document).ready(function(){  
        $("#report_form").validate({
            rules:{
                day_date:{
                     required:true,
                     
                },
                travel_from:{
                    required:true,
                    maxlength:60,
                },
                travel_to:{
                     required:true,
                     maxlength:60,
                },
                overnight_at:{
                     required:true,
                     maxlength:60,
                },
                day_city:{
                     required:true,
                     maxlength:60,
                },
                day_purpose:{
                     required:true,
                     maxlength:300,
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });
      });
  </script>

  <script>
       $('#laundry_base_fare,#laundry_gst_amount,#local_base_fare,#local_gst_amount,#phone_base_fare,#phone_gst_amount,#lunch_amount,#breafast_amount,#dinner_amount,.rail_base_fare,.rail_gst_amount').on("input", function(evt) {
        var self = $(this);
        var index = self.val().indexOf('.');
        var len = self.val().length;
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
        {
            if(index > 0){
                var charAfterdot= (len + 1)-index;
                if(charAfterdot > 3)
                {
                    return false;
                    evt.preventDefault();
                }
            }
            }
        });
      $('#laundry_base_fare,#laundry_gst_amount').on('input',function(){
         
          if(parseFloat($('#laundry_base_fare').val()) > 0)
          {
            var laun_base=parseFloat($('#laundry_base_fare').val());
          }else{
            var laun_base=0;
          }

          if(parseFloat($('#laundry_gst_amount').val()) > 0)
          {
            var laun_gst=parseFloat($('#laundry_gst_amount').val());
          }else{
            var laun_gst=0;
          }
      
          var laun_tot=0;
        
          laun_tot=laun_base + laun_gst;
          $('#laundry_total').val(laun_tot);
          cal_grand_tot();
          
      })

      $('#local_base_fare,#local_gst_amount').on('input',function(){
         
         if(parseFloat($('#local_base_fare').val()) > 0)
         {
           var local_base=parseFloat($('#local_base_fare').val());
         }else{
           var local_base=0;
         }

         if(parseFloat($('#local_gst_amount').val()) > 0)
         {
           var local_gst=parseFloat($('#local_gst_amount').val());
         }else{
           var local_gst=0;
         }
     
         var local_tot=0;
       
         local_tot=local_base + local_gst;
         $('#local_total').val(local_tot);
         cal_grand_tot();
         
     })

     $('#phone_base_fare,#phone_gst_amount').on('input',function(){
         
         if(parseFloat($('#phone_base_fare').val()) > 0)
         {
           var phone_base=parseFloat($('#phone_base_fare').val());
         }else{
           var phone_base=0;
         }

         if(parseFloat($('#phone_gst_amount').val()) > 0)
         {
           var phone_gst=parseFloat($('#phone_gst_amount').val());
         }else{
           var phone_gst=0;
         }
     
         var phone_tot=0;
       
         phone_tot=phone_base + phone_gst;
         $('#phone_total').val(phone_tot);
         cal_grand_tot();
         
     })

     //for rail/air
     
     function changeRail(id){
         var rail_base_price=parseFloat($('#rail_base_fare_'+id).val());
         var rail_gst_amount=parseFloat($('#rail_gst_amount_'+id).val());
        //  var rail_value=$("input[name='rail_base_fare[]']").val();
        //  console.log(rail_value);
         if(parseFloat($('#rail_base_fare_'+id).val()) > 0)
         {
           var rail_base=parseFloat($('#rail_base_fare_'+id).val());
         }else{
           var rail_base=0;
         }

         if(parseFloat($('#rail_gst_amount_'+id).val()) > 0)
         {
           var rail_gst=parseFloat($('#rail_gst_amount_'+id).val());
         }else{
           var rail_gst=0;
         }
     
         var rail_tot=0;
       
         rail_tot=rail_base + rail_gst;
         $('#rail_total_'+id).val(rail_tot);
        
         cal_grand_tot();
     }

     //for taxi section 
     function changeTaxi(id){
         var taxi_base_price=parseFloat($('#taxi_base_fare_'+id).val());
         var taxi_gst_amount=parseFloat($('#taxi_gst_amount_'+id).val());
      
        
         if(parseFloat($('#taxi_base_fare_'+id).val()) > 0)
         {
           var taxi_base=parseFloat($('#taxi_base_fare_'+id).val());
         }else{
           var taxi_base=0;
         }

         if(parseFloat($('#taxi_gst_amount_'+id).val()) > 0)
         {
           var taxi_gst=parseFloat($('#taxi_gst_amount_'+id).val());
         }else{
           var taxi_gst=0;
         }
     
         var taxi_tot=0;
       
         taxi_tot=taxi_base + taxi_gst;
         $('#taxi_total_'+id).val(taxi_tot);
        
         cal_grand_tot();
     }

     //for hotel
     
     function changeHotel(id){
         var hotel_base_price=parseFloat($('#hotel_base_fare_'+id).val());
         var hotel_gst_amount=parseFloat($('#hotel_gst_amount_'+id).val());
       
         if(parseFloat($('#hotel_base_fare_'+id).val()) > 0)
         {
           var hotel_base=parseFloat($('#hotel_base_fare_'+id).val());
         }else{
           var hotel_base=0;
         }

         if(parseFloat($('#hotel_gst_amount_'+id).val()) > 0)
         {
           var hotel_gst=parseFloat($('#hotel_gst_amount_'+id).val());
         }else{
           var hotel_gst=0;
         }
     
         var hotel_tot=0;
       
         hotel_tot=hotel_base + hotel_gst;
         $('#hotel_total_'+id).val(hotel_tot);
        
         cal_grand_tot();
     }

     //for Miscilleanous
     function changeMisce(id){
         var misce_base_price=parseFloat($('#misce_base_fare_'+id).val());
         var misce_gst_amount=parseFloat($('#misce_gst_amount_'+id).val());
      
        
         if(parseFloat($('#misce_base_fare_'+id).val()) > 0)
         {
           var misce_base=parseFloat($('#misce_base_fare_'+id).val());
         }else{
           var misce_base=0;
         }

         if(parseFloat($('#misce_gst_amount_'+id).val()) > 0)
         {
           var misce_gst=parseFloat($('#misce_gst_amount_'+id).val());
         }else{
           var misce_gst=0;
         }
     
         var misce_tot=0;
       
         misce_tot=misce_base + misce_gst;
         $('#misce_total_'+id).val(misce_tot);
        
         cal_grand_tot();
     }

      $('#lunch_amount,#breakfast_amount,#dinner_amount').on('input',function(){
        cal_grand_tot();
      });


      function cal_grand_tot(){

        if(parseFloat($('#laundry_base_fare').val()) > 0)
          {
            var laun_base=parseFloat($('#laundry_base_fare').val());
          }else{
            var laun_base=0;
          }

          if(parseFloat($('#laundry_gst_amount').val()) > 0)
          {
            var laun_gst=parseFloat($('#laundry_gst_amount').val());
          }else{
            var laun_gst=0;
          }
          if(parseFloat($('#lunch_amount').val()) > 0)
          {
            var lunch_amount=parseFloat($('#lunch_amount').val());
          }else{
            var lunch_amount=0;
          }
          
          if(parseFloat($('#breakfast_amount').val()) > 0)
          {
            var breakfast_amount=parseFloat($('#breakfast_amount').val());
          }else{
            var breakfast_amount=0;
          }
          if(parseFloat($('#dinner_amount').val()) > 0)
          {
            var dinner_amount=parseFloat($('#dinner_amount').val());
          }else{
            var dinner_amount=0;
          }

          if(parseFloat($('#local_base_fare').val()) > 0)
         {
           var local_base=parseFloat($('#local_base_fare').val());
         }else{
           var local_base=0;
         }

         if(parseFloat($('#local_gst_amount').val()) > 0)
         {
           var local_gst=parseFloat($('#local_gst_amount').val());
         }else{
           var local_gst=0;
         }

         if(parseFloat($('#phone_base_fare').val()) > 0)
         {
           var phone_base=parseFloat($('#phone_base_fare').val());
         }else{
           var phone_base=0;
         }

         if(parseFloat($('#phone_gst_amount').val()) > 0)
         {
           var phone_gst=parseFloat($('#phone_gst_amount').val());
         }else{
           var phone_gst=0;
         }

         //for rail calculation 
         
         var rail_count=parseInt($('#rail_count').val());
         var rail_all_total = 0;
         for(var i = 0; i < rail_count ; i++)
         {
             i_plus=i+1;
             if(parseFloat($('#rail_base_fare_'+i_plus).val()) > 0)
             {
                rail_all_total = rail_all_total + parseFloat($('#rail_base_fare_'+i_plus).val());
             }
             if(parseFloat($('#rail_gst_amount_'+i_plus).val()) > 0)
             {
                rail_all_total = rail_all_total + parseFloat($('#rail_gst_amount_'+i_plus).val());
             }
            
         }

         //for taxi calculation 
         
         var taxi_count=parseInt($('#taxi_count').val());
         var taxi_all_total = 0;
         for(var i = 0; i < taxi_count ; i++)
         {
             i_plus=i+1;
             if(parseFloat($('#taxi_base_fare_'+i_plus).val()) > 0)
             {
                taxi_all_total = taxi_all_total + parseFloat($('#taxi_base_fare_'+i_plus).val());
             }
             if(parseFloat($('#taxi_gst_amount_'+i_plus).val()) > 0)
             {
                taxi_all_total = taxi_all_total + parseFloat($('#taxi_gst_amount_'+i_plus).val());
             }
            
         }

          //for hotel calculation 
         
          var hotel_count=parseInt($('#hotel_count').val());
         var hotel_all_total = 0;
         for(var i = 0; i < hotel_count ; i++)
         {
             i_plus=i+1;
             if(parseFloat($('#hotel_base_fare_'+i_plus).val()) > 0)
             {
                hotel_all_total = hotel_all_total + parseFloat($('#hotel_base_fare_'+i_plus).val());
             }
             if(parseFloat($('#hotel_gst_amount_'+i_plus).val()) > 0)
             {
                hotel_all_total = hotel_all_total + parseFloat($('#hotel_gst_amount_'+i_plus).val());
             }
            
         }

         //for Misce calculation  
         
         var misce_count=parseInt($('#misce_count').val());
         var misce_all_total = 0;
         for(var i = 0; i < misce_count ; i++)
         {
             i_plus=i+1;
             if(parseFloat($('#misce_base_fare_'+i_plus).val()) > 0)
             {
                misce_all_total = misce_all_total + parseFloat($('#misce_base_fare_'+i_plus).val());
             }
             if(parseFloat($('#misce_gst_amount_'+i_plus).val()) > 0)
             {
                misce_all_total = misce_all_total + parseFloat($('#misce_gst_amount_'+i_plus).val());
             }
            
         }
     
         
          var grand_tot=0;
        
          grand_tot=laun_base + laun_gst + lunch_amount + breakfast_amount + dinner_amount + local_base + local_gst + phone_base + phone_gst + rail_all_total + taxi_all_total + hotel_all_total + misce_all_total;
          $('#grand_total_show').val(grand_tot);
      }
      </script>
  <script>
$('#rail_add_more').click(function(){
    var rail_count=parseInt($('#rail_count').val());
    var rail_count_plus=rail_count + 1;
    $('#rail_count').val(rail_count_plus);
    var rail_html="";
    rail_html=` <hr>
    <div class="row rail_row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare" name="rail_base_fare[]" id="rail_base_fare_${rail_count_plus}" class="rail_base_fare" oninput="changeRail(${rail_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount" name="rail_gst_amount[]" id="rail_gst_amount_${rail_count_plus}" class="rail_gst_amount" oninput="changeRail(${rail_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total" name="rail_total[]" id="rail_total_${rail_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number" name="rail_gst_number[]" id="rail_gst_number_${rail_count_plus}">
                        </div>
                    </div>
                    <input type="hidden" name="rail_doc_count[]" id="rail_doc_count_${rail_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="rail_doc[]" id="rail_doc_${rail_count_plus}" onchange="chnageRailDoc(${rail_count_plus},this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="rail_doc_${rail_count_plus}_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark" name="rail_remark[]" id="rail_remark_${rail_count_plus}">
                        </div>
                    </div>
                </div>`;

                $('.rail_row').append(rail_html);
})

$('#taxi_add_more').click(function(){
    var taxi_count=parseInt($('#taxi_count').val());
    var taxi_count_plus=taxi_count + 1;
    $('#taxi_count').val(taxi_count_plus);
    var taxi_html="";
    taxi_html=`<hr> <select class="form-select" aria-label="Default select example" name="taxi_select[]" id="taxi_select_${taxi_count_plus}">
                    <option selected>Organization</option>
                    <option value="1">Taxi</option>
                    <option value="2">Bus</option>
                    <option value="3">Rickshaw</option>
                  </select>
                 

                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare"  name="taxi_base_fare[]" id="taxi_base_fare_${taxi_count_plus}" oninput="changeTaxi(${taxi_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2  col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="taxi_gst_amount[]" id="taxi_gst_amount_${taxi_count_plus}" oninput="changeTaxi(${taxi_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="taxi_total[]" id="taxi_total_${taxi_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="taxi_gst_number[]" id="taxi_gst_number_${taxi_count_plus}">
                        </div>
                    </div>
                    <input type="hidden" name="taxi_doc_count[]" id="taxi_doc_count_${taxi_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="taxi_doc[]" id="taxi_doc_${taxi_count_plus}" onchange="chnageTaxiDoc(${taxi_count_plus},this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="taxi_doc_${taxi_count_plus}_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="taxi_remark[]" id="taxi_remark_${taxi_count_plus}">
                        </div>
                    </div>
                </div>`;

                $('.taxi_row').append(taxi_html);
})

$('#hotel_add_more').click(function(){
    var hotel_count=parseInt($('#hotel_count').val());
    var hotel_count_plus=hotel_count + 1;
    $('#hotel_count').val(hotel_count_plus);
    var hotel_html="";
    hotel_html=`<hr><div class="row hotel_row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Hotel Name</label>
                            <input type="text" placeholder="Hotel Name"  name="hotel_name[]" id="hotel_name_${hotel_count_plus}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <input type="text" placeholder="City Name"  name="hotel_city[]" id="hotel_city_${hotel_count_plus}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)</label>
                            <input type="text" placeholder="Base Fare"  name="hotel_base_fare[]" id="hotel_base_fare_${hotel_count_plus}" oninput="changeHotel(${hotel_count_plus})">
                            <span class="rem">*Per day Limit is 2000.00</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="hotel_gst_amount[]" id="hotel_gst_amount_${hotel_count_plus}" oninput="changeHotel(${hotel_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="hotel_total[]" id="hotel_total_${hotel_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="hotel_gst_number[]" id="hotel_gst_number_${hotel_count_plus}">
                        </div>
                    </div>
                    <input type="hidden" name="hotel_doc_count[]" id="hotel_doc_count_${hotel_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="hotel_doc[]" id="hotel_doc_${hotel_count_plus}" onchange="chnageHotelDoc(${hotel_count_plus},this)" data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="hotel_doc_${hotel_count_plus}_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="hotel_remark[]" id="hotel_remark_${hotel_count_plus}">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        
                    </div>
                </div>`;

                $('.hotel_row').append(hotel_html);
})

$('#misce_add_more').click(function(){
    var misce_count=parseInt($('#misce_count').val());
    var misce_count_plus=misce_count + 1;
    $('#misce_count').val(misce_count_plus);
    var misce_html=``;
    misce_html=`<hr><div class="row misce_row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare"  name="misce_base_fare[]" id="misce_base_fare_${misce_count_plus}" oninput="changeMisce(${misce_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="misce_gst_amount[]" id="misce_gst_amount_${misce_count_plus}" oninput="changeMisce(${misce_count_plus})">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="misce_total[]" id="misce_total_${misce_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="misce_gst_number[]" id="misce_gst_number_${misce_count_plus}">
                        </div>
                    </div>
                    <input type="hidden" name="misce_doc_count[]" id="misce_doc_count_${misce_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="misce_doc[]" id="misce_doc_${misce_count_plus}" onchange="chnageMisceDoc(${misce_count_plus},this)"  data-multiple-caption=""  accept="image/*" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="misce_doc_${misce_count_plus}_count_show">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="misce_remark[]" id="misce_remark_${misce_count_plus}">
                        </div>
                    </div>`;

                    $('.misce_row').append(misce_html);
})
      </script>

      <script>
          function count_image(e , show_count)
          {
              console.log(e);
            $(show_count).css('display','block');
            $(show_count).html(e.files.length+" Files Uploaded  ");
          }
        $("#laundry_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#laundry_doc_count_show');
           
        });

        $("#breakfast_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#breakfast_doc_count_show');
           
        });

        $("#lunch_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#lunch_doc_count_show');
           
        });

        $("#dinner_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#dinner_doc_count_show');
           
        });

        $("#phone_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#phone_doc_count_show');
           
        });

        $("#local_doc").change(function() {
            // multiImgPreview(this, 'laundry_doc_count_show');
            count_image(this, '#local_doc_count_show');
           
        });

        $('#laundry_doc_count_show').click(function(){
            console.log($('#laundry_doc').val());
        });

       

        function chnageRailDoc(id , even){
           console.log(even);
           $('#rail_doc_count_'+id).val(even.files.length);
            count_image(even, '#rail_doc_'+id+'_count_show');
        }

        function chnageTaxiDoc(id , even){
           console.log(even);
           $('#taxi_doc_count_'+id).val(even.files.length);
            count_image(even, '#taxi_doc_'+id+'_count_show');
        }

        function chnageHotelDoc(id , even){
           console.log(even);
           $('#hotel_doc_count_'+id).val(even.files.length);
            count_image(even, '#hotel_doc_'+id+'_count_show');
        }

        function chnageMisceDoc(id , even){
           console.log(even);
           $('#misce_doc_count_'+id).val(even.files.length);
            count_image(even, '#misce_doc_'+id+'_count_show');
        } 
        
        
          </script>
@endsection

