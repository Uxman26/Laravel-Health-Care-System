@extends('layouts.app')
@section('title')
Expence Report Detail
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




    <div class="right-page">
        <div class="r8-page-heading">
            @include('includes.message')
            <div style="display: flex;align-content: center;justify-content: space-between;">
                <h2>History > {{@$master->expense_unique_code}}</h2> 
                <h3 class="@if(@$approval_text == 'Approved') text-success @else text-warning @endif"><b>@if(@$master->getMemo->status == 'I') Transaction Initiated @elseif(@$master->getMemo->status == 'C') Transaction Completed @elseif(@$master->getMemo->status == 'H') On-Hold @elseif(@$master->getMemo->status == 'R') Rejected @else{{@$approval_text}} @endif</b></h3>
            </div>
        </div>

        <div class="empl">
           <div style="display: flex;align-content: center;justify-content: space-between;">
            <h3>Employee Details</h3>
            <h3><a href="javascipt:;">{{@$master->expense_unique_code}}</a></h3>
            </div>

            <div class="row mt-3">
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Employee ID</label>
                        <h3>{{@$master->getUser->empID}}</h3>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="{{@$master->getUser->id}}">
                    <input type="hidden" name="emp_id" id="emp_id" value="{{@$master->getUser->empID}}">
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Employee Name</label>
                        <h3>{{@$master->getUser->name}}</h3>
                    </div>
                    <input type="hidden" name="emp_name" id="emp_name" value="{{@$master->getUser->name}}">
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12">
                    <div class="empl-box">
                        <label for="">Designation</label>
                        <h3>{{@$master->getUser->designation}}</h3>
                    </div>
                    <input type="hidden" name="designation" id="designation" value="{{@$master->getUser->designation}}">
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
                        <h3>{{@$master->getUser->division}}</h3>
                    </div>
                </div>
            </div>

        </div> 

        @if(@$expense->getExpenseMaster->status == 'R' || @$expense->getExpenseMaster->status == 'H' || @$expense->remark != null)
          <div class="empl sho_only02 noop">
            <div class="fill-inr-box fill2" >
              <h3 style="text-align:center"><u>@if(@$expense->getExpenseMaster->status == 'H') On-Hold @else Rejection @endif  Remark </u></h3><p style="font-size:14px">{{@$expense->remark}}</p>
            </div>  
          </div>
          @endif 

        <div class="exp-date">
            <h3>Select Date <img src="{{asset('public/front_assets/images/calendar-white.png')}}" alt=""></h3>
            <ul class="d-flex justify-content-start align-items-center">
                @if(count(@$allDates) > 0)
                    @foreach(@$allDates as $expenseDetail)
                    <li><label for="" @if(@$expense->date == @$expenseDetail->date) class="active" @endif >
                    <a href="{{route('view.history.report',@$expenseDetail->id)}}" @if(@$expense->date != @$expenseDetail->date) style="color: #8a8a8a;" @endif>{{@$expenseDetail->date ? date('d-m-Y', strtotime(@$expenseDetail->date)) : ''}}</a>
                    </label></li>
                    @endforeach
                @endif
            </ul>
        </div>

        <input type="hidden" name="start_date" id="start_date">
        <input type="hidden" name="end_date" id="end_date">

       
        <div class="r8-filler-inr pt-0">
            <div class="fill-inr-box fill1 position-relative">

                <h4 class="expense-title"><span></span>Expense Details</h4>
                <input type="hidden" id="expenseDetailID" value="{{@$expense->id}}" />
                <input type="hidden" id="all_docs_array" />
                {{--<a class="download-doc downloadAllBtn" href="javascript:;" data-value="1"><img
                        src="{{asset('public/front_assets/images/arrow-down-circle 1.png')}}" alt=""> Download All
                    Supporting Documents</a>--}}
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box fill-date">
                            <label for="">Date</label>
                            <input type="text" placeholder="Enter Here"
                                value="{{@$expense ? date('d-m-Y',strtotime(@$expense->date)) : ''}}" name="day_date"
                                id="day_date" readonly>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xl-4  col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Travelled From</label>
                            <div class="item-box">
                                <p>{{@$expense->travelling_from}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Travelled To</label>
                            <div class="item-box">
                                <p>{{@$expense->travelling_to}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="fill-box">
                            <label for="">Overnight at</label>
                            <div class="item-box">
                                <p>{{@$expense->orvernight_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(auth()->user()->user_type == 'AHY')
                <div class="stamps-div d-flex position-absolute justify-content-end align-items-center">
                    <img src="{{asset('public/front_assets/images/stamp1.png')}}" alt="" class="d-block">
                    <img src="{{asset('public/front_assets/images/stamp2.png')}}" alt="" class="d-block">
                    <img src="{{asset('public/front_assets/images/stamp3.png')}}" alt="" class="d-block">
                </div>
                @endif
            </div>

           
            
          
            <div class="fill-inr-box fill2 fill-grey">

                <h4><span></span> Rail/Air</h4>

                @if(count(@$expense->getExpenseItemRail) > 0)
                @foreach(@$expense->getExpenseItemRail as $rail)
                <div class="row rail_row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare
                            @if(@$rail->approved_gst_amount > 0 || @$rail->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$rail->approved_gst_amount}}" 
                                data-comment="{{@$rail->comment}}" 
                                data-itemid="{{@$rail->id}}"
                                data-expenseid="{{@$rail->expense_detail_id}}" 
                                data-claimedamt="{{@$rail->gst_amount}}" 
                                data-title="Rail/Air"
                                data-gstavailable="Yes"
                                data-base_amt="{{@$rail->basefare}}"
                                data-apr_base_amt="{{@$rail->approved_amount -@$rail->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$rail->approved_gst_amount > 0 || @$rail->comment) yellow_box @endif">
                                <p>
                                @if(@$rail->approved_gst_amount > 0 || @$rail->comment)
                                 <strike>{{@$rail->basefare}}</strike> {{@$rail->approved_amount - @$rail->approved_gst_amount}}
                                 @else
                                    {{@$rail->basefare ? number_format(@$rail->basefare,2) : 0}}
                                 @endif
                                   
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$rail->approved_gst_amount > 0 || @$rail->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$rail->approved_gst_amount}}" 
                                data-comment="{{@$rail->comment}}" 
                                data-itemid="{{@$rail->id}}"
                                data-expenseid="{{@$rail->expense_detail_id}}" 
                                data-claimedamt="{{@$rail->gst_amount}}" 
                                data-title="Rail/Air"
                                data-gstavailable="Yes"
                                data-base_amt="{{@$rail->basefare}}"
                                data-apr_base_amt="{{@$rail->approved_amount -@$rail->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$rail->approved_gst_amount > 0 || @$rail->comment) yellow_box @endif">
                                <p>
                                @if(@$rail->approved_gst_amount > 0 || @$rail->comment)
                                 <strike>{{@$rail->gst_amount}}</strike> {{@$rail->approved_gst_amount}}
                                 @else
                                    {{@$rail->gst_amount ? number_format(@$rail->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                            <p style="font-size: 14px;line-height: 15px;">
                            @if(@$rail->approved_gst_amount > 0 || @$rail->comment)
                                 <strike>{{@$rail->total}}</strike> {{@$rail->approved_amount}}
                                 @else
                                    {{@$rail->total ? number_format(@$rail->total,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$rail->gst_no ? @$rail->gst_no : "-"}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$rail->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$rail->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label> 
                            <div class="item-box">
                                <p>{{@$rail->remark ? @$rail->remark : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count(@$expense->getExpenseItemRail) > 1)
                <hr>
                @endif
                @endforeach
                @else
                No expense found for this section
                @endif

            </div>

            <div class="fill-inr-box fill3">
                <div class="fill-top d-flex justify-content-start align-items-center">
                    <h4><span></span>Taxi/Bus/Rickshaw</h4>
                </div>
                @if(count(@$expense->getExpenseItemTaxi) > 0)
                @foreach(@$expense->getExpenseItemTaxi as $taxi)
                <div class="row taxi_row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="fill-box">
                            <div class="item-box">
                                <p>
                                {{-- @if(@$taxi->taxi_option == 'O')
                                    Organization
                                @elseif(@$taxi->taxi_option == 'I')
                                Individual --}}
                                @if(@$taxi->taxi_option == '1')
                                Taxi
                                @elseif(@$taxi->taxi_option == '2')
                                Bus
                                @elseif(@$taxi->taxi_option == '3')
                                Rickshaw
                                @else 
                                -
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="taxi_count" value="1">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare
                            @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$taxi->approved_gst_amount}}" 
                                data-comment="{{@$taxi->comment}}" 
                                data-itemid="{{@$taxi->id}}"
                                data-expenseid="{{@$taxi->expense_detail_id}}" 
                                data-claimedamt="{{@$taxi->gst_amount}}" 
                                data-title="Taxi/Bus/Rickshaw"
                                data-base_amt="{{@$taxi->basefare}}"
                                data-apr_base_amt="{{@$taxi->approved_amount -@$taxi->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box  @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment) yellow_box @endif">
                                <p style="font-size: 14px;line-height: 15px;">
                                @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment)
                                 <strike>{{@$taxi->basefare}}</strike> {{@$taxi->approved_amount - @$taxi->approved_gst_amount}}
                                 @else
                                    {{@$taxi->basefare ? number_format(@$taxi->basefare,2) : 0}}
                                 @endif
                               
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4  col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$taxi->approved_gst_amount}}" 
                                data-comment="{{@$taxi->comment}}" 
                                data-itemid="{{@$taxi->id}}"
                                data-expenseid="{{@$taxi->expense_detail_id}}" 
                                data-claimedamt="{{@$taxi->gst_amount}}" 
                                data-title="Taxi/Bus/Rickshaw"
                                data-base_amt="{{@$taxi->basefare}}"
                                data-apr_base_amt="{{@$taxi->approved_amount -@$taxi->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment) yellow_box @endif">
                                <p>
                                @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment)
                                 <strike>{{@$taxi->gst_amount}}</strike> {{@$taxi->approved_gst_amount}}
                                 @else
                                    {{@$taxi->gst_amount ? number_format(@$taxi->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$taxi->approved_gst_amount > 0 || @$taxi->comment)
                                    <strike>{{@$taxi->total}}</strike> {{@$taxi->approved_amount }}
                                    @else
                                    {{@$taxi->total ? number_format(@$taxi->total,2) : 0}}
                                    @endif
                                   
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$taxi->gst_no ? @$taxi->gst_no : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="taxi_doc_count[]" id="taxi_doc_count_1">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$taxi->getExpenseItemDoc)}} Documents  <span onclick="all_doc_show('{{@$taxi->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$taxi->remark ? @$taxi->remark : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count(@$expense->getExpenseItemTaxi) > 1)
                <hr>
                @endif
                @endforeach
                @else
                No expense found for this section
                @endif
            </div>

            <div class="fill-inr-box fill4 fill-grey">
                <h4><span></span>Hotel</h4>

                @if(count(@$expense->getExpenseItemHotel) > 0)
                @foreach(@$expense->getExpenseItemHotel as $hotel)
                <div class="row hotel_row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Hotel Name</label>
                            <div class="item-box">
                                <p>{{@$hotel->hotel_name ? @$hotel->hotel_name : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <div class="item-box">
                                <p>{{@$hotel->hotel_city ? @$hotel->hotel_city : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)
                            @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$hotel->approved_gst_amount}}" 
                                data-comment="{{@$hotel->comment}}" 
                                data-itemid="{{@$hotel->id}}"
                                data-expenseid="{{@$hotel->expense_detail_id}}" 
                                data-claimedamt="{{@$hotel->gst_amount}}" 
                                data-title="Hotel"
                                data-base_amt="{{@$hotel->basefare}}"
                                data-apr_base_amt="{{@$hotel->approved_amount -@$hotel->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment) yellow_box @endif">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment)
                                    <strike>{{@$hotel->basefare}}</strike> {{@$hotel->approved_amount - @$hotel->approved_gst_amount }}
                                    @else
                                    {{@$hotel->basefare ? number_format(@$hotel->basefare,2) : 0}}
                                    @endif
                                   
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$hotel->approved_gst_amount}}" 
                                data-comment="{{@$hotel->comment}}" 
                                data-itemid="{{@$hotel->id}}"
                                data-expenseid="{{@$hotel->expense_detail_id}}" 
                                data-claimedamt="{{@$hotel->gst_amount}}" 
                                data-title="Hotel"
                                data-base_amt="{{@$hotel->basefare}}"
                                data-apr_base_amt="{{@$hotel->approved_amount -@$hotel->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment) yellow_box @endif">
                                <p>
                                @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment)
                                 <strike>{{@$hotel->gst_amount}}</strike> {{@$hotel->approved_gst_amount}}
                                 @else
                                    {{@$hotel->gst_amount ? number_format(@$hotel->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                                <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$hotel->approved_gst_amount > 0 || @$hotel->comment)
                                    <strike>{{@$hotel->total}}</strike> {{@$hotel->approved_amount }}
                                    @else
                                    {{@$hotel->total ? number_format(@$hotel->total,2) : 0}}
                                    @endif
                                   
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$hotel->gst_no ? @$hotel->gst_no : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$hotel->getExpenseItemDoc)}} Documents  <span onclick="all_doc_show('{{@$hotel->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$hotel->remark ? @$hotel->remark : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count(@$expense->getExpenseItemHotel) > 1)
                <hr>
                @endif
                @endforeach
                @else
                No expense found for this section
                @endif

            </div>

            <div class="fill-inr-box fill5">
                <h4><span></span>Laundry Charges</h4>
                @if(@$expense->getExpenseItemLaundry)
                <div class="row laundry_row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Laundry Name</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLaundry->hotel_name ? @$expense->getExpenseItemLaundry->hotel_name : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLaundry->hotel_city ? @$expense->getExpenseItemLaundry->hotel_city : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)
                            @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLaundry->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLaundry->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLaundry->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLaundry->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLaundry->gst_amount}}" 
                                data-title="Laundry Charges"
                                data-base_amt="{{@$expense->getExpenseItemLaundry->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemLaundry->approved_amount -@$expense->getExpenseItemLaundry->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment) yellow_box @endif">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                                    <strike>{{@$expense->getExpenseItemLaundry->basefare}}</strike> {{@$expense->getExpenseItemLaundry->approved_amount - @$expense->getExpenseItemLaundry->approved_gst_amount }}
                                    @else
                                    {{@$expense->getExpenseItemLaundry->basefare ? number_format(@$expense->getExpenseItemLaundry->basefare,2) : 0}}
                                    @endif
                                   
                                </p>
                              
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLaundry->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLaundry->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLaundry->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLaundry->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLaundry->gst_amount}}" 
                                data-title="Laundry Charges"
                                data-base_amt="{{@$expense->getExpenseItemLaundry->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemLaundry->approved_amount -@$expense->getExpenseItemLaundry->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                                 <strike>{{@$expense->getExpenseItemLaundry->gst_amount}}</strike> {{@$expense->getExpenseItemLaundry->approved_gst_amount}}
                                 @else
                                    {{@$expense->getExpenseItemLaundry->gst_amount ? number_format(@$expense->getExpenseItemLaundry->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                                    <strike>{{@$expense->getExpenseItemLaundry->total}}</strike> {{@$expense->getExpenseItemLaundry->approved_amount }}
                                    @else
                                    {{@$expense->getExpenseItemLaundry->total ? number_format(@$expense->getExpenseItemLaundry->total,2) : 0}}
                                    @endif
                                   
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLaundry->gst_no ? @$expense->getExpenseItemLaundry->gst_no : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemLaundry->getExpenseItemDoc)}} Documents  <span onclick="all_doc_show('{{@$expense->getExpenseItemLaundry->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLaundry->remark ? @$hotel->remark : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>

            <div class="fill-inr-box fill6 fill-grey">
                <h4><span></span>Breakfast</h4>

                @if(@$expense->getExpenseItemBreakfast)
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount 
                                @if(@$expense->getExpenseItemBreakfast->approved_amount > 0 || @$expense->getExpenseItemBreakfast->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemBreakfast->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemBreakfast->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemBreakfast->id}}"
                                data-expenseid="{{@$expense->getExpenseItemBreakfast->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemBreakfast->basefare}}" 
                                data-title="Breakfast"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemBreakfast->approved_amount > 0 || @$expense->getExpenseItemBreakfast->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemBreakfast->approved_amount > 0 || @$expense->getExpenseItemBreakfast->comment)
                                 <strike>{{@$expense->getExpenseItemBreakfast->basefare}}</strike> {{@$expense->getExpenseItemBreakfast->approved_amount}}
                                 @else
                                    {{@$expense->getExpenseItemBreakfast->basefare ? number_format(@$expense->getExpenseItemBreakfast->basefare,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemBreakfast->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$expense->getExpenseItemBreakfast->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>   
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemBreakfast->remark ? @$expense->getExpenseItemBreakfast->remark : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>
            <div class="fill-inr-box fill6">
                <h4><span></span>Lunch</h4>

                @if(@$expense->getExpenseItemLunch)
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount 
                                @if(@$expense->getExpenseItemLunch->approved_amount > 0 || @$expense->getExpenseItemLunch->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLunch->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLunch->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLunch->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLunch->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLunch->basefare}}" 
                                data-title="Lunch"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemLunch->approved_amount > 0 || @$expense->getExpenseItemLunch->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemLunch->approved_amount > 0 || @$expense->getExpenseItemLunch->comment)
                                 <strike>{{@$expense->getExpenseItemLunch->basefare}}</strike> {{@$expense->getExpenseItemLunch->approved_amount}}
                                 @else
                                    {{@$expense->getExpenseItemLunch->basefare ? number_format(@$expense->getExpenseItemLunch->basefare,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemLunch->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$expense->getExpenseItemLunch->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>      
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLunch->remark ? @$expense->getExpenseItemLunch->remark : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>
            <div class="fill-inr-box fill6 fill-grey">
                <h4><span></span>Dinner</h4>

                @if(@$expense->getExpenseItemDinner)
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Amount 
                                @if(@$expense->getExpenseItemDinner->approved_amount > 0 || @$expense->getExpenseItemDinner->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemDinner->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemDinner->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemDinner->id}}"
                                data-expenseid="{{@$expense->getExpenseItemDinner->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemDinner->basefare}}" 
                                data-title="Dinner"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemDinner->approved_amount > 0 || @$expense->getExpenseItemDinner->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemDinner->approved_amount > 0 && @$expense->getExpenseItemDinner->comment)
                                 <strike>{{@$expense->getExpenseItemDinner->basefare}}</strike> {{@$expense->getExpenseItemDinner->approved_amount}}
                                 @else
                                    {{@$expense->getExpenseItemDinner->basefare ? number_format(@$expense->getExpenseItemDinner->basefare,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemDinner->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$expense->getExpenseItemDinner->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>        
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemDinner->remark ? @$expense->getExpenseItemDinner->remark : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>
            <div class="fill-inr-box fill5">
                <h4><span></span>Phone</h4>

                @if(@$expense->getExpenseItemPhone)
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare
                            @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemPhone->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemPhone->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemPhone->id}}"
                                data-expenseid="{{@$expense->getExpenseItemPhone->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemPhone->gst_amount}}" 
                                data-title="Phone"
                                data-base_amt="{{@$expense->getExpenseItemPhone->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemPhone->approved_amount -@$expense->getExpenseItemPhone->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment) yellow_box @endif">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                    <strike>{{@$expense->getExpenseItemPhone->basefare}}</strike> {{@$expense->getExpenseItemPhone->approved_amount - @$expense->getExpenseItemPhone->approved_gst_amount }}
                                    @else
                                    {{@$expense->getExpenseItemPhone->basefare ? number_format(@$expense->getExpenseItemPhone->basefare,2) : 0}}
                                    @endif
                                   
                                </p>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemPhone->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemPhone->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemPhone->id}}"
                                data-expenseid="{{@$expense->getExpenseItemPhone->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemPhone->gst_amount}}" 
                                data-title="Phone"
                                data-base_amt="{{@$expense->getExpenseItemPhone->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemPhone->approved_amount -@$expense->getExpenseItemPhone->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                 <strike>{{@$expense->getExpenseItemPhone->gst_amount}}</strike> {{@$expense->getExpenseItemPhone->approved_gst_amount}}
                                 @else
                                    {{@$expense->getExpenseItemPhone->gst_amount ? number_format(@$expense->getExpenseItemPhone->gst_amount,2) : 0}}
                                 @endif
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                    <strike>{{@$expense->getExpenseItemPhone->total}}</strike> {{@$expense->getExpenseItemPhone->approved_amount }}
                                    @else
                                    {{@$expense->getExpenseItemPhone->total ? number_format(@$expense->getExpenseItemPhone->total,2) : 0}}
                                    @endif
                                   
                                </p>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemPhone->gst_no ? @$expense->getExpenseItemPhone->gst_no : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemPhone->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$expense->getExpenseItemPhone->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemPhone->remark ? @$expense->getExpenseItemPhone->remark : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>
            
            {{--<div class="fill-inr-box fill5 fill-grey">
                <h4><span></span>Local Convayence</h4>

                @if(@$expense->getExpenseItemLocal)
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Local Name</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->hotel_name ? @$expense->getExpenseItemLocal->hotel_name : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->hotel_city ? @$expense->getExpenseItemLocal->hotel_city : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Fare (Exclude GST)</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->basefare ? number_format(@$expense->getExpenseItemLocal->basefare,2) : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLocal->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLocal->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLocal->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLocal->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLocal->gst_amount}}" 
                                data-title="Local Convayence"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment) yellow_box @endif">
                                <p>
                                @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment)
                                 <strike>{{@$expense->getExpenseItemLocal->gst_amount}}</strike> {{@$expense->getExpenseItemLocal->approved_gst_amount}}
                                 @else
                                    {{@$expense->getExpenseItemLocal->gst_amount ? number_format(@$expense->getExpenseItemLocal->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->total ? number_format(@$expense->getExpenseItemLocal->total,2) : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->gst_no ? @$expense->getExpenseItemLocal->gst_no : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$expense->getExpenseItemLocal->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$expense->getExpenseItemLocal->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>   
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$expense->getExpenseItemLocal->remark ? @$expense->getExpenseItemLocal->remark : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                No expense found for this section
                @endif

            </div>--}}

            
            <div class="fill-inr-box fill3">
                <div class="fill-top d-flex justify-content-start align-items-center">
                    <h4><span></span>Miscellaneous</h4>
                </div>

                @if(count(@$expense->getExpenseItemMisce) > 0)
                @foreach(@$expense->getExpenseItemMisce as $misce)
                <div class="row misce_row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="fill-box">
                            <div class="item-box">
                                <p>
                                @if(@$misce->misce_option == 'O')
                                Others
                                @elseif(@$misce->misce_option == 'F')
                                Food
                                @else 
                                -
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Base Fare
                            @if(@$misce->approved_gst_amount > 0 || @$misce->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$misce->approved_gst_amount}}" 
                                data-comment="{{@$misce->comment}}" 
                                data-itemid="{{@$misce->id}}"
                                data-expenseid="{{@$misce->expense_detail_id}}" 
                                data-claimedamt="{{@$misce->gst_amount}}" 
                                data-title="Miscellaneous"
                                data-base_amt="{{@$misce->basefare}}"
                                data-apr_base_amt="{{@$misce->approved_amount - @$misce->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$misce->approved_gst_amount > 0 || @$misce->comment) yellow_box @endif">
                            <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$misce->approved_gst_amount > 0 || @$misce->comment)
                                    <strike>{{@$misce->basefare}}</strike> {{@$misce->approved_amount - @$misce->approved_gst_amount }}
                                    @else
                                    {{@$misce->basefare ? number_format(@$misce->basefare,2) : 0}}
                                    @endif
                                   
                                </p>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Amount 
                                @if(@$misce->approved_gst_amount > 0 || @$misce->comment)
                                <span class="commentClick" 
                                data-apprvedgstamt="{{@$misce->approved_gst_amount}}" 
                                data-comment="{{@$misce->comment}}" 
                                data-itemid="{{@$misce->id}}"
                                data-expenseid="{{@$misce->expense_detail_id}}" 
                                data-claimedamt="{{@$misce->gst_amount}}" 
                                data-title="Miscellaneous"
                                data-base_amt="{{@$misce->basefare}}"
                                data-apr_base_amt="{{@$misce->approved_amount - @$misce->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i>
                                </span>
                                @endif
                            </label>
                            <div class="item-box @if(@$misce->approved_gst_amount > 0 || @$misce->comment) yellow_box @endif">
                                <p>
                                @if(@$misce->approved_gst_amount > 0 || @$misce->comment)
                                 <strike>{{@$misce->gst_amount}}</strike> {{@$misce->approved_gst_amount}}
                                 @else
                                    {{@$misce->gst_amount ? number_format(@$misce->gst_amount,2) : 0}}
                                 @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Total</label>
                            <div class="item-box">
                                <p style="font-size: 14px;line-height: 15px;">
                                    @if(@$misce->approved_gst_amount > 0 || @$misce->comment)
                                    <strike>{{@$misce->total}}</strike> {{@$misce->approved_amount}}
                                    @else
                                    {{@$misce->total ? number_format(@$misce->total,2) : 0}}
                                    @endif
                                   
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">GST Number</label>
                            <div class="item-box">
                                <p>{{@$misce->gst_no ? @$misce->gst_no : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Supporting Document</label>
                            <div class="item-box">
                                <p>{{count(@$misce->getExpenseItemDoc)}} Documents <span onclick="all_doc_show('{{@$misce->id}}')"><img src="{{asset('public/front_assets/images/eye.png')}}" alt=""></span></p>
                            </div>
                        </div>
                    </div>   
                    <div class="col-xl-12">
                        <div class="fill-box mb-30">
                            <label for="">Remark</label>
                            <div class="item-box">
                                <p>{{@$misce->remark ? @$misce->remark : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">

                    </div>
                </div>
                @if(count(@$expense->getExpenseItemRail) > 1)
                <hr>
                @endif
                @endforeach
                @else
                No expense found for this section
                @endif

            </div>

            <div class="fill-inr-box fill-grand">
                <h2>Grand Total </h2>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="empl-box claim_boxxaa grand_total_sec">    
                        <h2> 
                        @if(@$expense->days_approved > 0) 
                            <strike>{{number_format(@$expense->days_total,2)}}</strike> {{number_format(@$expense->days_approved,2)}}                        
                        @else
                            @if(@$expense->is_admin_commented == 'N')
                            {{@$expense->days_total ? number_format(@$expense->days_total,2) : 00}}                      
                            @else 
                           
                            <strike>{{number_format(@$expense->days_total,2)}}</strike> {{number_format(@$expense->days_approved,2)}}                        
                            @endif
                                               
                        @endif
                        </h2>
                            <span>Rupees Only</span>
                        </div>
                        <h4>Attach receipt for each expenditure. Explain details of unusal items.Explain purpose of each
                            trip</h4>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">City</label>
                            <div class="item-box">
                                <p>{{@$expense->day_city_name ? @$expense->day_city_name : '-'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-8 col-sm-6 col-12">
                        <div class="fill-box">
                            <label for="">Purpose</label>
                            <div class="item-box">
                                <p>{{@$expense->day_pupose ? @$expense->day_pupose : '-'}}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- The Modal -->
<div class="modal" id="addCommentModal">
    <div class="modal-dialog popup_for_comment">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Comment (<span id="comment_title" class="comment_text">Hotel Room Rent</span>)</h4>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_comment_info">
                    <form action="javascript:;" method="post" id="comment_form" class="log-r8-frm">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <input type="hidden" class="comment_fields" name="expense_detail_id" id="expense_detail_id" value="">
                                <input type="hidden" class="comment_fields" name="item_id" id="item_id" value="">
                                <input type="hidden" class="comment_fields" name="gst_available" id="gst_available" value="">


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 if_base_amt_show" >
                                    <div class="fill-box">
                                        <label for="" class="base_title">Claimed Base Amount</label>
                                        <div class="claim_boxx claim_01">
                                            <p id="base_amountt" class="comment_text">0</p>
                                            <span>Rupees Only</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 if_base_amt_show">
                                    <div class="fill-box comment_err">
                                        <label for="" class="base_approved_title">Approved Base Amount</label>
                                        <div class="claim_boxx claim_01">
                                            <p id="approved_base_amount" class="comment_text">0</p>
                                            <span>Rupees Only</span>
                                        </div>

                                    </div>
                                </div>



                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="fill-box">
                                        <label for="" class="gst_title">Claimed GST Amount</label>
                                        <div class="claim_boxx claim_01">
                                            <p id="gst_amt" class="comment_text">0</p>
                                            <span>Rupees Only</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="fill-box comment_err">
                                        <label for="" class="approved_title">Approved GST Amount</label>
                                        <div class="claim_boxxaa">
                                            <input type="text" placeholder="Enter here"
                                                name="approved_gst_amount" id="approved_gst_amount" class="comment_fields" readonly>
                                            <span style="top:195px !important">Rupees Only</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="fill-box comment_err">
                                        <label for="">Comment</label>
                                        <textarea placeholder="Enter your comment here" name="comment" id="comment" readonly
                                            class="claim_boxx_mesg comment_fields"></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="float: right;">Close</button>
                                </div>


                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <!-- Modal body end-->

        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal">
    <input type="hidden" id="image_array" />
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header moder_header_new">
                <h4 class="modal-title expense-title">Supporting Documents (<span id="modal_doc_title">Hotel Room Rent</span>)</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                {{--<a class="download-doc downloadAllBtn" href="javascript:;"  data-value="2"><img
                        src="{{asset('public/front_assets/images/arrow-down-circle 1.png')}}" alt=""> Download All
                    Supporting Documents</a>--}}
            </div>

            <!-- Modal body -->
            <div class="modal-body for_pop_sld" id="showing_all_doc">
                <div class="owl-carousel owl-theme popup_images_slider">
                </div>
            </div>
            <!-- Modal body end-->
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.3.0/jszip.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script src="{{asset('public/front_assets/js/zipjs.js')}}" type="text/javascript"></script>   
<script src="{{asset('public/front_assets/js/sweet-alert.js')}}"></script>

<script>
 $(document).ready(function(){ 

    $("#reject_form").validate({
            rules:{
                comment:{
                    required:true,
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

    $("#comment_form").validate({
            rules:{
                approved_gst_amount:{
                    required:true,
                },
                comment:{
                    required:true,
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

    //added comment for an item
    $("body").on('click','.commentClick',function(){
        $('.comment_fields').val('');
        $('.comment_text').text('');

        var apprvedgstamt = $(this).data('apprvedgstamt');
        var comment = $(this).data('comment');
        var expense_id = $(this).data('expenseid');
        var itemid = $(this).data('itemid');
        var gstamt = $(this).data('claimedamt');
        var title = $(this).data('title');
        var isGstAvailable = $(this).data('gstavailable');

        var base_clm_amt=$(this).data('base_amt');
        var base_apr_amt=$(this).data('apr_base_amt');
       
        if(base_clm_amt == '' ){
            base_clm_amt = 0;
        }

        $('#addCommentModal').find('#approved_gst_amount').val(apprvedgstamt);
        $('#addCommentModal').find('#comment').val(comment);
        $('#addCommentModal').find('#expense_detail_id').val(expense_id);
        $('#addCommentModal').find('#item_id').val(itemid);
        $('#addCommentModal').find('#gst_amt').text(gstamt);
        $('#addCommentModal').find('#comment_title').text(title);
        $('#addCommentModal').find('#base_amountt').text(base_clm_amt);
        $('#addCommentModal').find('#approved_base_amount').text(base_apr_amt);

        if(isGstAvailable == 'Yes'){
            $('.approved_title').text('Approved GST Amount');
            $('.gst_title').text('Claimed GST Amount');
            $('#gst_available').val(1);
            $('.if_base_amt_show').show();
        }else{
            $('.approved_title').text('Approved Amount');
            $('.gst_title').text('Claimed Amount');
            $('#gst_available').val(0);
            $('.if_base_amt_show').hide();
        }

        $('#addCommentModal').modal('show');

    });
    
    $('#day_date').datepicker({
        maxDate:0,
        dateFormat:"dd-mm-yy",
    });

    $('#approved_gst_amount').on("input", function(evt) {
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

});

</script>
<script>

                  function all_doc_show(id)
                  {
                
                      if(id == null || id == "")
                      {
                        Swal.fire({
                                    title: "Something is wong in this doc preview!!",
                                    icon: 'error',
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: 'OK',
                                    }).then((result) => {

                                    });
                          false;
                      }
                      $('#showing_all_doc').html("");

                      $.ajax({

                            url: "{{route('show.all.docs')}}",
                            dataType: 'json',
                            data: {id:id},
                           
                            type: 'get',
                           
                            success: function(resp){
                                console.log(resp);

                                if(resp.result.img_status == 'Failed')
                                {
                                    Swal.fire({
                                    title: "No Docs found!!",
                                    icon: 'error',
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: 'OK',
                                    }).then((result) => {

                                    });
                                    false;
                                }
                               
                                if(resp.result.img_status == 'OK')
                                {
                                      
                    
                                    var doc_html='<div class="owl-carousel owl-theme popup_images_slider" >';
                                    var img_folder='';
                                    var modal_title='';
                                    resp.result.img_doc.forEach(function(item){
                                        if(resp.result.item_type == 'R')
                                           {
                                            img_folder=`rail`;
                                            modal_title=`Rail/Air`;
                                           }
                                           if(resp.result.item_type == 'T')
                                           {
                                            img_folder=`taxi`;
                                            modal_title=`Taxi/Bus/Rickshaw`;
                                           }
                                           if(resp.result.item_type == 'H')
                                           {
                                            img_folder=`hotel`;
                                            modal_title=`Hotel Room Rent`;
                                           }
                                           if(resp.result.item_type == 'L')
                                           {
                                            img_folder=`laundry`;
                                            modal_title=`Laundry Charges`;
                                           }
                                           if(resp.result.item_type == 'B')
                                           {
                                            img_folder=`breakfast`;
                                            modal_title=`Breakfast`;
                                           }
                                           if(resp.result.item_type == 'LU')
                                           {
                                            img_folder=`lunch`;
                                            modal_title=`Lunch`;
                                           }
                                           if(resp.result.item_type == 'D')
                                           {
                                            img_folder=`dinner`;
                                            modal_title=`Dinner`;
                                           }
                                           if(resp.result.item_type == 'P')
                                           {
                                            img_folder=`phone`;
                                            modal_title=`Phone`;
                                           }
                                           if(resp.result.item_type == 'LC')
                                           {
                                            img_folder=`local`;
                                            modal_title=`Local Convayence`;
                                           }
                                           if(resp.result.item_type == 'M')
                                           {
                                            img_folder=`misce`;
                                            modal_title=`Miscellaneous`;
                                           } 
                                        if(item.file_type == 'image')
                                        {

                                            
                                            doc_html +=`<div class="item">
                                            <img src="{{ URL::to('storage/app/public/report/${img_folder}/')}}/${item.doc_name}" alt="">
                                            </div>`;
                                        }else{
                                            doc_html +=`<div class="item">
                                            <a href="{{ URL::to('storage/app/public/report/${img_folder}/')}}/${item.doc_name}" target="_blank">
                                            <img src="{{asset('public/front_assets/images/pdf_image.png')}}" alt="">
                                            <label><b>${item.doc_name}</b></label></a>
                                            </div>`;
                                        }


                                        
                                       
                                    })
                                    doc_html+=`</div>`;
                                //    console.log(doc_html);
                                    $('#showing_all_doc').html(doc_html);
                                    $('#modal_doc_title').text(modal_title);
                                    $('#myModal').modal('show');
                                    for_slider(resp.result.doc_count);
                                    console.log("imgs_array ",imgs_array)
                        
                                }

                               
                                
                            },
                            error: function(error){

                                
                            }
                        })
                  }

                //   $('#btn-close').click(function(){
                //         $('#showing_all_doc').html('123');
                //       delete window.for_slider;
                      
                //   })

                  function for_slider(img_count)
                  {
                    $('.popup_images_slider').owlCarousel({
                                        loop:false,
                                        dots:false,
                                        autoplay:false,
                                        center: true,
                                        nav:true,
                                        
                                        stagePadding: 500,
                                        margin:350,
                                        items:3,
                                                
                                        responsive:{

                                            320:{

                                                stagePadding: 100,
                                                margin:150,
                                                items:1,
                                            },
                                            480:{

                                                stagePadding: 100,
                                                margin:150,
                                                items:1,
                                            },
                                            767:{

                                                stagePadding: 100,
                                                margin:150,
                                                items:1,
                                            },
                                            991:{

                                                stagePadding: 0,
                                                margin:250,
                                                items:3,
                                            },
                                            1199:{

                                                stagePadding: 0,
                                                margin:250,
                                                items:3,
                                            },
                                            1399:{

                                                stagePadding: 0,
                                                margin:250,
                                                items:3,
                                                
                                            }
                                        }
                                        })
                  }

                  </script>


@endsection