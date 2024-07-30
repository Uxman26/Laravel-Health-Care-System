@extends('layouts.app')
@section('title')
    Expence Report
@endsection
@section('style')
    @include('includes.style')
    <style>
        .error {
            color: red !important;
        }

        .success_mesgg {
            margin: 0 0 4px 0 !important;
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
            <form action="{{ route('employee.report.submit.final') }}" method="post" id="report_form"
                enctype="multipart/form-data">
                @csrf
                <div class="empl">
                    <h3>employee details</h3>
                    <input type="hidden" name="expense_detail_id" id="expense_detail_id">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                            <div class="empl-box">
                                <label for="">Employee ID</label>
                                <h3>{{ auth()->user()->empID }}</h3>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="emp_id" id="emp_id" value="{{ auth()->user()->empID }}">
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                            <div class="empl-box">
                                <label for="">Employee Name</label>
                                <h3>{{ auth()->user()->name }}</h3>
                            </div>
                            <input type="hidden" name="emp_name" id="emp_name" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                            <div class="empl-box">
                                <label for="">Designation</label>
                                <h3>{{ auth()->user()->designation }}</h3>
                            </div>
                            <input type="hidden" name="designation" id="designation"
                                value="{{ auth()->user()->designation }}">
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
                                <h3>{{ auth()->user()->division }}</h3>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="exp-date">
                    <h3 id="select_date_show">Select Date <img
                            src="{{ asset('public/front_assets/images/calendar-white.png') }}" alt=""></h3>
                    <ul class="d-flex justify-content-start align-items-center" id="day_date_show">
                        <!-- <li><label for="" id="day1_show">11-08-2023</label></li>
                        <li><label for="" id="day2_show">12-08-2023</label></li>
                        <li><label for="" id="day3_show" class="active">13-08-2023</label></li>
                        <li><label for="" id="day4_show">14-08-2023</label></li>
                        <li><label for="" id="day5_show">15-08-2023</label></li>
                        <li><label for="" id="day6_show">16-08-2023</label></li>
                        <li><label for="" id="day7_show" >17-08-2023</label></li> -->
                    </ul>
                </div>
                <input type="hidden" name="start_date" id="start_date">
                <input type="hidden" name="end_date" id="end_date">


                <div class="r8-filler-inr">
                    <div class="fill-inr-box fill1">

                        <div class="row">
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="fill-box fill-date">
                                    <label for="">Date *</label>
                                    <input type="text" placeholder="select date" value="{{ @$day_date_send }}"
                                        name="day_date" id="day_date" readonly>
                                    <label id="day_date-error" class="error" for="day_date"></label>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                            </div>
                            <div class="col-xl-1 col-lg-4 col-md-4 col-sm-4 col-12">
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 justify-content-end">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:;" id="no_expense_modal" class="btn btn-primary ms-auto"
                                        type="">No Expense</a>
                                    <a href="javascript:;" id="total_expense_modal" class="btn btn-danger ms-auto"
                                        type="">Expense +|-</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xl-4  col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="fill-box">
                                    <label for="">Travelled From *</label>
                                    <input type="text" placeholder="Enter City Name" name="travel_from"
                                        id="travel_from">
                                    <label id="travel_from-error" class="error" for="travel_from"></label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="fill-box">
                                    <label for="">Travelled To *</label>
                                    <input type="text" placeholder="Enter City Name" name="travel_to" id="travel_to">
                                    <label id="travel_to-error" class="error" for="travel_to"></label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="fill-box">
                                    <label for="">Overnight at</label>
                                    <input type="text" placeholder="Enter City Name" name="overnight_at"
                                        id="overnight_at">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="fill-inr-box fill2 fill-grey for_cross_iconn">
                        <h4><span></span> Rail/Air</h4>

                        <input type="hidden" id="rail_count" value="1">
                        <input type="hidden" id="rail_already_ids" name="rail_already_ids">
                        <div class="row rail_row">
                            <input type="hidden" value="1" name="rail_false_id[]" id="rail_false_id_1">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Base Fare *</label>
                                    <input type="text" placeholder="Base Fare" name="rail_base_fare[]"
                                        id="rail_base_fare_1" class="rail_base_fare" oninput="changeRail(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Amount *</label>
                                    <input type="text" placeholder="GST Amount" name="rail_gst_amount[]"
                                        id="rail_gst_amount_1" class="rail_gst_amount" oninput="changeRail(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total *</label>
                                    <input type="text" placeholder="Total" name="rail_total[]" id="rail_total_1"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Number *</label>
                                    <input type="text" placeholder="GST Number" name="rail_gst_number[]"
                                        id="rail_gst_number_1" class="gst_validat">
                                </div>
                            </div>
                            <input type="hidden" name="rail_doc_count[]" id="rail_doc_count_1">
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document * </label>
                                    <div class="fill-box-file">
                                        <input type="file" name="rail_doc[]" id="rail_doc_1"
                                            onchange="chnageRailDoc(1,this)" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                    <span style="color:blue;display:none" id="rail_doc_1_count_show"
                                        onclick="Show_Doc_Add(1,'R','rail_doc_1_count_show')"> </span>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="rail_remark[]" id="rail_remark_1">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_rail_submit_msg"></span>



                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="rail_add_more" class="add-more">Add More</a>
                            <a href="javascript:;" id="rail_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="fill-inr-box fill3 ">
                        <div class="fill-top d-flex justify-content-start align-items-center for_cross_iconn">
                            <h4><span></span>Taxi/Bus/Rickshaw</h4>
                        </div>

                        <input type="hidden" id="taxi_count" value="1">
                        <input type="hidden" id="taxi_already_ids" name="taxi_already_ids">
                        <div class="row taxi_row">
                            <input type="hidden" value="1" name="taxi_false_id[]" id="taxi_false_id_1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="fill-box">
                                    <select class="form-select taxi_selet" aria-label="Default select example"
                                        name="taxi_select[]" id="taxi_select_1" onchange="chnag_taxi_select(1)">
                                        <option value="" selected>Select Type</option>
                                        <option value="1">Taxi</option>
                                        <option value="2">Bus</option>
                                        <option value="3">Rickshaw</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Base Fare *</label>
                                    <input type="text" placeholder="Base Fare" class="only_number"
                                        name="taxi_base_fare[]" id="taxi_base_fare_1" oninput="changeTaxi(1)">
                                </div>
                            </div>
                            <div class="col-xl-4  col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="" id="taxi_show_gst_amt_1">GST Amount *</label>
                                    <input type="text" placeholder="GST Amount" class="only_number"
                                        name="taxi_gst_amount[]" id="taxi_gst_amount_1" oninput="changeTaxi(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total</label>
                                    <input type="text" placeholder="Total" name="taxi_total[]" id="taxi_total_1"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="" id="taxi_show_gst_no_1">GST Number *</label>
                                    <input type="text" placeholder="GST Number" name="taxi_gst_number[]"
                                        id="taxi_gst_number_1" class="gst_validat">
                                </div>
                            </div>
                            <input type="hidden" name="taxi_doc_count[]" id="taxi_doc_count_1">
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="taxi_doc[]" id="taxi_doc_1"
                                            onchange="chnageTaxiDoc(1,this)" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="taxi_doc_1_count_show"
                                    onclick="Show_Doc_Add(1,'T','taxi_doc_1_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="taxi_remark[]" id="taxi_remark_1">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_taxi_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="taxi_add_more" class="add-more">Add More</a>
                            <a href="javascript:;" id="taxi_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>

                    </div>

                    <div class="fill-inr-box fill4 fill-grey for_cross_iconn">
                        <h4><span></span>Hotel</h4>

                        <input type="hidden" id="hotel_count" value="1">
                        <input type="hidden" id="hotel_already_ids" name="hotel_already_ids">
                        <div class="row hotel_row">
                            <input type="hidden" value="1" name="hotel_false_id[]" id="hotel_false_id_1">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Hotel Name *</label>
                                    <input type="text" placeholder="Hotel Name" name="hotel_name[]"
                                        id="hotel_name_1">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">City *</label>
                                    <input type="text" placeholder="City Name" name="hotel_city[]" id="hotel_city_1">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Fare (Exclude GST)</label>
                                    <input type="text" placeholder="Base Fare" class="only_number"
                                        name="hotel_base_fare[]" id="hotel_base_fare_1" oninput="changeHotel(1)">
                                    <!-- <span class="rem">*Per day Limit is 2000.00</span> -->
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Amount *</label>
                                    <input type="text" placeholder="GST Amount" class="only_number"
                                        name="hotel_gst_amount[]" id="hotel_gst_amount_1" oninput="changeHotel(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total</label>
                                    <input type="text" placeholder="Total" name="hotel_total[]" id="hotel_total_1"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Number *</label>
                                    <input type="text" placeholder="GST Number" name="hotel_gst_number[]"
                                        id="hotel_gst_number_1" class="gst_validat">
                                </div>
                            </div>
                            <input type="hidden" name="hotel_doc_count[]" id="hotel_doc_count_1">
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="hotel_doc[]" id="hotel_doc_1"
                                            onchange="chnageHotelDoc(1,this)" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="hotel_doc_1_count_show"
                                    onclick="Show_Doc_Add(1,'H','hotel_doc_1_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="hotel_remark[]"
                                        id="hotel_remark_1">
                                </div>
                            </div>
                            <div class="col-xl-12">

                            </div>
                        </div>


                        <span class="success_mesgg" id="after_hotel_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="hotel_add_more" class="add-more">Add More</a>
                            <a href="javascript:;" id="hotel_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="fill-inr-box fill5 for_cross_iconn">
                        <h4><span></span>Laundry Charges</h4>

                        <input type="hidden" id="laundry_already_ids" name="laundry_already_ids">
                        <div class="row laundry_row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Laundry Name *</label>
                                    <input type="text" placeholder="Laundry Name" name="laundry_name"
                                        id="laundry_name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">City *</label>
                                    <input type="text" placeholder="City Name" name="laundry_city" id="laundry_city">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Fare (Exclude GST) *</label>
                                    <input type="text" placeholder="Base Fare" name="laundry_base_fare"
                                        id="laundry_base_fare">
                                    <!-- <span class="rem">*Per day Limit is 2000.00</span> -->
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Amount</label>
                                    <input type="text" placeholder="GST Amount" name="laundry_gst_amount"
                                        id="laundry_gst_amount">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total</label>
                                    <input type="text" placeholder="Total" name="laundry_total" id="laundry_total"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Number</label>
                                    <input type="text" placeholder="GST Number" name="laundry_gst_number"
                                        id="laundry_gst_number" class="gst_validat">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="laundry_doc[]" id="laundry_doc"
                                            data-multiple-caption="" accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>

                                </div>
                                <span style="color:blue;display:none" id="laundry_doc_count_show"
                                    onclick="Show_Doc_Add(1,'L','laundry_doc_count_show')"> </span>

                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="laundry_remark"
                                        id="laundry_remark">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_laundry_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="laundry_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>


                    </div>



                    <div class="fill-inr-box fill6 fill-grey for_cross_iconn">
                        <h4><span></span>Breakfast</h4>

                        <input type="hidden" id="breakfast_already_ids" name="breakfast_already_ids">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Amount *</label>
                                    <input type="text" placeholder="Amount" name="breakfast_amount"
                                        id="breakfast_amount">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="breakfast_doc[]" id="breakfast_doc"
                                            data-multiple-caption="" accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="breakfast_doc_count_show"
                                    onclick="Show_Doc_Add(1,'B','breakfast_doc_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="breakfast_remark"
                                        id="breakfast_remark">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_breakfast_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="breakfast_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fill-inr-box fill6 for_cross_iconn">
                        <h4><span></span>Lunch</h4>

                        <input type="hidden" id="lunch_already_ids" name="lunch_already_ids">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Amount *</label>
                                    <input type="text" placeholder="Amount" name="lunch_amount" id="lunch_amount">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="lunch_doc[]" id="lunch_doc" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="lunch_doc_count_show"
                                    onclick="Show_Doc_Add(1,'LU','lunch_doc_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="lunch_remark" id="lunch_remark">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_lunch_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="lunch_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fill-inr-box fill6 fill-grey for_cross_iconn">
                        <h4><span></span>Dinner</h4>

                        <input type="hidden" id="dinner_already_ids" name="dinner_already_ids">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Amount *</label>
                                    <input type="text" placeholder="Amount" name="dinner_amount" id="dinner_amount">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="dinner_doc[]" id="dinner_doc"
                                            data-multiple-caption="" accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="dinner_doc_count_show"
                                    onclick="Show_Doc_Add(1,'D','dinner_doc_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="dinner_remark" id="dinner_remark">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_dinner_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="dinner_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fill-inr-box fill5 for_cross_iconn">
                        <h4><span></span>Phone</h4>

                        <input type="hidden" id="phone_already_ids" name="phone_already_ids">
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
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Base Fare (Exclude GST) *</label>
                                    <input type="text" placeholder="Base Fare" name="phone_base_fare"
                                        id="phone_base_fare">
                                    <!-- <span class="rem">*Per day Limit is 2000.00</span> -->
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Amount</label>
                                    <input type="text" placeholder="GST Amount" name="phone_gst_amount"
                                        id="phone_gst_amount">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total</label>
                                    <input type="text" placeholder="Total" name="phone_total" id="phone_total"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">GST Number</label>
                                    <input type="text" placeholder="GST Number" name="phone_gst_number"
                                        id="phone_gst_number" class="gst_validat">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="phone_doc[]" id="phone_doc" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="phone_doc_count_show"
                                    onclick="Show_Doc_Add(1,'P','phone_doc_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="phone_remark" id="phone_remark">
                                </div>
                            </div>
                        </div>

                        <span class="success_mesgg" id="after_phone_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="phone_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- local convence is commented -->
                    {{-- <div class="fill-inr-box fill5 fill-grey for_cross_iconn">
            <h4><span></span>Local Convayence</h4> 
            
            <input type="hidden" id="local_already_ids" name="local_already_ids">
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
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST) *</label>
                            <input type="text" placeholder="Base Fare"  name="local_base_fare" id="local_base_fare">
                            <!-- <span class="rem">*Per day Limit is 2000.00</span> -->
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount"  name="local_gst_amount" id="local_gst_amount">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="local_total" id="local_total" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="local_gst_number" id="local_gst_number"   class="gst_validat">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document *</label>
                            <div class="fill-box-file">
                                <input type="file"  name="local_doc[]" id="local_doc" data-multiple-caption=""  accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="{{asset('public/front_assets/images/upload.png')}}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="local_doc_count_show" onclick="Show_Doc_Add(1,'LC','local_doc_count_show')">   </span>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <input type="text" placeholder="Remark"  name="local_remark" id="local_remark">
                        </div>
                    </div>
                </div>
               
                <span class="success_mesgg" id="after_local_submit_msg"></span>
                <div class="other_buttons other-repeat">
                <a href="javascript:;" id="local_from_submit" class="add-more save_item">Save</a>
                </div>
                <div class="clearfix"></div>
           </div> --}}
                    <!-- local convence is commented -->
                    <div class="fill-inr-box fill3">
                        <div class="fill-top d-flex justify-content-start align-items-center for_cross_iconn">
                            <h4><span></span>Miscellaneous</h4>


                            <!-- <select class="form-select" aria-label="Default select example" >
                            <option selected>Organization</option>
                            <option value="1">Taxi</option>
                            <option value="2">Bus</option>
                            <option value="3">Rickshaw</option>
                          </select> -->
                        </div>
                        <input type="hidden" id="misce_count" value="1">
                        <input type="hidden" id="misce_already_ids" name="misce_already_ids">
                        <div class="row misce_row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="fill-box">
                                    <select class="form-select misce_selt" aria-label="Default select example"
                                        name="misce_select[]" id="misce_select_1" onchange="misce_select_function('1')">
                                        <option value="O" selected>Others</option>
                                        <option value="F">Food</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="1" name="misce_false_id[]" id="misce_false_id_1">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Base Fare *</label>
                                    <input type="text" placeholder="Base Fare" class="only_number"
                                        name="misce_base_fare[]" id="misce_base_fare_1" oninput="changeMisce(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 show_hide_misce_1">
                                <div class="fill-box">
                                    <label for="">GST Amount</label>
                                    <input type="text" placeholder="GST Amount" class="only_number"
                                        name="misce_gst_amount[]" id="misce_gst_amount_1" oninput="changeMisce(1)">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Total</label>
                                    <input type="text" placeholder="Total" name="misce_total[]" id="misce_total_1"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 show_hide_misce_1">
                                <div class="fill-box">
                                    <label for="">GST Number</label>
                                    <input type="text" placeholder="GST Number" name="misce_gst_number[]"
                                        id="misce_gst_number_1" class="gst_validat">
                                </div>
                            </div>
                            <input type="hidden" name="misce_doc_count[]" id="misce_doc_count_1">
                            <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Supporting Document *</label>
                                    <div class="fill-box-file">
                                        <input type="file" name="misce_doc[]" id="misce_doc_1"
                                            onchange="chnageMisceDoc(1,this)" data-multiple-caption=""
                                            accept="image/*,application/pdf" multiple>
                                        <h3>Upload Document <img
                                                src="{{ asset('public/front_assets/images/upload.png') }}"
                                                alt=""></h3>
                                    </div>
                                </div>
                                <span style="color:blue;display:none" id="misce_doc_1_count_show"
                                    onclick="Show_Doc_Add(1,'M','misce_doc_1_count_show')"> </span>
                            </div>
                            <div class="col-xl-12">
                                <div class="fill-box mb-30">
                                    <label for="">Remark</label>
                                    <input type="text" placeholder="Remark" name="misce_remark[]"
                                        id="misce_remark_1">
                                </div>
                            </div>
                            <div class="col-xl-12">

                            </div>
                        </div>
                        <span class="success_mesgg" id="after_misce_submit_msg"></span>
                        <div class="other_buttons other-repeat">
                            <a href="javascript:;" id="misce_add_more" class="add-more">Add More</a>
                            <a href="javascript:;" id="misce_from_submit" class="add-more save_item">Save</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="fill-inr-box fill-grand">
                        <h2>Grand Total </h2>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="empl-box">
                                    <input type="text" placeholder="Enter Here" name="grand_total_show"
                                        id="grand_total_show" value="00" readonly>
                                    <span> Rupees Only</span>
                                    <h4>Attach receipt for each expenditure. Explain details of unusual items.Explain
                                        purpose of each trip</h4>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">City *</label>
                                    <input type="text" placeholder="Enter City Name" name="day_city" id="day_city">
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-6 col-12">
                                <div class="fill-box">
                                    <label for="">Purpose *</label>
                                    <input type="text" placeholder="Enter Purpose" name="day_purpose"
                                        id="day_purpose">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" class="fill-submit" type="text">Save</button>
                            </div>


                        </div>
                    </div>
            </form>
        </div>
        <div class="col-xl-12 submit_asll_wk">
            <a href="javascript:;" id="submit_week_form" class="btn btn-primary fill-submit" type="text">Submit
                Weekly Report</a>
        </div>
        </div>
    </section>

    <form action="{{ route('employee.week.report.submit') }}" method="post" id="submit_master_form">
        @csrf
        <input type="hidden" name="expense_master_id" id="expense_master_id"
            value="{{ @$expense->expense_master_id }}">

    </form>


    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Supporting Documents </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body for_pop_sld" id="showing_all_doc">
                    <div class="owl-carousel owl-theme popup_images_slider">
                        <!-- <div class="item">
                        <img src="{{ asset('public/front_assets/images/log-lft-img.png') }}" alt="">
                    </div>
                    
                    <div class="item">
                         <img src="{{ asset('public/front_assets/images/favicon.png') }}" alt="">
                    </div>
                    
                    <div class="item">
                         <img src="{{ asset('public/front_assets/images/hd-r8-img.png') }}" alt="">
                    </div> -->



                    </div>
                </div>
                <!-- Modal body end-->

            </div>
        </div>
    </div>
    <div class="modal" id="myExpenseModal">
        <div class="modal-dialog mx-auto" style="width:50% !important">
            <div class="modal-content">
                <div class="modal-body " id="">
                    <div class="row p-5">
                        <div class="form-group col-md-12">
                            <label for="">Select Type</label>
                            <select name="no_expense_type" class="form-control col-md-4" id="no_expense_type">
                                <option value="Leave">Leave</option>
                                <option value="Holiday">Holiday</option>
                            </select>
                            <label id="no_expense_type-error" class="error" for="no_expense_type"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="no_expense" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myTotalExpenseModal">
        <div class="modal-dialog mx-auto" style="width:50% !important">
            <div class="modal-content">
                <div class="modal-body " id="">
                    <div class="row p-5">
                        <div class="form-group col-md-12">
                            <label for="">Select Type</label>
                            <select name="expense_type" class="form-control col-md-4" id="expense_type">
                                <option value="Addition">Addition</option>
                                <option value="Subtraction">Subtraction</option>
                            </select>
                            <label id="expense_type-error" class="error" for="expense_type"></label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Enter Amount</label>
                            <input type="number" name="expense_amount" class="form-control col-md-4" id="expense_amount">
                            <label id="expense_amount-error" class="error" for="expense_amount"></label>
                        </div>
                        <input type="hidden" name="expense_data_count[]" id="expense_data_count_1">
                        <div class="form-group col-md-12">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="expense_supporting_document[]" id="expense_supporting_document" onchange="chnageExpenseDataDoc(1,this)" data-multiple-caption="" accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="http://localhost/heterohealthcare/public/front_assets/images/upload.png" alt=""></h3>
                            </div>
                            <label id="expense_supporting_document-error" class="error" for="expense_supporting_document"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="expense" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('includes.footer')
@endsection

@section('script')
    @include('includes.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#no_expense_modal').click(function() {
                $('#myExpenseModal').modal('show');
            });
            $('#total_expense_modal').click(function() {
                $('#myTotalExpenseModal').modal('show');
            });
            $("body").on('click', '.save_item', function() {
                $(this).parent().parent().find('.success_mesgg').html(
                    '<div><span class="spinner-grow text-success spinner-grow-sm"></span> Saving...</div>'
                );
                $(this).parent().parent().find('.success_mesgg').show();
            });
        });
        // $('#taxi_select_1').change(function(){
        //     alert($('#taxi_select_1').val()); 
        //     var taxi_check_select=$("input[name='taxi_select[]']").map(function(){return $(this).val();}).get();
        //     console.log(taxi_check_select);
        //     var taxo=$(".taxi_selet").map(function(){return $(this).val();}).get();
        //     console.log(taxo);
        // })

        $('#submit_week_form').click(function() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            // alert(start_date,end_date)
            if (start_date == '' || end_date == '') {
                swal('Please select Date');
                return false;
            }
            //   if(confirm('Do you want to submit the expense report for approval for '+start_date+' to '+end_date+' ? Once send for approval you can not make any changes for this week.') == true)
            //   {
            //   $('#submit_master_form').submit();
            //   }else{
            //       false;
            //   }

            swal({
                    text: 'Do you want to submit the expense report for approval for ' + start_date + ' to ' +
                        end_date + ' ? Once send for approval you can not make any changes for this week.',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    background: '#28a745',
                })
                .then((willDelete) => {
                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                    if (willDelete) {
                        $('#submit_master_form').submit();
                    }
                });

            // $('#submit_master_form').submit();
        })

        function change_day_date(date) {
            var re_url = "{{ route('employee.day.date.change', ['date' => 'pass_date']) }}";
            re_url = re_url.replace('pass_date', date);
            window.location.assign(re_url);
        }



        $('#day_date').datepicker({
            maxDate: 0,
            dateFormat: "dd-mm-yy",
        });

        $('#day_date').change(function() {
            var day_date = $('#day_date').val();
            // alert(day_date);
            $.ajax({
                url: "{{ route('get.week.date') }}",
                dataType: 'json',
                data: {
                    day_date: day_date
                },
                type: 'get',
                // cache: false,
                // processData: false,
                // contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.day_date_error == 'found') {
                        $('#day_date').val('');
                        $('#select_date_show').hide();
                        // $('#day_date_show').html('');
                        swal("You can't add report on " + resp.selected_date +
                            " as this date weekly report is in process of approval already");
                        return false;
                    }
                    var date_html = '';

                    if (resp.day1 != null) {
                        date_html +=
                            `<li ><label for="" id="day1_show" onclick="change_day_date('${resp.day1}')"`;
                        if (resp.day1 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day1 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day1}</label></li>`;
                    }
                    if (resp.day2 != null) {
                        date_html +=
                            `<li ><label for="" id="day2_show" onclick="change_day_date('${resp.day2}')"`;
                        if (resp.day2 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day2 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day2}</label></li>`;
                    }
                    if (resp.day3 != null) {

                        date_html +=
                            `<li><label for="" id="day3_show" onclick="change_day_date('${resp.day3}')"`;
                        if (resp.day3 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day3 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day3}</label></li>`;
                    }
                    if (resp.day4 != null) {
                        date_html +=
                            `<li><label for="" id="day4_show" onclick="change_day_date('${resp.day4}')"`;
                        if (resp.day4 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day4 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day4}</label></li>`;
                    }
                    if (resp.day5 != null) {

                        date_html +=
                            `<li><label for="" id="day5_show" onclick="change_day_date('${resp.day5}')"`;
                        if (resp.day5 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day5 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day5}</label></li>`;

                    }
                    if (resp.day6 != null) {
                        date_html +=
                            `<li><label for="" id="day6_show" onclick="change_day_date('${resp.day6}')"`;
                        if (resp.day6 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day6 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day6}</label></li>`;
                    }
                    if (resp.day7 != null) {
                        date_html +=
                            `<li><label for="" id="day7_show" onclick="change_day_date('${resp.day7}')"`;
                        if (resp.day7 == resp.selected_date) {
                            date_html += `class="active"`;
                        }
                        if (resp.is_day7 == 'yes') {
                            date_html += `style="background-color:#fdff908c"`;
                        }
                        date_html += `>${resp.day7}</label></li>`;
                    }
                    $('#day_date_show').html(date_html);

                    $('#select_date_show').show();

                    $('#start_date').val(resp.start_week_date);
                    $('#end_date').val(resp.end_week_date);

                    if (resp.day_error == 'inserted') {
                        // swal('You have already inserted to in this date,Please try to edit it');
                        // var re_url="{{ route('employee.edit.report', ['id' => 'pass_id']) }}";
                        // re_url=re_url.replace('pass_id',resp.expense_detail_id);
                        // window.location.assign(re_url);

                        swal({
                                text: "You have already inserted to in this date,Please try to edit it",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                                background: '#28a745',
                            })
                            .then((willDelete) => {
                                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                                if (willDelete) {
                                    var re_url =
                                        "{{ route('employee.edit.report', ['id' => 'pass_id']) }}";
                                    re_url = re_url.replace('pass_id', resp.expense_detail_id);
                                    window.location.assign(re_url);
                                } else {
                                    $('#select_date_show').hide();
                                    $('#day_date_show').html('');
                                    $('#day_date').val('');
                                }
                            });
                    }
                    if (resp.is_previous_week == 'no') {
                        swal('You have not enter report data for previous week');
                    }

                },
                error: function(error) {


                }
            })
        })
        $(document).ready(function() {

            $('#after_rail_submit_msg').hide();
            $('#after_taxi_submit_msg').hide();
            $('#after_hotel_submit_msg').hide();
            $('#after_laundry_submit_msg').hide();
            $('#after_breakfast_submit_msg').hide();
            $('#after_lunch_submit_msg').hide();
            $('#after_dinner_submit_msg').hide();
            $('#after_phone_submit_msg').hide();
            $('#after_local_submit_msg').hide();
            $('#after_misce_submit_msg').hide();
            $('#select_date_show').hide();
            $("#report_form").validate({
                rules: {
                    day_date: {
                        required: true,

                    },
                    travel_from: {
                        required: true,
                        maxlength: 60,
                    },
                    travel_to: {
                        required: true,
                        maxlength: 60,
                    },
                    overnight_at: {
                        maxlength: 60,
                    },
                    day_city: {
                        required: true,
                        maxlength: 60,
                    },
                    day_purpose: {
                        required: true,
                        maxlength: 300,
                    },

                },
                submitHandler: function(form) {
                    form.submit();
                },

            });

            //for day date chnage ]\


            @if (@$day_date_send != null)
                var day_date = $('#day_date').val();
                // alert(day_date);
                $.ajax({
                    url: "{{ route('get.week.date') }}",
                    dataType: 'json',
                    data: {
                        day_date: day_date,
                        day_id: "{{ @$expense->id }}"
                    },
                    type: 'get',
                    // cache: false,
                    // processData: false,
                    // contentType: false,
                    success: function(resp) {
                        console.log(resp.day1);
                        var date_html = '';
                        if (resp.day1 != null) {

                            date_html +=
                                `<li><label for="" id="day1_show" onclick="change_day_date('${resp.day1}')"`;
                            if (resp.day1 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day1 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day1}</label></li>`;
                        }
                        if (resp.day2 != null) {

                            date_html +=
                                `<li><label for="" id="day2_show" onclick="change_day_date('${resp.day2}')"`;
                            if (resp.day2 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day2 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day2}</label></li>`;
                        }
                        if (resp.day3 != null) {

                            date_html +=
                                `<li><label for="" id="day3_show" onclick="change_day_date('${resp.day3}')"`;
                            if (resp.day3 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day3 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day3}</label></li>`;
                        }
                        if (resp.day4 != null) {
                            date_html +=
                                `<li><label for="" id="day4_show" onclick="change_day_date('${resp.day4}')"`;
                            if (resp.day4 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day4 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day4}</label></li>`;
                        }
                        if (resp.day5 != null) {

                            date_html +=
                                `<li><label for="" id="day5_show" onclick="change_day_date('${resp.day5}')"`;
                            if (resp.day5 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day5 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day5}</label></li>`;

                        }
                        if (resp.day6 != null) {
                            date_html +=
                                `<li><label for="" id="day6_show" onclick="change_day_date('${resp.day6}')"`;
                            if (resp.day6 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day6 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            date_html += `>${resp.day6}</label></li>`;
                        }
                        if (resp.day7 != null) {
                            date_html +=
                                `<li><label for="" id="day7_show" onclick="change_day_date('${resp.day7}')"`;
                            if (resp.day7 == resp.selected_date) {
                                date_html += `class="active"`;
                            }
                            if (resp.is_day7 == 'yes') {
                                date_html += `style="background-color:#fdff908c"`;
                            }
                            if(resp.end_week_date === $('#day_date').val()){
                            $('#total_expense_modal').show();
                        } else {
                            $('#total_expense_modal').hide();
                        }
                            date_html += `>${resp.day7}</label></li>`;
                        }
                        $('#day_date_show').html(date_html);

                        $('#select_date_show').show();

                        $('#start_date').val(resp.start_week_date);
                        $('#end_date').val(resp.end_week_date);

                        if (resp.day_error == 'inserted') {
                            // alert('You have already inserted to in this date,Please try to edit it');
                            // var re_url="{{ route('employee.edit.report', ['id' => 'pass_id']) }}";
                            // re_url=re_url.replace('pass_id',resp.expense_detail_id);
                            // window.location.assign(re_url);

                            swal({
                                    text: "You have already inserted to in this date,Please try to edit it",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                    background: '#28a745',
                                })
                                .then((willDelete) => {
                                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                                    if (willDelete) {
                                        var re_url =
                                            "{{ route('employee.edit.report', ['id' => 'pass_id']) }}";
                                        re_url = re_url.replace('pass_id', resp.expense_detail_id);
                                        window.location.assign(re_url);
                                    } else {
                                        $('#select_date_show').hide();
                                        $('#day_date_show').html('');
                                        $('#day_date').val('');
                                    }
                                });
                        }

                    },
                    error: function(error) {


                    }
                })
            @endif


        });
    </script>

    <script>
        $('#breakfast_amount,#lunch_amount,#laundry_base_fare,#laundry_gst_amount,#local_base_fare,#local_gst_amount,#phone_base_fare,#phone_gst_amount,#lunch_amount,#dinner_amount,.rail_base_fare,.rail_gst_amount,.only_number')
            .on("keypress", function(evt) {

                if (evt.which < 48 || evt.which > 57 || evt.which == 46) {
                    if (evt.which == 46) {

                    } else {

                        return false;
                        evt.preventDefault();
                    }

                }




                var re = /^[-+]?[0-9]+\.[0-9]+$/;
                var num_re = /^\d+$/;

                var self = evt.target.value;
                var is_value = isNaN(self);
                console.log(is_value, self);
                var letter_Count = 0;
                for (var position = 0; position < self.length; position++) {
                    if (self.charAt(position) == '.') {
                        letter_Count += 1;
                    }
                }
                if (is_value == true || self != '') {
                    if (re.test(self) || num_re.test(self) || letter_Count == 1) {
                        if (letter_Count == 1) {
                            if (evt.which < 48 || evt.which > 57) {

                                return false;
                                evt.preventDefault();
                            } else {

                                return true;
                            }
                        }

                        return true;
                    } else {

                        return false;
                        evt.preventDefault();
                    }

                } else {

                    if (evt.which < 48 || evt.which > 57) {

                        return false;
                        evt.preventDefault();
                    } else {

                        return true;
                    }
                }
                // var self = $(this);
                // var index = self.val().indexOf('.');
                // var len = self.val().length;
                // self.val(self.val().replace(/[^0-9\.]/g, ''));
                // if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
                // {
                //     if(index > 0){
                //         var charAfterdot= (len + 1)-index;
                //         if(charAfterdot > 3)
                //         {
                //             return false;
                //             evt.preventDefault();
                //         }
                //     }
                //     }
            });
        $('#laundry_base_fare,#laundry_gst_amount').on('input', function() {

            if (parseFloat($('#laundry_base_fare').val()) > 0) {
                var laun_base = parseFloat($('#laundry_base_fare').val());
            } else {
                var laun_base = 0;
            }

            if (parseFloat($('#laundry_gst_amount').val()) > 0) {
                var laun_gst = parseFloat($('#laundry_gst_amount').val());
            } else {
                var laun_gst = 0;
            }

            var laun_tot = 0;

            laun_tot = laun_base + laun_gst;
            $('#laundry_total').val(laun_tot);
            cal_grand_tot();

        })

        $('#local_base_fare,#local_gst_amount').on('input', function() {

            if (parseFloat($('#local_base_fare').val()) > 0) {
                var local_base = parseFloat($('#local_base_fare').val());
            } else {
                var local_base = 0;
            }

            if (parseFloat($('#local_gst_amount').val()) > 0) {
                var local_gst = parseFloat($('#local_gst_amount').val());
            } else {
                var local_gst = 0;
            }

            var local_tot = 0;

            local_tot = local_base + local_gst;
            $('#local_total').val(local_tot);
            cal_grand_tot();

        })

        $('#phone_base_fare,#phone_gst_amount').on('input', function() {

            if (parseFloat($('#phone_base_fare').val()) > 0) {
                var phone_base = parseFloat($('#phone_base_fare').val());
            } else {
                var phone_base = 0;
            }

            if (parseFloat($('#phone_gst_amount').val()) > 0) {
                var phone_gst = parseFloat($('#phone_gst_amount').val());
            } else {
                var phone_gst = 0;
            }

            var phone_tot = 0;

            phone_tot = phone_base + phone_gst;
            $('#phone_total').val(phone_tot);
            cal_grand_tot();

        })

        //for rail/air

        function changeRail(id) {
            var rail_base_price = parseFloat($('#rail_base_fare_' + id).val());
            var rail_gst_amount = parseFloat($('#rail_gst_amount_' + id).val());
            //  var rail_value=$("input[name='rail_base_fare[]']").val();
            //  console.log(rail_value);
            if (parseFloat($('#rail_base_fare_' + id).val()) > 0) {
                var rail_base = parseFloat($('#rail_base_fare_' + id).val());
            } else {
                var rail_base = 0;
            }

            if (parseFloat($('#rail_gst_amount_' + id).val()) > 0) {
                var rail_gst = parseFloat($('#rail_gst_amount_' + id).val());
            } else {
                var rail_gst = 0;
            }

            var rail_tot = 0;

            rail_tot = rail_base + rail_gst;
            $('#rail_total_' + id).val(rail_tot);

            cal_grand_tot();
        }

        //for taxi section 
        function changeTaxi(id) {
            var taxi_base_price = parseFloat($('#taxi_base_fare_' + id).val());
            var taxi_gst_amount = parseFloat($('#taxi_gst_amount_' + id).val());


            if (parseFloat($('#taxi_base_fare_' + id).val()) > 0) {
                var taxi_base = parseFloat($('#taxi_base_fare_' + id).val());
            } else {
                var taxi_base = 0;
            }

            if (parseFloat($('#taxi_gst_amount_' + id).val()) > 0) {
                var taxi_gst = parseFloat($('#taxi_gst_amount_' + id).val());
            } else {
                var taxi_gst = 0;
            }

            var taxi_tot = 0;

            taxi_tot = taxi_base + taxi_gst;
            $('#taxi_total_' + id).val(taxi_tot);

            cal_grand_tot();
        }

        //for hotel

        function changeHotel(id) {
            var hotel_base_price = parseFloat($('#hotel_base_fare_' + id).val());
            var hotel_gst_amount = parseFloat($('#hotel_gst_amount_' + id).val());

            if (parseFloat($('#hotel_base_fare_' + id).val()) > 0) {
                var hotel_base = parseFloat($('#hotel_base_fare_' + id).val());
            } else {
                var hotel_base = 0;
            }

            if (parseFloat($('#hotel_gst_amount_' + id).val()) > 0) {
                var hotel_gst = parseFloat($('#hotel_gst_amount_' + id).val());
            } else {
                var hotel_gst = 0;
            }

            var hotel_tot = 0;

            hotel_tot = hotel_base + hotel_gst;
            $('#hotel_total_' + id).val(hotel_tot);

            cal_grand_tot();
        }

        //for Miscilleanous
        function changeMisce(id) {
            var misce_base_price = parseFloat($('#misce_base_fare_' + id).val());
            var misce_gst_amount = parseFloat($('#misce_gst_amount_' + id).val());


            if (parseFloat($('#misce_base_fare_' + id).val()) > 0) {
                var misce_base = parseFloat($('#misce_base_fare_' + id).val());
            } else {
                var misce_base = 0;
            }

            if (parseFloat($('#misce_gst_amount_' + id).val()) > 0) {
                var misce_gst = parseFloat($('#misce_gst_amount_' + id).val());
            } else {
                var misce_gst = 0;
            }

            var misce_tot = 0;

            misce_tot = misce_base + misce_gst;
            $('#misce_total_' + id).val(misce_tot);

            cal_grand_tot();
        }

        $('#lunch_amount,#breakfast_amount,#dinner_amount').on('input', function() {
            cal_grand_tot();
        });


        function cal_grand_tot() {

            if (parseFloat($('#laundry_base_fare').val()) > 0) {
                var laun_base = parseFloat($('#laundry_base_fare').val());
            } else {
                var laun_base = 0;
            }

            if (parseFloat($('#laundry_gst_amount').val()) > 0) {
                var laun_gst = parseFloat($('#laundry_gst_amount').val());
            } else {
                var laun_gst = 0;
            }
            if (parseFloat($('#lunch_amount').val()) > 0) {
                var lunch_amount = parseFloat($('#lunch_amount').val());
            } else {
                var lunch_amount = 0;
            }

            if (parseFloat($('#breakfast_amount').val()) > 0) {
                var breakfast_amount = parseFloat($('#breakfast_amount').val());
            } else {
                var breakfast_amount = 0;
            }
            if (parseFloat($('#dinner_amount').val()) > 0) {
                var dinner_amount = parseFloat($('#dinner_amount').val());
            } else {
                var dinner_amount = 0;
            }

            if (parseFloat($('#local_base_fare').val()) > 0) {
                var local_base = parseFloat($('#local_base_fare').val());
            } else {
                var local_base = 0;
            }

            if (parseFloat($('#local_gst_amount').val()) > 0) {
                var local_gst = parseFloat($('#local_gst_amount').val());
            } else {
                var local_gst = 0;
            }

            if (parseFloat($('#phone_base_fare').val()) > 0) {
                var phone_base = parseFloat($('#phone_base_fare').val());
            } else {
                var phone_base = 0;
            }

            if (parseFloat($('#phone_gst_amount').val()) > 0) {
                var phone_gst = parseFloat($('#phone_gst_amount').val());
            } else {
                var phone_gst = 0;
            }

            //for rail calculation 

            var rail_count = parseInt($('#rail_count').val());
            var rail_all_total = 0;
            for (var i = 0; i < rail_count; i++) {
                i_plus = i + 1;
                if (parseFloat($('#rail_base_fare_' + i_plus).val()) > 0) {
                    rail_all_total = rail_all_total + parseFloat($('#rail_base_fare_' + i_plus).val());
                }
                if (parseFloat($('#rail_gst_amount_' + i_plus).val()) > 0) {
                    rail_all_total = rail_all_total + parseFloat($('#rail_gst_amount_' + i_plus).val());
                }

            }

            //for taxi calculation 

            var taxi_count = parseInt($('#taxi_count').val());
            var taxi_all_total = 0;
            for (var i = 0; i < taxi_count; i++) {
                i_plus = i + 1;
                if (parseFloat($('#taxi_base_fare_' + i_plus).val()) > 0) {
                    taxi_all_total = taxi_all_total + parseFloat($('#taxi_base_fare_' + i_plus).val());
                }
                if (parseFloat($('#taxi_gst_amount_' + i_plus).val()) > 0) {
                    taxi_all_total = taxi_all_total + parseFloat($('#taxi_gst_amount_' + i_plus).val());
                }

            }

            //for hotel calculation 

            var hotel_count = parseInt($('#hotel_count').val());
            var hotel_all_total = 0;
            for (var i = 0; i < hotel_count; i++) {
                i_plus = i + 1;
                if (parseFloat($('#hotel_base_fare_' + i_plus).val()) > 0) {
                    hotel_all_total = hotel_all_total + parseFloat($('#hotel_base_fare_' + i_plus).val());
                }
                if (parseFloat($('#hotel_gst_amount_' + i_plus).val()) > 0) {
                    hotel_all_total = hotel_all_total + parseFloat($('#hotel_gst_amount_' + i_plus).val());
                }

            }

            //for Misce calculation  

            var misce_count = parseInt($('#misce_count').val());
            var misce_all_total = 0;
            for (var i = 0; i < misce_count; i++) {
                i_plus = i + 1;
                if (parseFloat($('#misce_base_fare_' + i_plus).val()) > 0) {
                    misce_all_total = misce_all_total + parseFloat($('#misce_base_fare_' + i_plus).val());
                }
                if (parseFloat($('#misce_gst_amount_' + i_plus).val()) > 0) {
                    misce_all_total = misce_all_total + parseFloat($('#misce_gst_amount_' + i_plus).val());
                }

            }


            var grand_tot = 0;

            grand_tot = laun_base + laun_gst + lunch_amount + breakfast_amount + dinner_amount + local_base + local_gst +
                phone_base + phone_gst + rail_all_total + taxi_all_total + hotel_all_total + misce_all_total;
            $('#grand_total_show').val(grand_tot);
        }


        function misce_select_function(item_id = null) {
            if (item_id == '' || item_id == ' ' || item_id == null) {
                return false;
            }
            if ($('#misce_select_' + item_id).val() == 'F') {
                $('#misce_gst_amount_' + item_id).val('');
                $('#misce_gst_number_' + item_id).val('');
                $('.show_hide_misce_' + item_id).hide();

                var misce_base_price = parseFloat($('#misce_base_fare_' + item_id).val());
                var misce_gst_amount = parseFloat($('#misce_gst_amount_' + item_id).val());


                if (parseFloat($('#misce_base_fare_' + item_id).val()) > 0) {
                    var misce_base = parseFloat($('#misce_base_fare_' + item_id).val());
                } else {
                    var misce_base = 0;
                }

                if (parseFloat($('#misce_gst_amount_' + item_id).val()) > 0) {
                    var misce_gst = parseFloat($('#misce_gst_amount_' + item_id).val());
                } else {
                    var misce_gst = 0;
                }

                var misce_tot = 0;

                misce_tot = misce_base + misce_gst;
                $('#misce_total_' + item_id).val(misce_tot);


            } else {
                // $('#misce_gst_amount_'+item_id).val('');
                // $('#misce_gst_number_'+item_id).val('');
                $('.show_hide_misce_' + item_id).show();


            }

            cal_grand_tot();

        }
    </script>
    <script>
        $('#rail_add_more').click(function() {
            var rail_check = $("input[name='rail_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter basefare amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var rail_check_gst = $("input[name='rail_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check_gst.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter GST amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var rail_check_gst_no = $("input[name='rail_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check_gst_no.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter GST number to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }


            var chk_rail_img = $("input[name='rail_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#rail_already_ids').val();
            var alr_id = alu_ids.split(',');
            console.log(chk_rail_img);
            chk_rail_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }

            var rail_count = parseInt($('#rail_count').val());
            var rail_count_plus = rail_count + 1;
            $('#rail_count').val(rail_count_plus);
            var rail_html = "";
            rail_html = ` <hr class="rail_extra_${rail_count_plus}"> 
    <a href="javascript:;"  class="right_move_cross rail_extra_${rail_count_plus}" onclick="remove_extra_row('${rail_count_plus}','R')"> <i class="fa fa-close " ></i> Remove this row </a>
    <div class="row rail_extra_${rail_count_plus} ">
    
    <input type="hidden" value="${rail_count_plus}" name="rail_false_id[]" id="rail_false_id_${rail_count_plus}">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare *</label>
                            <input type="text" placeholder="Base Fare" name="rail_base_fare[]" id="rail_base_fare_${rail_count_plus}" class="rail_base_fare" oninput="changeRail(${rail_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount *</label>
                            <input type="text" placeholder="GST Amount" name="rail_gst_amount[]" id="rail_gst_amount_${rail_count_plus}" class="rail_gst_amount" oninput="changeRail(${rail_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total" name="rail_total[]" id="rail_total_${rail_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number *</label>
                            <input type="text" placeholder="GST Number"   name="rail_gst_number[]" id="rail_gst_number_${rail_count_plus}"   onkeypress="return gst_valu(event)">
                        </div>
                    </div>
                    <input type="hidden" name="rail_doc_count[]" id="rail_doc_count_${rail_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document *</label>
                            <div class="fill-box-file">
                                <input type="file" name="rail_doc[]" id="rail_doc_${rail_count_plus}" onchange="chnageRailDoc(${rail_count_plus},this)" data-multiple-caption=""  accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="{{ asset('public/front_assets/images/upload.png') }}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="rail_doc_${rail_count_plus}_count_show" onclick="Show_Doc_Add('${rail_count_plus}','R','rail_doc_${rail_count_plus}_count_show')">   </span>
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

        $("body").on('click', '#taxi_add_more', function() {

            var taxi_check = $("input[name='taxi_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter basefare amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }


            var taxi_check_gst = $("input[name='taxi_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var taxi_select_chk = $(".taxi_selet").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check_gst.forEach(function(item, index) {
                if (item == '' || item == ' ' || item == '  ') {
                    if (taxi_select_chk[index] == 'O') {
                        swal('Please Enter GST amounts to add more section');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }


            var taxi_check_gst_no = $("input[name='taxi_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var taxi_select_chk = $(".taxi_selet").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check_gst_no.forEach(function(item, index) {
                if (item == '' || item == ' ' || item == '  ') {
                    if (taxi_select_chk[index] == 'O') {
                        swal('Please Enter GST number to add more section');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }

            var chk_taxi_img = $("input[name='taxi_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#taxi_already_ids').val();
            var alr_id = alu_ids.split(',');
            chk_taxi_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }



            var taxi_count = parseInt($('#taxi_count').val());
            var taxi_count_plus = taxi_count + 1;
            $('#taxi_count').val(taxi_count_plus);
            var taxi_html = "";
            taxi_html = ` <hr class="taxi_extra_${taxi_count_plus}">    
    <a href="javascript:;"  class="right_move_cross taxi_extra_${taxi_count_plus}" onclick="remove_extra_row('${taxi_count_plus}','T')"> <i class="fa fa-close" ></i> Remove this row </a> 
            <div class="row taxi_extra_${taxi_count_plus}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="fill-box">
                                <select class="form-select taxi_selet" aria-label="Default select example" name="taxi_select[]" id="taxi_select_${taxi_count_plus}" onchange="chnag_taxi_select('${taxi_count_plus}')">
                                    <option value="" selected>Select Type</option>
                                        <option value="1">Taxi</option>
                                        <option value="2">Bus</option>
                                        <option value="3">Rickshaw</option>
                            </select>
                            </div>
                        </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                        <input type="hidden" value="${taxi_count_plus}" name="taxi_false_id[]" id="taxi_false_id_${taxi_count_plus}">
                        <div class="fill-box">
                            <label for="">Base Fare *</label>
                            <input type="text" placeholder="Base Fare" class="only_number" name="taxi_base_fare[]" id="taxi_base_fare_${taxi_count_plus}" oninput="changeTaxi(${taxi_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4  col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="" id="taxi_show_gst_amt_${taxi_count_plus}">GST Amount *</label>
                            <input type="text" placeholder="GST Amount" class="only_number" name="taxi_gst_amount[]" id="taxi_gst_amount_${taxi_count_plus}" oninput="changeTaxi(${taxi_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="taxi_total[]" id="taxi_total_${taxi_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="" id="taxi_show_gst_no_${taxi_count_plus}">GST Number *</label>
                            <input type="text" placeholder="GST Number"  name="taxi_gst_number[]" id="taxi_gst_number_${taxi_count_plus}"   onkeypress="return gst_valu(event)"> 
                        </div>
                    </div>
                    <input type="hidden" name="taxi_doc_count[]" id="taxi_doc_count_${taxi_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document *</label>
                            <div class="fill-box-file">
                                <input type="file" name="taxi_doc[]" id="taxi_doc_${taxi_count_plus}" onchange="chnageTaxiDoc(${taxi_count_plus},this)" data-multiple-caption=""  accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="{{ asset('public/front_assets/images/upload.png') }}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="taxi_doc_${taxi_count_plus}_count_show" onclick="Show_Doc_Add('${taxi_count_plus}','T','taxi_doc_${taxi_count_plus}_count_show')">   </span>
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

        $('#hotel_add_more').click(function() {
            var hotel_check_name = $("input[name='hotel_name[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_name.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter Hotel name to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var hotel_check_city = $("input[name='hotel_city[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_city.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter Hotel city name to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var hotel_check = $("input[name='hotel_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter basefare amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }



            var hotel_check_gst = $("input[name='hotel_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_gst.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter GST amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var hotel_check_gst_no = $("input[name='hotel_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_gst_no.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter GST number to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }


            var chk_hotel_img = $("input[name='hotel_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#hotel_already_ids').val();
            var alr_id = alu_ids.split(',');
            chk_hotel_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }

            var hotel_count = parseInt($('#hotel_count').val());
            var hotel_count_plus = hotel_count + 1;
            $('#hotel_count').val(hotel_count_plus);
            var hotel_html = "";
            hotel_html = `<hr class="hotel_extra_${hotel_count_plus}">
    <a href="javascript:;"  class="right_move_cross hotel_extra_${hotel_count_plus}" onclick="remove_extra_row('${hotel_count_plus}','H')"> <i class="fa fa-close" ></i> Remove this row </a>
    <div class="row hotel_extra_${hotel_count_plus}">

                <input type="hidden" value="${hotel_count_plus}" name="hotel_false_id[]" id="hotel_false_id_${hotel_count_plus}">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Hotel Name *</label>
                            <input type="text" placeholder="Hotel Name"  name="hotel_name[]" id="hotel_name_${hotel_count_plus}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City *</label>
                            <input type="text" placeholder="City Name"  name="hotel_city[]" id="hotel_city_${hotel_count_plus}">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST) *</label>
                            <input type="text" placeholder="Base Fare" class="only_number" name="hotel_base_fare[]" id="hotel_base_fare_${hotel_count_plus}" oninput="changeHotel(${hotel_count_plus})" onkeypress="return base_valu(event)">
                            
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount *</label>
                            <input type="text" placeholder="GST Amount" class="only_number" name="hotel_gst_amount[]" id="hotel_gst_amount_${hotel_count_plus}" oninput="changeHotel(${hotel_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="hotel_total[]" id="hotel_total_${hotel_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number *</label>
                            <input type="text" placeholder="GST Number"  name="hotel_gst_number[]" id="hotel_gst_number_${hotel_count_plus}"   onkeypress="return gst_valu(event)">
                        </div>
                    </div>
                    <input type="hidden" name="hotel_doc_count[]" id="hotel_doc_count_${hotel_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document *</label>
                            <div class="fill-box-file">
                                <input type="file" name="hotel_doc[]" id="hotel_doc_${hotel_count_plus}" onchange="chnageHotelDoc(${hotel_count_plus},this)" data-multiple-caption=""  accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="{{ asset('public/front_assets/images/upload.png') }}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="hotel_doc_${hotel_count_plus}_count_show" onclick="Show_Doc_Add('${hotel_count_plus}','H','hotel_doc_${hotel_count_plus}_count_show')">   </span>
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

        $('#misce_add_more').click(function() {
            var misce_check = $("input[name='misce_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            misce_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter basefare amounts to add more section');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var chk_misce_img = $("input[name='misce_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#misce_already_ids').val();
            var alr_id = alu_ids.split(',');
            chk_misce_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }

            var misce_count = parseInt($('#misce_count').val());
            var misce_count_plus = misce_count + 1;
            $('#misce_count').val(misce_count_plus);
            var misce_html = ``;
            misce_html = `<hr class="misce_extra_${misce_count_plus}""> 
    <a href="javascript:;"  class="right_move_cross misce_extra_${misce_count_plus}" onclick="remove_extra_row('${misce_count_plus}','M')"> <i class="fa fa-close" ></i> Remove this row </a>
    <div class="row misce_extra_${misce_count_plus}">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="fill-box">
                <select class="form-select misce_selt" aria-label="Default select example" name="misce_select[]" id="misce_select_${misce_count_plus}" onchange="misce_select_function('${misce_count_plus}')">
                    <option value="O" selected>Others</option> 
                    <option value="F" >Food</option> 
                  </select>
                  </div>
                  </div>
                <input type="hidden" value="${misce_count_plus}" name="misce_false_id[]" id="misce_false_id_${misce_count_plus}">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare</label>
                            <input type="text" placeholder="Base Fare" class="only_number" name="misce_base_fare[]" id="misce_base_fare_${misce_count_plus}" oninput="changeMisce(${misce_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 show_hide_misce_${misce_count_plus}">
                        <div class="fill-box">
                            <label for="">GST Amount</label>
                            <input type="text" placeholder="GST Amount" class="only_number"  name="misce_gst_amount[]" id="misce_gst_amount_${misce_count_plus}" oninput="changeMisce(${misce_count_plus})" onkeypress="return base_valu(event)">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <input type="text" placeholder="Total"  name="misce_total[]" id="misce_total_${misce_count_plus}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 show_hide_misce_${misce_count_plus}">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <input type="text" placeholder="GST Number"  name="misce_gst_number[]" id="misce_gst_number_${misce_count_plus}"   onkeypress="return gst_valu(event)">
                        </div>
                    </div>
                    <input type="hidden" name="misce_doc_count[]" id="misce_doc_count_${misce_count_plus}" >
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="fill-box-file">
                                <input type="file" name="misce_doc[]" id="misce_doc_${misce_count_plus}" onchange="chnageMisceDoc(${misce_count_plus},this)"  data-multiple-caption=""  accept="image/*,application/pdf" multiple>
                                <h3>Upload Document <img src="{{ asset('public/front_assets/images/upload.png') }}" alt=""></h3>
                            </div>
                        </div>
                        <span style="color:blue;display:none" id="misce_doc_${misce_count_plus}_count_show" onclick="Show_Doc_Add('${misce_count_plus}','M','misce_doc_${misce_count_plus}_count_show')">   </span>
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
        function count_image(e, show_count) {
            console.log(e.files);
            $(show_count).css('display', 'block');
            $(show_count).html(e.files.length + " Files Selected  ");
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

        // $('#laundry_doc_count_show').click(function(){
        //     console.log($('#laundry_doc').val());
        // });



        function chnageExpenseDataDoc(id, even) {
            console.log(even);
            $('#expense_data_count_' + id).val(even.files.length);
            count_image(even, '#expense_data_' + id + '_count_show');
        }

        function chnageRailDoc(id, even) {
            console.log(even);
            $('#rail_doc_count_' + id).val(even.files.length);
            count_image(even, '#rail_doc_' + id + '_count_show');
        }

        function chnageTaxiDoc(id, even) {
            console.log(even);
            $('#taxi_doc_count_' + id).val(even.files.length);
            count_image(even, '#taxi_doc_' + id + '_count_show');
        }

        function chnageHotelDoc(id, even) {
            console.log(even);
            $('#hotel_doc_count_' + id).val(even.files.length);
            count_image(even, '#hotel_doc_' + id + '_count_show');
        }

        function chnageMisceDoc(id, even) {
            console.log(even);
            $('#misce_doc_count_' + id).val(even.files.length);
            count_image(even, '#misce_doc_' + id + '_count_show');
        }
    </script>

    <script>
        $('#no_expense').click(function() {
            if ($('select[name="no_expense_type"]').val() == '') {
                swal('Please Expense Type first');
                $('#no_expense_type-error').html('Please Expense Type first');
                return false;
            } else {
                var no_expense_type = $('select[name="no_expense_type"]').val();
            }
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                return false;
            } else {
                $('#day_date-error').html('');
            }
            var user_id = "{{ auth()->user()->id }}";
            var formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('expense_type', no_expense_type);
            formData.append('day_date', $('#day_date').val());
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            $.ajax({
                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        $('#myExpenseModal').modal('hide');
                        swal('Data Saved');
                    }

                },
                error: function(error) {


                }
            })

        });
        $('#expense').click(function() {
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                return false;
            } else {
                $('#day_date-error').html('');
            }
            if ($('select[name="expense_type"]').val() == '') {
                swal('Please Expense Type first');
                $('#expense_type-error').html('Please Expense Type first');
                return false;
            } else {
                var expense_type = $('select[name="expense_type"]').val();
            }
            if ($('input[name="expense_amount"]').val() == '') {
                swal('Please Expense Type first');
                $('#expense_amount-error').html('Please Expense Type first');
                return false;
            } else {
                var expense_amount = $('input[name="expense_amount"]').val();
            }

            var expense_supporting_document = $("input[name='expense_supporting_document[]']").map(function() {
                return $(this).prop("files");
            }).get();

            expense_supporting_document.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row of Document Section');
                        is_check = 1;
                        return false;
                    }

                }

            });

            var expense_supporting_document = $("input[name='expense_supporting_document[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < expense_supporting_document.length; i++) {
                for (let j = 0; j < expense_supporting_document[i].length; j++) {
                    formData.append('expense_supporting_document[]', expense_supporting_document[i][j]);
                }


            }

            $("input[name='expense_data_count[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('expense_data_count[]', item);
            })
            
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', expense_type);
            formData.append('expense_amount', expense_amount);
            formData.append('day_date', $('#day_date').val());
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            $.ajax({
                url: "{{ route('employee.report.saveExpenseData') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        $('#myTotalExpenseModal').modal('hide');
                        swal('Data Saved');
                    }

                },
                error: function(error) {


                }
            })

        });
        $('#rail_from_submit').click(function() {



            var rail_img = $("input[name='rail_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            //   for(let i = 0; i < rail_img.length ; i++)
            //   {
            //     for(let j = 0; j < rail_img[i].length ; j++)
            //     {
            //         formData.append('rail_doc_img',rail_img[i][j]);
            //     }


            //   }
            //   console.log(img_arr);
            //   console.log($("input[name='rail_doc[]']").map(function(){return $(this).prop("files");}).get());
            //   return false
            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var rail_check = $("input[name='rail_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Rail Section basefare amounts');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var rail_check_gst = $("input[name='rail_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check_gst.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Rail Section gst amounts');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var rail_check_gst_no = $("input[name='rail_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            rail_check_gst_no.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Rail Section gst number');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }


            var chk_rail_img = $("input[name='rail_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#rail_already_ids').val();
            var alr_id = alu_ids.split(',');
            //  console.log(chk_rail_img);
            chk_rail_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row of Rail Section');
                        is_check = 1;
                        return false;
                    }

                }

            });
            if (is_check == 1) {
                return false;
            }
            //   var rail_vlue=$("input[name='rail_doc[]']").prop("files");
            //   var rail_vlue=$("input[name='rail_doc[]']").map(function(){return $(this).prop("files");}).get();
            //   var rail_count=$("input[name='rail_doc_count[]']").map(function(){return $(this).val();}).get();


            //   alert(rail_vlue);
            //   alert('123');
            //   console.log(rail_vlue,rail_count);
            $('#rail_from_submit').hide();
            $('#rail_add_more').hide();

            var rail_img = $("input[name='rail_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < rail_img.length; i++) {
                for (let j = 0; j < rail_img[i].length; j++) {
                    formData.append('rail_doc[]', rail_img[i][j]);
                    // img_arr.push(rail_img[i][j]);
                }


            }
            var user_id = "{{ auth()->user()->id }}";
            // formData.append('rail_doc_img[]',rail_img[i][j]);
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'R');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());


            formData.append('rail_already_ids', $('#rail_already_ids').val());

            $("input[name='rail_false_id[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_false_id[]', item);
            })

            $("input[name='rail_base_fare[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_base_fare[]', item);
            })

            $("input[name='rail_gst_amount[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_gst_amount[]', item);
            })
            $("input[name='rail_total[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_total[]', item);
            })
            $("input[name='rail_gst_number[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_gst_number[]', item);
            })
            $("input[name='rail_doc_count[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_doc_count[]', item);
            })

            $("input[name='rail_remark[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('rail_remark[]', item);
            })

            // formData.append('rail_gst_amount[]',$("input[name='rail_gst_amount[]']").map(function(){return $(this).val();}).get());
            // formData.append('rail_total[]',$("input[name='rail_total[]']").map(function(){return $(this).val();}).get());
            // formData.append('rail_gst_number[]',$("input[name='rail_gst_number[]']").map(function(){return $(this).val();}).get());
            // formData.append('rail_doc_count[]',$("input[name='rail_doc_count[]']").map(function(){return $(this).val();}).get());



            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'5',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'R',
            //     'rail_base_fare':$("input[name='rail_base_fare[]']").map(function(){return $(this).val();}).get(),
            //     'rail_gst_amount':$("input[name='rail_gst_amount[]']").map(function(){return $(this).val();}).get(),
            //     'rail_total':$("input[name='rail_total[]']").map(function(){return $(this).val();}).get(),
            //     'rail_gst_number':$("input[name='rail_gst_number[]']").map(function(){return $(this).val();}).get(),
            //     'rail_doc':$("input[name='rail_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     'rail_doc_count':$("input[name='rail_doc_count[]']").map(function(){return $(this).val();}).get(),
            //     }
            // };

            // var send_data ={
            //     'user_id' : '{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'R',
            //     'rail_base_fare':$("input[name='rail_base_fare[]']").map(function(){return $(this).val();}).get(),
            //     'rail_gst_amount':$("input[name='rail_gst_amount[]']").map(function(){return $(this).val();}).get(),
            //     'rail_total':$("input[name='rail_total[]']").map(function(){return $(this).val();}).get(),
            //     'rail_gst_number':$("input[name='rail_gst_number[]']").map(function(){return $(this).val();}).get(),
            //     'rail_doc_count':$("input[name='rail_doc_count[]']").map(function(){return $(this).val();}).get(),
            //     // 'rail_doc':formData,

            // };
            // console.log(reqData);
            $.ajax({
                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);

                    console.log(resp.result.rail_item_ids);
                    if (resp.result.status == 'Success') {
                        // alert('Rail section form is successfully submitted');  
                        var rail_counts = parseInt($('#rail_count').val()) + 1;
                        for (var i = 0; i < rail_counts; i++) {
                            var doc_countin = 0;
                            resp.result.rail_false_id.forEach(function(item, index) {
                                if (item == i) {
                                    doc_countin = resp.result.rail_doc_count[index];
                                }

                            });
                            var count_doc = doc_countin;
                            $('#rail_doc_' + i + '_count_show').html(count_doc +
                                ' Files Uploaded Preview');
                            $('#rail_doc_' + i + '_count_show').addClass('hand_cursor');

                            $('#rail_doc_' + i).val('');
                            $('#rail_doc_count_' + i).val('');
                        }
                        $('#after_rail_submit_msg').html('Data saved successfully');

                        $('#after_rail_submit_msg').show();
                        setTimeout(() => {
                            $('#after_rail_submit_msg').hide(3000);
                        }, 3000);


                    } else {
                        $('#after_rail_submit_msg').html(resp.result.error);
                    }
                    $('#rail_already_ids').val(resp.result.rail_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#rail_from_submit').show();
                    $('#rail_add_more').show();

                },
                error: function(error) {


                }
            })

        });


        //for Taxi Submit Data

        $('#taxi_from_submit').click(function() {


            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }



            var taxi_check = $("input[name='taxi_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Taxi Section basefare amounts');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var taxi_check_gst = $("input[name='taxi_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var taxi_select_chk = $(".taxi_selet").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check_gst.forEach(function(item, index) {
                if (item == '' || item == ' ' || item == '  ') {
                    if (taxi_select_chk[index] == 'O') {
                        swal('Please Enter all Taxi Section GST amounts');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }


            var taxi_check_gst_no = $("input[name='taxi_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var taxi_select_chk = $(".taxi_selet").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            taxi_check_gst_no.forEach(function(item, index) {
                if (item == '' || item == ' ' || item == '  ') {
                    if (taxi_select_chk[index] == 'O') {
                        swal('Please Enter all Taxi Section GST numbers');
                        is_check = 1;
                        return false;
                    }

                }

            });
            if (is_check == 1) {
                return false;
            }

            var chk_taxi_img = $("input[name='taxi_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#taxi_already_ids').val();
            var alr_id = alu_ids.split(',');
            var e = document.getElementById("taxi_select_1");
            var value = e.value;
            var text = e.options[e.selectedIndex].text;
            if (value == 'I') {
                // alert(value);
            } else {
                chk_taxi_img.forEach(function(item, index) {
                    if (item.length == 0) {
                        if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                                index]) == true) {
                            swal('Please upload atleast 1 document in each row of Taxi Section');
                            is_check = 1;
                            return false;
                        }
                    }

                });
                if (is_check == 1) {
                    return false;
                }
            }
            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'T',
            //     'taxi_base_fare':$("input[name='taxi_base_fare[]']").map(function(){return $(this).val();}).get(),
            //     'taxi_gst_amount':$("input[name='taxi_gst_amount[]']").map(function(){return $(this).val();}).get(),
            //     'taxi_total':$("input[name='taxi_total[]']").map(function(){return $(this).val();}).get(),
            //     'taxi_gst_number':$("input[name='taxi_gst_number[]']").map(function(){return $(this).val();}).get(),
            //     'taxi_doc_count':$("input[name='taxi_doc_count[]']").map(function(){return $(this).val();}).get(),
            //     // 'taxi_doc':$("input[name='taxi_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };
            $('#taxi_from_submit').hide();
            $('#taxi_add_more').hide();

            var arru_img = $("input[name='taxi_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('taxi_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'T');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('taxi_already_ids', $('#taxi_already_ids').val());

            $(".taxi_selet").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_select[]', item);
            })

            $("input[name='taxi_false_id[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_false_id[]', item);
            })

            $("input[name='taxi_base_fare[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_base_fare[]', item);
            })

            $("input[name='taxi_gst_amount[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_gst_amount[]', item);
            })
            $("input[name='taxi_total[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_total[]', item);
            })

            $("input[name='taxi_gst_number[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_gst_number[]', item);
            })
            $("input[name='taxi_doc_count[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_doc_count[]', item);
            })

            $("input[name='taxi_remark[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('taxi_remark[]', item);
            })

            // console.log(reqData);
            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        // alert('Taxi section form is successfully submitted');
                        var taxi_counts = parseInt($('#taxi_count').val()) + 1;
                        for (var i = 0; i < taxi_counts; i++) {
                            var doc_countin = 0;
                            resp.result.taxi_false_id.forEach(function(item, index) {
                                if (item == i) {
                                    doc_countin = resp.result.taxi_doc_count[index];
                                }

                            });
                            var count_doc = doc_countin;
                            $('#taxi_doc_' + i + '_count_show').html(count_doc +
                                ' Files Uploaded Preview');
                            $('#taxi_doc_' + i + '_count_show').addClass('hand_cursor');

                            $('#taxi_doc_' + i).val('');
                            $('#taxi_doc_count_' + i).val('');
                        }

                        $('#after_taxi_submit_msg').html('Data saved successfully');
                        $('#after_taxi_submit_msg').show();
                        setTimeout(() => {
                            $('#after_taxi_submit_msg').hide(3000);
                        }, 3000);


                    } else {
                        $('#after_taxi_submit_msg').html(resp.result.error);
                        
                    }
                    $('#taxi_already_ids').val(resp.result.taxi_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#taxi_from_submit').show();
                    $('#taxi_add_more').show();
                },
                error: function(error) {


                }
            })

        });



        //for Hotel Submit form 

        $('#hotel_from_submit').click(function() {


            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }


            var hotel_check = $("input[name='hotel_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {

                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                swal('Please Enter all Hotel Section basefare amounts');
                return false;
            }

            var hotel_name_check = $("input[name='hotel_name[]']").map(function() {
                return $(this).val();
            }).get();
            var is_name_check = 0;
            hotel_name_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    is_name_check = 1;
                    return false;
                }

            });
            if (is_name_check == 1) {
                swal('Please Enter all Hotel Section Hotel Names');
                return false;
            }

            var hotel_city_check = $("input[name='hotel_city[]']").map(function() {
                return $(this).val();
            }).get();
            var is_city_check = 0;
            hotel_city_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    is_city_check = 1;
                    return false;
                }

            });
            if (is_city_check == 1) {
                swal('Please Enter all Hotel Section Hotel Cities');
                return false;
            }


            var hotel_check_gst = $("input[name='hotel_gst_amount[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_gst.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Hotel Section GST amount');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var hotel_check_gst_no = $("input[name='hotel_gst_number[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            hotel_check_gst_no.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Hotel Section GST number');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }


            var chk_hotel_img = $("input[name='hotel_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();

            var alu_ids = $('#hotel_already_ids').val();
            var alr_id = alu_ids.split(',');
            chk_hotel_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row of Hotel section');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }


            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'H',
            //     'hotel_name':$("input[name='hotel_name[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_city':$("input[name='hotel_city[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_base_fare':$("input[name='hotel_base_fare[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_gst_amount':$("input[name='hotel_gst_amount[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_total':$("input[name='hotel_total[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_gst_number':$("input[name='hotel_gst_number[]']").map(function(){return $(this).val();}).get(),
            //     'hotel_doc_count':$("input[name='hotel_doc_count[]']").map(function(){return $(this).val();}).get(),
            //     // 'hotel_doc':$("input[name='hotel_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };

            $('#hotel_from_submit').hide();
            $('#hotel_add_more').hide();

            var arru_img = $("input[name='hotel_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('hotel_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'H');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('hotel_already_ids', $('#hotel_already_ids').val());

            $("input[name='hotel_false_id[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_false_id[]', item);
            })

            $("input[name='hotel_name[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_name[]', item);
            })
            $("input[name='hotel_city[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_city[]', item);
            })
            $("input[name='hotel_base_fare[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_base_fare[]', item);
            })

            $("input[name='hotel_gst_amount[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_gst_amount[]', item);
            })
            $("input[name='hotel_total[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_total[]', item);
            })
            $("input[name='hotel_gst_number[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_gst_number[]', item);
            })
            $("input[name='hotel_doc_count[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_doc_count[]', item);
            })
            $("input[name='hotel_remark[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('hotel_remark[]', item);
            })
            // console.log(reqData);
            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        // alert('Hotel section form is successfully submitted');
                        var hotel_counts = parseInt($('#hotel_count').val()) + 1;
                        for (var i = 0; i < hotel_counts; i++) {
                            var doc_countin = 0;
                            resp.result.hotel_false_id.forEach(function(item, index) {
                                if (item == i) {
                                    doc_countin = resp.result.hotel_doc_count[index];
                                }

                            });
                            var count_doc = doc_countin;
                            $('#hotel_doc_' + i + '_count_show').html(count_doc +
                                ' Files Uploaded Preview');
                            $('#hotel_doc_' + i + '_count_show').addClass('hand_cursor');


                            $('#hotel_doc_' + i).val('');
                            $('#hotel_doc_count_' + i).val('');
                        }

                        $('#after_hotel_submit_msg').html('Data saved successfully');
                        $('#after_hotel_submit_msg').show();
                        setTimeout(() => {
                            $('#after_hotel_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_hotel_submit_msg').html(resp.result.error);
                    }
                    $('#hotel_already_ids').val(resp.result.hotel_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#hotel_from_submit').show();
                    $('#hotel_add_more').show();

                },
                error: function(error) {

                    alert(error);
                }
            })

        });


        //for Laundry Submit form 

        $('#laundry_from_submit').click(function() {


            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var item_base_fare = $('#laundry_base_fare').val();
            if (item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ') {
                swal('Please Enter Laundry  basefare amount');

                return false;
            }
            var item_name = $('#laundry_name').val();
            if (item_name == '' || item_name == ' ' || item_name == '  ') {
                swal('Please Enter Laundry Name');

                return false;
            }

            var item_city = $('#laundry_city').val();
            if (item_city == '' || item_city == ' ' || item_city == '  ') {
                swal('Please Enter Laundry City');

                return false;
            }

            // var chk_laundry_doc=$('#laundry_doc').val();
            var chk_laundry_doc = $("input[name='laundry_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();;


            if (chk_laundry_doc[0].length == 0) {
                if ($('#laundry_already_ids').val() == '' || $('#laundry_already_ids').val() == null) {
                    swal('Please upload atleast 1 document');
                    return false;
                }

            }

            $('#laundry_from_submit').hide();
            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'L',
            //     'laundry_name':$('#laundry_name').val(),
            //     'laundry_city':$('#laundry_city').val(),
            //     'laundry_base_fare':$('#laundry_base_fare').val(),
            //     'laundry_gst_amount':$('#laundry_gst_amount').val(),
            //     'laundry_total':$('#laundry_total').val(),
            //     'laundry_gst_number':$('#laundry_gst_number').val(),
            //     'laundry_doc_count':$('#laundry_doc_count').val(),
            //     // 'laundry_doc':$("input[name='laundry_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };
            var arru_img = $("input[name='laundry_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('laundry_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'L');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('laundry_already_ids', $('#laundry_already_ids').val());

            formData.append('laundry_name', $('#laundry_name').val());
            formData.append('laundry_city', $('#laundry_city').val());
            formData.append('laundry_base_fare', $('#laundry_base_fare').val());
            formData.append('laundry_gst_amount', $('#laundry_gst_amount').val());
            formData.append('laundry_total', $('#laundry_total').val());
            formData.append('laundry_gst_number', $('#laundry_gst_number').val());
            formData.append('laundry_doc_count', $('#laundry_doc_count').val());
            formData.append('laundry_remark', $('#laundry_remark').val());




            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);

                    if (resp.result.status == 'Success') {
                        var count_doc = resp.result.laundry_doc_count;
                        $('#laundry_doc_count_show').html(count_doc + ' Files Uploaded Preview');
                        $('#laundry_doc_count_show').addClass('hand_cursor');

                        $('#laundry_doc').val('');
                        $('#laundry_count').val('');

                        // alert('Laundry section form is successfully submitted');
                        $('#after_laundry_submit_msg').html('Data saved successfully');
                        $('#after_laundry_submit_msg').show();
                        setTimeout(() => {
                            $('#after_laundry_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_laundry_submit_msg').html(resp.result.error);
                    }
                    $('#laundry_already_ids').val(resp.result.laundry_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#laundry_from_submit').show();

                },
                error: function(error) {


                }
            })

        });


        //for Breakfast Submit form 

        $('#breakfast_from_submit').click(function() {

            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var item_base_fare = $('#breakfast_amount').val();
            if (item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ') {
                swal('Please Enter Breakfast Section amount');
                is_check = 1;
                return false;
            }

            var chk_breakfast_doc = $("input[name='breakfast_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            if (chk_breakfast_doc[0].length == 0) {
                if ($('#breakfast_already_ids').val() == '' || $('#breakfast_already_ids').val() == null) {
                    swal('Please upload atleast 1 document');
                    return false;
                }
            }


            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'B',

            //     'breakfast_amount':$('#breakfast_amount').val(),
            //     'breakfast_remark':$('#breakfast_remark').val(),
            //     'breakfast_doc_count':$('#breakfast_doc_count').val(),
            //     // 'laundry_doc':$("input[name='laundry_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };

            $('#breakfast_from_submit').hide();
            var arru_img = $("input[name='breakfast_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('breakfast_doc[]', arru_img[i][j]);

                }


            }



            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'B');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('breakfast_already_ids', $('#breakfast_already_ids').val());

            formData.append('breakfast_amount', $('#breakfast_amount').val());
            formData.append('breakfast_remark', $('#breakfast_remark').val());
            formData.append('breakfast_doc_count', $('#breakfast_doc_count').val());

            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {

                        var count_doc = resp.result.breakfast_doc_count;
                        $('#breakfast_doc_count_show').html(count_doc + ' Files Uploaded Preview');
                        $('#breakfast_doc_count_show').addClass('hand_cursor');

                        $('#breakfast_doc').val('');
                        // $('#breakfast_count').val('');

                        // alert('Breakfast section form is successfully submitted');
                        $('#after_breakfast_submit_msg').html('Data saved successfully');
                        $('#after_breakfast_submit_msg').show();
                        setTimeout(() => {
                            $('#after_breakfast_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_breakfast_submit_msg').html(resp.result.error);
                    }
                    $('#breakfast_already_ids').val(resp.result.breakfast_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#breakfast_from_submit').show();

                },
                error: function(error) {


                }
            })

        });


        //for lunch Submit form 

        $('#lunch_from_submit').click(function() {


            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var item_base_fare = $('#lunch_amount').val();
            if (item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ') {
                swal('Please Enter Lunch Section amount');
                is_check = 1;
                return false;
            }

            var chk_lunch_doc = $("input[name='lunch_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            if (chk_lunch_doc[0].length == 0) {
                if ($('#lunch_already_ids').val() == '' || $('#lunch_already_ids').val() == null) {
                    swal('Please upload atleast 1 document');
                    return false;
                }
            }

            $('#lunch_from_submit').hide();

            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'LU',

            //     'lunch_amount':$('#lunch_amount').val(),
            //     'lunch_remark':$('#lunch_remark').val(),
            //     'lunch_doc_count':$('#lunch_doc_count').val(),
            //     // 'laundry_doc':$("input[name='laundry_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };
            var arru_img = $("input[name='lunch_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('lunch_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'LU');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('lunch_already_ids', $('#lunch_already_ids').val());

            formData.append('lunch_amount', $('#lunch_amount').val());
            formData.append('lunch_remark', $('#lunch_remark').val());
            formData.append('lunch_doc_count', $('#lunch_doc_count').val());
            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        var count_doc = resp.result.lunch_doc_count;
                        $('#lunch_doc_count_show').html(count_doc + ' Files Uploaded Preview');
                        $('#lunch_doc_count_show').addClass('hand_cursor');

                        $('#lunch_doc').val('');
                        // alert('Lunch section form is successfully submitted');
                        $('#after_lunch_submit_msg').html('Data saved successfully');
                        $('#after_lunch_submit_msg').show();
                        setTimeout(() => {
                            $('#after_lunch_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_lunch_submit_msg').html(resp.result.error);
                    }
                    $('#lunch_already_ids').val(resp.result.lunch_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);

                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#lunch_from_submit').show();

                },
                error: function(error) {


                }
            })

        });


        //for dinner Submit form 

        $('#dinner_from_submit').click(function() {

            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }


            var item_base_fare = $('#dinner_amount').val();
            if (item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ') {
                swal('Please Enter Dinner Section amount');
                is_check = 1;
                return false;
            }

            var chk_dinner_doc = $("input[name='dinner_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            if (chk_dinner_doc[0].length == 0) {
                if ($('#dinner_already_ids').val() == '' || $('#dinner_already_ids').val() == null) {
                    swal('Please upload atleast 1 document');
                    return false;
                }
            }
            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'D',

            //     'dinner_amount':$('#dinner_amount').val(),
            //     'dinner_remark':$('#dinner_remark').val(),
            //     'dinner_doc_count':$('#dinner_doc_count').val(),
            //     // 'laundry_doc':$("input[name='laundry_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };
            $('#dinner_from_submit').hide();

            var arru_img = $("input[name='dinner_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('dinner_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'D');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('dinner_already_ids', $('#dinner_already_ids').val());

            formData.append('dinner_amount', $('#dinner_amount').val());
            formData.append('dinner_remark', $('#dinner_remark').val());
            formData.append('dinner_doc_count', $('#dinner_doc_count').val());

            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        var count_doc = resp.result.dinner_doc_count;
                        $('#dinner_doc_count_show').html(count_doc + ' Files Uploaded Preview');
                        $('#dinner_doc_count_show').addClass('hand_cursor');
                        $('#dinner_doc').val('');
                        // alert('Dinner section form is successfully submitted');
                        $('#after_dinner_submit_msg').html('Data saved successfully');
                        $('#after_dinner_submit_msg').show();
                        setTimeout(() => {
                            $('#after_dinner_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_dinner_submit_msg').html(resp.result.error);
                    }
                    $('#dinner_already_ids').val(resp.result.dinner_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);
                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#dinner_from_submit').show();
                },
                error: function(error) {


                }
            })

        });


        //for phone Submit form 

        $('#phone_from_submit').click(function() {

            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var item_base_fare = $('#phone_base_fare').val();
            if (item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ') {
                swal('Please Enter Phone Section basefare amounts');
                is_check = 1;
                return false;
            }



            var chk_phone_doc = $("input[name='phone_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            if (chk_phone_doc[0].length == 0) {
                if ($('#phone_already_ids').val() == '' || $('#phone_already_ids').val() == null) {
                    swal('Please upload atleast 1 document');
                    return false;
                }
            }


            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'P',
            //     'phone_base_fare':$('#phone_base_fare').val(),
            //     'phone_gst_amount':$('#phone_gst_amount').val(),
            //     'phone_total':$('#phone_total').val(),
            //     'phone_gst_number':$('#phone_gst_number').val(),
            //     'phone_doc_count':$('#phone_doc_count').val(),
            //     // 'phone_doc':$("input[name='phone_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };
            $('#phone_from_submit').hide();
            var arru_img = $("input[name='phone_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('phone_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'P');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('phone_already_ids', $('#phone_already_ids').val());

            // formData.append('laundry_name',$('#laundry_name').val());
            // formData.append('laundry_city',$('#laundry_city').val();
            formData.append('phone_base_fare', $('#phone_base_fare').val());
            formData.append('phone_gst_amount', $('#phone_gst_amount').val());
            formData.append('phone_total', $('#phone_total').val());
            formData.append('phone_gst_number', $('#phone_gst_number').val());
            formData.append('phone_doc_count', $('#phone_doc_count').val());
            formData.append('phone_remark', $('#phone_remark').val());
            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {
                        var count_doc = resp.result.phone_doc_count;
                        $('#phone_doc_count_show').html(count_doc + ' Files Uploaded Preview');
                        $('#phone_doc_count_show').addClass('hand_cursor');

                        $('#phone_doc').val('');
                        // alert('Phone section form is successfully submitted');
                        $('#after_phone_submit_msg').html('Data saved successfully');
                        $('#after_phone_submit_msg').show();
                        setTimeout(() => {
                            $('#after_phone_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_phone_submit_msg').html(resp.result.error);
                    }
                    $('#phone_already_ids').val(resp.result.phone_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);
                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#phone_from_submit').show();

                },
                error: function(error) {


                }
            })

        });


        //for local Submit form 

        // $('#local_from_submit').click(function(){

        // // alert('{{ csrf_token() }}');
        // if($('#day_date').val() == '')
        // {
        //     swal('Please Enter Date first');
        //     $('#day_date-error').html('Please Enter Date first');
        //     // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
        //     return false;
        // }else{
        //     $('#day_date-error').html('');
        // }

        // if($('#travel_from').val() == '')
        // {
        //     swal('Please Enter travel from');
        //     $('#travel_from-error').html('Please Enter travel from');
        //     return false;
        // }else{
        //     $('#travel_from-error').html('');
        // }

        // if($('#travel_to').val() == '')
        // {
        //    swal('Please Enter travel to');
        //     $('#travel_to-error').html('Please Enter travel to');
        //     // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
        //     return false;
        // }else{
        //     $('#travel_to-error').html('');
        // }
        // var item_base_fare =$('#local_base_fare').val();
        // if(item_base_fare == '' || item_base_fare == ' ' || item_base_fare == '  ')
        //     {
        //         swal('Please Enter Local Section basefare amounts');
        //         is_check=1;
        //         return false;
        //     }


        //     var chk_local_doc =$("input[name='local_doc[]']").map(function(){return $(this).prop("files");}).get();
        //     if(chk_local_doc[0].length == 0)
        //     {
        //         if($('#local_already_ids').val() == '' || $('#local_already_ids').val() == null)
        //         {
        //             swal('Please upload atleast 1 document');
        //             return false;
        //         }
        //     }

        // // var reqData = {

        // //     'jsonrpc': '2.0',
        // //     '_token': '{{ csrf_token() }}',
        // //     'data': {
        // //     'user_id':'{{ auth()->user()->id }}',
        // //     'expense_type':'WE',
        // //     'day_date':$('#day_date').val(),
        // //     'travelling_from':$('#travel_from').val(),
        // //     'travelling_to':$('#travel_to').val(),
        // //     'orvernight_at':$('#overnight_at').val(),
        // //     'type':'LC',
        // //     'local_name':$('#local_name').val(),
        // //     'local_city':$('#local_city').val(),
        // //     'local_base_fare':$('#local_base_fare').val(),
        // //     'local_gst_amount':$('#local_gst_amount').val(),
        // //     'local_total':$('#local_total').val(),
        // //     'local_gst_number':$('#local_gst_number').val(),
        // //     'local_doc_count':$('#local_doc_count').val(),
        // //     // 'local_doc':$("input[name='local_doc[]']").map(function(){return $(this).prop("files");}).get(),
        // //     }
        // // };
        // $('#local_from_submit').hide();

        // var arru_img=$("input[name='local_doc[]']").map(function(){return $(this).prop("files");}).get();
        // var formData=new FormData();
        // var img_arr=[];

        // for(let i = 0; i < arru_img.length ; i++)
        // {
        //     for(let j = 0; j < arru_img[i].length ; j++)
        //     {
        //         formData.append('local_doc[]',arru_img[i][j]);

        //     }


        // }  
        // var user_id="{{ auth()->user()->id }}";
        // formData.append('user_id',user_id);
        // formData.append('expense_type','WE');
        // formData.append('day_date',$('#day_date').val());
        // formData.append('travel_from',$('#travel_from').val());
        // formData.append('travel_to',$('#travel_to').val());
        // formData.append('overnight_at',$('#overnight_at').val());
        // formData.append('type','LC');
        // formData.append('start_date',$('#start_date').val());
        // formData.append('end_date',$('#end_date').val());

        // formData.append('local_already_ids',$('#local_already_ids').val());


        // formData.append('local_name',$('#local_name').val());
        // formData.append('local_city',$('#local_city').val());
        // formData.append('local_base_fare',$('#local_base_fare').val());
        // formData.append('local_gst_amount',$('#local_gst_amount').val());
        // formData.append('local_total',$('#local_total').val());
        // formData.append('local_gst_number',$('#local_gst_number').val());
        // formData.append('local_doc_count',$('#local_doc_count').val());
        // formData.append('local_remark',$('#local_remark').val());
        // $.ajax({

        // url: "{{ route('employee.report.save') }}",
        // dataType: 'json',
        // data: formData,
        // headers: {
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //     },
        // type: 'post',
        // cache: false,
        // processData: false,
        // contentType: false,
        // success: function(resp){
        //     console.log(resp);
        //     if(resp.result.status == 'Success')
        //     {
        //         var count_doc=resp.result.local_doc_count;
        //         $('#local_doc_count_show').html(count_doc+' Files Uploaded Preview');
        //         $('#local_doc_count_show').addClass('hand_cursor');
        //         $('#local_doc').val('');
        //         // alert('Local section form is successfully submitted'); 
        //         $('#after_local_submit_msg').html('Data saved successfully');
        //         $('#after_local_submit_msg').show();
        //         setTimeout(()=>{
        //             $('#after_local_submit_msg').hide(3000);
        //         },3000);
        //     }
        //     $('#local_already_ids').val(resp.result.local_item_ids);
        //     $('#expense_detail_id').val(resp.result.expense_detail_id);
        //     $('#expense_master_id').val(resp.result.expense_master_id);
        //     $('#local_from_submit').show();
        // },
        // error: function(error){


        // }
        // })

        // });

        //for local Submit form 

        //for misce Submit form 

        $('#misce_from_submit').click(function() {


            // alert('{{ csrf_token() }}');
            if ($('#day_date').val() == '') {
                swal('Please Enter Date first');
                $('#day_date-error').html('Please Enter Date first');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#day_date-error').html('');
            }

            if ($('#travel_from').val() == '') {
                swal('Please Enter travel from');
                $('#travel_from-error').html('Please Enter travel from');
                return false;
            } else {
                $('#travel_from-error').html('');
            }

            if ($('#travel_to').val() == '') {
                swal('Please Enter travel to');
                $('#travel_to-error').html('Please Enter travel to');
                // $('#day_date-error').scrollIntoView({behavior:'smooth'},true);
                return false;
            } else {
                $('#travel_to-error').html('');
            }

            var misce_check = $("input[name='misce_base_fare[]']").map(function() {
                return $(this).val();
            }).get();
            var is_check = 0;
            misce_check.forEach(function(item) {
                if (item == '' || item == ' ' || item == '  ') {
                    swal('Please Enter all Miscellanious Section basefare amounts');
                    is_check = 1;
                    return false;
                }

            });
            if (is_check == 1) {
                return false;
            }

            var chk_misce_img = $("input[name='misce_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var alu_ids = $('#misce_already_ids').val();
            var alr_id = alu_ids.split(',');
            chk_misce_img.forEach(function(item, index) {
                if (item.length == 0) {
                    if (alr_id[index] == '' || alr_id[index] == null || alr_id == '' || isNaN(alr_id[
                            index]) == true) {
                        swal('Please upload atleast 1 document in each row of Miscellaneous Section');
                        is_check = 1;
                        return false;
                    }
                }

            });
            if (is_check == 1) {
                return false;
            }


            // var reqData = {

            //     'jsonrpc': '2.0',
            //     '_token': '{{ csrf_token() }}',
            //     'data': {
            //     'user_id':'{{ auth()->user()->id }}',
            //     'expense_type':'WE',
            //     'day_date':$('#day_date').val(),
            //     'travelling_from':$('#travel_from').val(),
            //     'travelling_to':$('#travel_to').val(),
            //     'orvernight_at':$('#overnight_at').val(),
            //     'type':'M',
            //     // 'misce_name':$("input[name='misce_name[]']").map(function(){return $(this).val();}).get(),
            //     // 'misce_city':$("input[name='misce_city[]']").map(function(){return $(this).val();}).get(),
            //     'misce_base_fare':$("input[name='misce_base_fare[]']").map(function(){return $(this).val();}).get(),
            //     'misce_gst_amount':$("input[name='misce_gst_amount[]']").map(function(){return $(this).val();}).get(),
            //     'misce_total':$("input[name='misce_total[]']").map(function(){return $(this).val();}).get(),
            //     'misce_gst_number':$("input[name='misce_gst_number[]']").map(function(){return $(this).val();}).get(),
            //     'misce_doc_count':$("input[name='misce_doc_count[]']").map(function(){return $(this).val();}).get(),
            //     // 'misce_doc':$("input[name='misce_doc[]']").map(function(){return $(this).prop("files");}).get(),
            //     }
            // };

            $('#misce_from_submit').hide();
            $('#misce_add_more').hide();

            var arru_img = $("input[name='misce_doc[]']").map(function() {
                return $(this).prop("files");
            }).get();
            var formData = new FormData();
            var img_arr = [];

            for (let i = 0; i < arru_img.length; i++) {
                for (let j = 0; j < arru_img[i].length; j++) {
                    formData.append('misce_doc[]', arru_img[i][j]);

                }


            }
            var user_id = "{{ auth()->user()->id }}";
            formData.append('user_id', user_id);
            formData.append('expense_type', 'WE');
            formData.append('day_date', $('#day_date').val());
            formData.append('travel_from', $('#travel_from').val());
            formData.append('travel_to', $('#travel_to').val());
            formData.append('overnight_at', $('#overnight_at').val());
            formData.append('type', 'M');
            formData.append('start_date', $('#start_date').val());
            formData.append('end_date', $('#end_date').val());

            formData.append('misce_already_ids', $('#misce_already_ids').val());
            $(".misce_selt").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_select[]', item);
            })

            $("input[name='misce_false_id[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_false_id[]', item);
            })

            $("input[name='misce_base_fare[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_base_fare[]', item);
            })

            $("input[name='misce_gst_amount[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_gst_amount[]', item);
            })
            $("input[name='misce_total[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_total[]', item);
            })
            $("input[name='misce_gst_number[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_gst_number[]', item);
            })
            $("input[name='misce_doc_count[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_doc_count[]', item);
            })

            $("input[name='misce_remark[]']").map(function() {
                return $(this).val();
            }).get().forEach(function(item) {
                formData.append('misce_remark[]', item);
            })
            $.ajax({

                url: "{{ route('employee.report.save') }}",
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                cache: false,
                processData: false,
                contentType: false,
                success: function(resp) {
                    console.log(resp);
                    if (resp.result.status == 'Success') {

                        // alert('Miscellanous section form is successfully submitted');
                        var misce_counts = parseInt($('#misce_count').val()) + 1;
                        for (var i = 0; i < misce_counts; i++) {

                            var doc_countin = 0;
                            resp.result.misc_false_id.forEach(function(item, index) {
                                if (item == i) {
                                    doc_countin = resp.result.misc_doc_count[index];
                                }

                            });
                            var count_doc = doc_countin;
                            $('#misce_doc_' + i + '_count_show').html(count_doc +
                                ' Files Uploaded Preview');
                            $('#misce_doc_' + i + '_count_show').addClass('hand_cursor');

                            $('#misce_doc_' + i).val('');
                            $('#misce_doc_count_' + i).val('');
                        }

                        $('#after_misce_submit_msg').html('Data saved successfully');
                        $('#after_misce_submit_msg').show();
                        setTimeout(() => {
                            $('#after_misce_submit_msg').hide(3000);
                        }, 3000);
                    } else {
                        $('#after_misce_submit_msg').html(resp.result.error);
                    }
                    $('#misce_already_ids').val(resp.result.misc_item_ids);
                    $('#expense_detail_id').val(resp.result.expense_detail_id);
                    $('#expense_master_id').val(resp.result.expense_master_id);

                    $('#misce_from_submit').show();
                    $('#misce_add_more').show();

                },
                error: function(error) {


                }
            })

        });
    </script>
    <script>
        function remove_extra_row(row_id, type) {
            // if(confirm('Do you really want to delete this item Record?') == false)
            // {
            //     return false;
            // }

            swal({
                    text: "Do you really want to delete this item Record?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    background: '#28a745',
                })
                .then((willDelete) => {
                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                    if (willDelete) {


                        if (row_id == '') {
                            swal('something is wrong!!');
                            false;
                        }
                        var expense_detail_id = $('#expense_detail_id').val();


                        if (type == 'R') {
                            $('#rail_false_id_' + row_id).val('');
                            $('.rail_extra_' + row_id).remove();
                        } else if (type == 'T') {
                            $('#taxi_false_id_' + row_id).val('');
                            $('.taxi_extra_' + row_id).remove();
                        } else if (type == 'H') {
                            $('#hotel_false_id_' + row_id).val('');
                            $('.hotel_extra_' + row_id).remove();
                        } else if (type == 'M') {
                            $('#misce_false_id_' + row_id).val('');
                            $('.misce_extra_' + row_id).remove();
                        }



                        $.ajax({

                            url: "{{ route('employee.report.delete.row') }}",
                            dataType: 'json',
                            data: {
                                row_id: row_id,
                                type: type,
                                expense_detail_id: expense_detail_id

                            },
                            type: 'get',
                            // cache: false,
                            // processData: false,
                            // contentType: false,
                            success: function(resp) {
                                console.log(resp);
                                if (resp.result.error == 'No') {
                                    swal('Item Record delete successfully');
                                    // $('#misce_already_ids').val(resp.result.misc_item_ids);
                                    if (type == 'R') {
                                        $('#rail_already_ids').val(resp.result.all_prev_ids);
                                    } else if (type == 'T') {
                                        $('#taxi_already_ids').val(resp.result.all_prev_ids);
                                    } else if (type == 'H') {
                                        $('#hotel_already_ids').val(resp.result.all_prev_ids);
                                    } else if (type == 'M') {
                                        $('#misce_already_ids').val(resp.result.all_prev_ids);
                                    }

                                }

                                cal_grand_tot();

                            },
                            error: function(error) {


                            }
                        })

                        cal_grand_tot();
                    }
                });


        }

        function Show_Doc_Add(false_id = null, type = null, doc_show_id) {
            if (false_id < 1 || false_id == '') {
                alert('no false id');
                return false;
            }
            var exp_detail_id = $('#expense_detail_id').val();
            if (exp_detail_id == '' || exp_detail_id == ' ') {
                alert('no expense id');
                return false;
            }


            $.ajax({

                url: "{{ route('show.all.doc.during.add') }}",
                dataType: 'json',
                data: {
                    false_id: false_id,
                    exp_detail_id: exp_detail_id,
                    type: type

                },
                type: 'get',
                // cache: false,
                // processData: false,
                // contentType: false,
                success: function(resp) {
                    console.log(resp);
                    var doc_html = '<div class="owl-carousel owl-theme popup_images_slider" >';
                    var img_folder = '';
                    resp.result.img_doc.forEach(function(item) {
                        if (resp.result.item_type == 'R') {
                            img_folder = `rail`;
                        }
                        if (resp.result.item_type == 'T') {
                            img_folder = `taxi`;
                        }
                        if (resp.result.item_type == 'H') {
                            img_folder = `hotel`;
                        }
                        if (resp.result.item_type == 'L') {
                            img_folder = `laundry`;
                        }
                        if (resp.result.item_type == 'B') {
                            img_folder = `breakfast`;
                        }
                        if (resp.result.item_type == 'LU') {
                            img_folder = `lunch`;
                        }
                        if (resp.result.item_type == 'D') {
                            img_folder = `dinner`;
                        }
                        if (resp.result.item_type == 'P') {
                            img_folder = `phone`;
                        }
                        if (resp.result.item_type == 'LC') {
                            img_folder = `local`;
                        }
                        if (resp.result.item_type == 'M') {
                            img_folder = `misce`;
                        }
                        if (item.file_type == 'image') {


                            doc_html += `<div class="item delete_doc_${item.id}">
                                            <img src="{{ URL::to('storage/app/public/report/${img_folder}/') }}/${item.doc_name}" alt="">
                                            <a href="javascript:;" alt="Delete Image"><i class="fa fa-close" onclick="delete_docs('${item.id}','${item.expense_item_id}','${doc_show_id}')"></i></a>
                                            </div>`;
                        } else {
                            doc_html += `<div class="item delete_doc_${item.id}">
                                            <a href="{{ URL::to('storage/app/public/report/${img_folder}/') }}/${item.doc_name}" target="_blank">
                                            <img src="{{ asset('public/front_assets/images/pdf_image.png') }}" alt="">
                                            <label><b>${item.doc_name}</b></label></a>
                                            <a href="javascript:;" alt="Delete Image"><i class="fa fa-close" onclick="delete_docs('${item.id}','${item.expense_item_id}','${doc_show_id}')"></i></a>
                                            </div>`;
                        }



                    })
                    doc_html += `</div>`;
                    //    console.log(doc_html);
                    $('#showing_all_doc').html(doc_html);
                    $('#myModal').modal('show');
                    for_slider(resp.result.doc_count);



                },
                error: function(error) {
                    alert(error);

                }
            })
        }




        function for_slider(img_count) {
            $('.popup_images_slider').owlCarousel({
                loop: false,
                dots: false,
                autoplay: false,
                center: true,
                nav: true,

                stagePadding: 500,
                margin: 350,
                items: 3,

                responsive: {

                    320: {

                        stagePadding: 100,
                        margin: 150,
                        items: 1,
                    },
                    480: {

                        stagePadding: 100,
                        margin: 150,
                        items: 1,
                    },
                    767: {

                        stagePadding: 100,
                        margin: 150,
                        items: 1,
                    },
                    991: {

                        stagePadding: 0,
                        margin: 250,
                        items: 3,
                    },
                    1199: {

                        stagePadding: 0,
                        margin: 250,
                        items: 3,
                    },
                    1399: {

                        stagePadding: 0,
                        margin: 250,
                        items: 3,

                    }
                }
            })
        }



        function delete_docs(doc_id, item_id, doc_show_id = null) {
            // if(confirm('Do you really want to delete this file?') == false)
            // {
            //     return false;
            // }
            swal({
                    text: "Do you really want to delete this file?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    background: '#28a745',
                })
                .then((willDelete) => {
                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                    if (willDelete) {

                        if (doc_id != '' && item_id != '') {

                            $.ajax({

                                url: "{{ route('employee.report.delete.doc') }}",
                                dataType: 'json',
                                data: {
                                    doc_id: doc_id,
                                    item_id: item_id
                                },
                                type: 'get',
                                // cache: false,
                                // processData: false,
                                // contentType: false,
                                success: function(resp) {
                                    console.log(resp);

                                    if (resp.result.error == 'yes') {
                                        swal('No Docs found!!');
                                    } else {
                                        $('.delete_doc_' + doc_id).remove();
                                        $('#' + doc_show_id).html(resp.result.doc_count_shw +
                                            ' Files Uploaded Preview');
                                        swal('file deleted successfully');
                                    }


                                },
                                error: function(error) {
                                    swal(error);

                                }
                            })
                        } else {
                            swal('No Docs found!!');
                        }

                    }
                });
        }
        //   $(document).bind('keypress', function(event) {
        //         if( event.which === 65 && event.shiftKey ) {
        //             alert('you pressed SHIFT+A');
        //         }
        //     });
        //   $(".gst_validat").bind("keypress",function(e){
        //     console.log(e.currentTarget.value);

        //         //if the letter is not digit then display error and don't type anything 
        //         // if(e.which == 17 || e.which == 2 )
        //         // {
        //         //     alert('no');
        //         // }
        //         if (e.which >= 65 && e.which <= 90 || e.which >= 48 && e.which <= 57 || e.which >= 97 && e.which <= 122) { 

        //             var str_otp=e.currentTarget.value;
        //             var t_otp=str_otp.substr(0,15);
        //             // self.val(self.val().replace(t_otp));
        //             e.currentTarget.value=t_otp;
        //             if(str_otp.length < 15)
        //             {
        //                 return true; 
        //             }else{
        //                 e.preventDefault();
        //             }

        //         }else{
        //             return false;
        //             e.preventDefault();
        //         }
        //   })
        // $(".gst_validat").map(function(){return $(this);}).keypress(function(e){
        //    alert('213423');
        // })

        //for GST number validations 
        $(".gst_validat").keypress(function(e) {
            //    console.log(e.currentTarget.value);

            //if the letter is not digit then display error and don't type anything 
            // if(e.which == 17 || e.which == 2 )
            // {
            //     alert('no');
            // }
            if (e.which >= 65 && e.which <= 90 || e.which >= 48 && e.which <= 57 || e.which >= 97 && e.which <=
                122) {

                var str_otp = e.currentTarget.value;
                var t_otp = str_otp.substr(0, 15);
                // self.val(self.val().replace(t_otp));
                e.currentTarget.value = t_otp;
                if (str_otp.length < 15) {
                    return true;
                } else {
                    e.preventDefault();
                }

            } else {
                return false;
                e.preventDefault();
            }

        });

        function gst_valu(e, ele_id = null) {
            // console.log(e.currentTarget.value);
            if (e.which >= 65 && e.which <= 90 || e.which >= 48 && e.which <= 57 || e.which >= 97 && e.which <= 122) {
                var str_otp = e.currentTarget.value;
                var t_otp = str_otp.substr(0, 15);
                // self.val(self.val().replace(t_otp));
                e.currentTarget.value = t_otp;
                if (str_otp.length < 15) {
                    return true;
                } else {
                    e.preventDefault();
                }
            } else {
                return false;
                e.preventDefault();
            }
        }

        function base_valu(evt) {
            if (evt.which < 48 || evt.which > 57 || evt.which == 46) {
                if (evt.which == 46) {

                } else {
                    return false;
                    evt.preventDefault();
                }

            }


            var re = /^[-+]?[0-9]+\.[0-9]+$/;
            var num_re = /^\d+$/;

            var self = evt.target.value;
            var is_value = isNaN(self);
            console.log(is_value, self);
            var letter_Count = 0;
            for (var position = 0; position < self.length; position++) {
                if (self.charAt(position) == '.') {
                    letter_Count += 1;
                }
            }
            if (is_value == true || self != '') {
                if (re.test(self) || num_re.test(self) || letter_Count == 1) {
                    if (letter_Count == 1) {
                        if (evt.which < 48 || evt.which > 57) {

                            return false;
                            evt.preventDefault();
                        } else {

                            return true;
                        }
                    }

                    return true;
                } else {

                    return false;
                    evt.preventDefault();
                }

            } else {

                if (evt.which < 48 || evt.which > 57) {

                    return false;
                    evt.preventDefault();
                } else {

                    return true;
                }
            }
        }


        function chnag_taxi_select(item_id = null) {
            if (isNaN(item_id) == true) {
                return false;
            }
            var valu = $('#taxi_select_' + item_id).val();
            if (valu == '') {
                return false;
            }
            if (valu == 'O') {
                $('#taxi_show_gst_amt_' + item_id).html('GST Amount *');
                $('#taxi_show_gst_no_' + item_id).html('GST Number *');
            } else {
                $('#taxi_show_gst_amt_' + item_id).html('GST Amount');
                $('#taxi_show_gst_no_' + item_id).html('GST Number');
            }

        }
    </script>
    <script>
        $(document).ready(function() {
            // When the value of the dropdown changes
            $('#taxi_select_1').change(function() {
                // If "Individual" is selected
                if ($(this).val() === 'I') {
                    // Disable the file input field
                    $('#taxi_doc_1').prop('required', false);
                } else {
                    // Enable the file input field
                    $('#taxi_doc_1').prop('required', true);
                }
            });
        });
    </script>
@endsection
