@extends('layouts.app')
@section('title')
Hetero Health Care - Expence Report Detail
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




<div class="right-page ddlss"> 
        <div class="r8-page-heading"> 
        @include('includes.message') 
        	<a href="{{route('employee.history.report')}}"><img src="{{asset('public/front_assets/images/arrow-left.png')}}" alt=""></a>
            <h2><strong>History </strong>&nbsp  >  &nbsp<strong> Expenses Reports</strong> &nbsp  >  &nbsp <strong>View Report</strong></h2>
            <h4 class="mtr1">NOTE : GST charges are not reimbursed in case of no GST number</h4>
        </div>
        @if(@$expense->getExpenseMaster->status == 'R' || @$expense->getExpenseMaster->status == 'D')
        
              <div class="row" >
                  <div class="col-xl-12">
                      <a href="{{route('employee.edit.report',['id'=>@$expense->id])}}" class="fill-edit" style="float:right" type="text" >Edit</a>
                  </div>
              </div>

              @endif
          @if(@$expense->getExpenseMaster->status == 'R' || @$expense->getExpenseMaster->status == 'H' && @$expense->remark != null)
          <div class="empl sho_only02 noop">
            <div class="fill-inr-box fill2" >
              <h3 style="text-align:center"><u>@if(@$expense->getExpenseMaster->status == 'H') On-Hold @else Rejection @endif  Remark </u></h3><p style="font-size:14px">{{@$expense->remark}}</p>
            </div>  
          </div>
          @endif  


        
        <div class="empl sho_only02 noop">
         
        <div class="fill-inr-box fill2">
          <div style="display: flex;align-content: center;justify-content: space-between;">
            <h3>employee details</h3>
            @if(@$master->status == 'D')
            <h3 style="color:#e5e50e">Draft</h3>
            @elseif(@$master->status == 'S')
            <h3 style="color:blue">Submitted</h3>
            @elseif(@$master->status == 'R')
            <h3 style="color:red">Rejected</h3>
            @elseif(@$master->status == 'H')
            <h3 style="color:#e5e50e">On-Hold</h3>
            @elseif(@$master->status == 'A')
              @if(@$master->getMemo->status == 'I' && @$master->approval_stage == 'ACHY')
              <h3 style="color:green">Transaction Initiated</h3>
              @elseif(@$master->getMemo->status == 'C') 
              <h3 style="color:green">Transaction Completed</h3>
              @else
              <h3 style="color:green">Approved</h3>
              @endif
            @endif
          </div>
           <div class="row orderr">
            <!--<h4 class="fultxt">Order Details</h4>-->
            <div class="col-md-12 mbr2">
            	<p><span class="titel-span">Employee ID </span> <span class="deta-span"><strong>:</strong> {{auth()->user()->empID}}</span> </p>
           		<p><span class="titel-span">Employee Name </span> <span class="deta-span"><strong>:</strong> {{auth()->user()->name}}</span></p>
           		<p><span class="titel-span">Designation </span> <span class="deta-span"><strong>:</strong> {{auth()->user()->designation}}</span></p>
           		<!-- <p><span class="titel-span">Headquaters </span> <span class="deta-span"><strong>:</strong>Hydrabaad</span></p> -->
                <p><span class="titel-span">Division </span> <span class="deta-span"><strong>:</strong> {{auth()->user()->division}}</span></p>
            </div>
          </div>
         </div>  
        </div>
        
        <input type="hidden" id="day_date" value="{{date('d-m-Y',strtotime(@$expense->date))}}">
        <div class="empl sho_only02 noop">
           <div class="fill-inr-box fill2">
           <div style="display: flex;align-content: center;justify-content: space-between;">
           <h3><img src="{{asset('public/front_assets/images/calendar-dark.png')}}" alt=""> Selected Date </h3>
          
              <h3 style="display:none">Selected Date Status : <span id="show_status"> </span></h3>
            </div>
           <div class="row orderr">
            <div class="col-md-12 mbr2">
            	<div class="exp-date ">
              
                    <ul class="d-flex justify-content-start align-items-center" id="day_date_show">
                        <!-- <li><label for="">11-08-2023</label></li>
                        <li><label for="">12-08-2023</label></li>
                        <li><label for="">14-08-2023</label></li> -->
                    </ul>
                </div>
            </div>
          </div>
           </div>
        </div>

        <input type="hidden" name="start_date" id="start_date" >
        <input type="hidden" name="end_date" id="end_date" >
        
        
        <div class="empl sho_only02 noop">
          
          <div class="fill-inr-box fill2">
            <h4><span></span> Heading</h4>
            <div class="orderr">
            <div class="mbr2">
            	<p><span class="titel-span">Date </span> <span class="deta-span"><strong>:</strong> {{@$expense->date}}</span> </p>
           		<p><span class="titel-span">Travelled From </span> <span class="deta-span"><strong>:</strong> {{@$expense->travelling_from}}</span></p>
           		<p><span class="titel-span">Travelled To </span> <span class="deta-span"><strong>:</strong> {{@$expense->travelling_to}}</span></p>
           		<p><span class="titel-span">Overnight at </span> <span class="deta-span"><strong>:</strong> {{@$expense->orvernight_at}}</span></p>
            </div>
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Rail/Air</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemRail->isNotEmpty())
            @foreach(@$expense->getExpenseItemRail as $rail_key=>$rail_list)
                <div class="mbr2">  
                    <p><span class="titel-span">Base Fare 
                    @if(@$rail_list->approved_gst_amount > 0 || @$rail_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$rail_list->approved_gst_amount}}" 
                                data-comment="{{@$rail_list->comment}}" 
                                data-itemid="{{@$rail_list->id}}"
                                data-expenseid="{{@$rail_list->expense_detail_id}}" 
                                data-claimedamt="{{@$rail_list->gst_amount}}" 
                                data-title="Rail/Air"
                                data-base_amt="{{@$rail_list->basefare}}"
                                data-apr_base_amt="{{@$rail_list->approved_amount -@$rail_list->approved_gst_amount}}" 
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif
                    </span> <span class="deta-span"><strong>:</strong>
                      @if(@$rail_list->approved_gst_amount > 0 || @$rail_list->comment)
                    <del>{{number_format(@$rail_list->basefare,2)}} </del> {{@$rail_list->approved_amount - @$rail_list->approved_gst_amount}}
                    @else
                    {{number_format(@$rail_list->basefare,2)}}
                    @endif
                    
                  </span> </p>
                    <p> 
                      
                  <span class="titel-span">GST Amount
                @if(@$rail_list->approved_gst_amount > 0 || @$rail_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$rail_list->approved_gst_amount}}" 
                                data-comment="{{@$rail_list->comment}}" 
                                data-itemid="{{@$rail_list->id}}"
                                data-expenseid="{{@$rail_list->expense_detail_id}}" 
                                data-claimedamt="{{@$rail_list->gst_amount}}" 
                                data-title="Rail/Air"
                                data-base_amt="{{@$rail_list->basefare}}"
                                data-apr_base_amt="{{@$rail_list->approved_amount -@$rail_list->approved_gst_amount}}" 
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span>

                   <span class="deta-span"><strong>:</strong>
                  @if(@$rail_list->approved_gst_amount > 0 || @$rail_list->comment)
                  <del>{{number_format(@$rail_list->gst_amount,2)}} </del> {{@$rail_list->approved_gst_amount}}
                  @else
                  {{number_format(@$rail_list->gst_amount,2)}}
                  @endif
                
                  </span>
                
                  </p>
                    <p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
                    @if(@$rail_list->approved_gst_amount > 0 || @$rail_list->comment)
                    <del>{{number_format(@$rail_list->total,2)}}</del> {{@$rail_list->approved_amount}}
                    @else
                    {{number_format(@$rail_list->total,2)}}
                    @endif
                  </span></p>
                    <p><span class="titel-span">GST Number</span> <span class="deta-span"><strong>:</strong>{{@$rail_list->gst_no ? @$rail_list->gst_no : '-'}}</span></p>
                    <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$rail_list->remark}}</span></p>
                    
                    <p class="full_infoo_h">
                        <span class="titel-span">Supporting Document </span>  
                        @if($rail_list->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$rail_list->id}}')"> {{count(@$rail_list->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
                    </p>

                </div>
                @if(count(@$expense->getExpenseItemRail) > 1)
                <hr>
                @endif
                @endforeach
                @else 
                No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2">
            <h4><span></span>  Taxi/Bus/Rickshaw </h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemTaxi->isNotEmpty())
            @foreach(@$expense->getExpenseItemTaxi as $taxi_key=>$taxi_list) 
            <div class="mbr2">             
            	<p><span class="titel-span">Type</span> <span class="deta-span"><strong>:</strong>
                {{-- @if(@$taxi->taxi_option == 'O')
                                    Organization
                                @elseif(@$taxi->taxi_option == 'I')
                                Individual --}}
                                @if(@$taxi_list->taxi_option == '1')
                                Taxi
                                @elseif(@$taxi_list->taxi_option == '2')
                                Bus
                                @elseif(@$taxi_list->taxi_option == '3')
                                Rickshaw
                @else ---  
                @endif</span> </p>
            	<p><span class="titel-span">Base Fare 
              @if(@$taxi_list->approved_gst_amount > 0 || @$taxi_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$taxi_list->approved_gst_amount}}" 
                                data-comment="{{@$taxi_list->comment}}" 
                                data-itemid="{{@$taxi_list->id}}"
                                data-expenseid="{{@$taxi_list->expense_detail_id}}" 
                                data-claimedamt="{{@$taxi_list->gst_amount}}" 
                                data-title="Taxi/Bus/Rickshaw"
                                data-base_amt="{{@$taxi_list->basefare}}"
                                data-apr_base_amt="{{@$taxi_list->approved_amount -@$taxi_list->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif
              </span> <span class="deta-span"><strong>:</strong>
              @if(@$taxi_list->approved_gst_amount > 0 || @$taxi_list->comment)
                    <del>{{number_format(@$taxi_list->basefare,2)}} </del> {{@$taxi_list->approved_amount - @$taxi_list->approved_gst_amount}}
                    @else
                    {{number_format(@$taxi_list->basefare,2)}}
                    @endif
              
              </span> </p>
           		<p><span class="titel-span">GST Amount
              @if(@$taxi_list->approved_gst_amount > 0 || @$taxi_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$taxi_list->approved_gst_amount}}" 
                                data-comment="{{@$taxi_list->comment}}" 
                                data-itemid="{{@$taxi_list->id}}"
                                data-expenseid="{{@$taxi_list->expense_detail_id}}" 
                                data-claimedamt="{{@$taxi_list->gst_amount}}" 
                                data-title="Taxi/Bus/Rickshaw"
                                data-base_amt="{{@$taxi_list->basefare}}"
                                data-apr_base_amt="{{@$taxi_list->approved_amount -@$taxi_list->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
              @if(@$taxi_list->approved_gst_amount > 0 || @$taxi_list->comment)
                  <del>{{number_format(@$taxi_list->gst_amount,2)}} </del> {{@$taxi_list->approved_gst_amount}}
                  @else
                  {{number_format(@$taxi_list->gst_amount,2)}}
                  @endif</span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$taxi_list->approved_gst_amount > 0 || @$taxi_list->comment)
                  <del>{{number_format(@$taxi_list->total,2)}} </del> {{@$taxi_list->approved_amount}}
                  @else
                  {{number_format(@$taxi_list->total,2)}}
                  @endif
               
              </span></p>
           		<p><span class="titel-span">GST Number</span> <span class="deta-span"><strong>:</strong>{{@$taxi_list->gst_no ? @$taxi_list->gst_no : '-'}}</span></p>
           		<p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$taxi_list->remark}}</span></p>
                
                <p class="full_infoo_h">
                	<span class="titel-span">Supporting Document </span> 
                    @if($taxi_list->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$taxi_list->id}}')"> {{count(@$taxi_list->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
                </p>

            </div>
            @if(count(@$expense->getExpenseItemTaxi) > 1)
                <hr>
                @endif
                @endforeach
                @else 
                No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Hotel</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemHotel->isNotEmpty())
            @foreach(@$expense->getExpenseItemHotel as $hotel_key=>$hotel_list)          
            <div class="mbr2">
            	<p><span class="titel-span">Hotel Name </span> <span class="deta-span"><strong>:</strong>{{@$hotel_list->hotel_name}}</span> </p>
           		<p><span class="titel-span">City </span> <span class="deta-span"><strong>:</strong>{{@$hotel_list->hotel_city}}</span></p>
           		<p><span class="titel-span">Fare (Exclude GST) 
               @if(@$hotel_list->approved_gst_amount > 0 || @$hotel_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                    data-apprvedgstamt="{{@$hotel_list->approved_gst_amount}}" 
                    data-comment="{{@$hotel_list->comment}}" 
                    data-itemid="{{@$hotel_list->id}}"
                    data-expenseid="{{@$hotel_list->expense_detail_id}}" 
                    data-claimedamt="{{@$hotel_list->gst_amount}}" 
                    data-title="Hotel"
                    data-base_amt="{{@$hotel_list->basefare}}"
                    data-apr_base_amt="{{@$hotel_list->approved_amount -@$hotel_list->approved_gst_amount}}"
                    data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif
               </span> <span class="deta-span"><strong>:</strong>
               @if(@$hotel_list->approved_gst_amount > 0 || @$hotel_list->comment)
                    <del>{{number_format(@$hotel_list->basefare,2)}} </del> {{@$hotel_list->approved_amount - @$hotel_list->approved_gst_amount}}
                    @else
                    {{number_format(@$hotel_list->basefare,2)}}
                    @endif
               
              </span></p>
           		<p><span class="titel-span">GST Amount
              @if(@$hotel_list->approved_gst_amount > 0 || @$hotel_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                    data-apprvedgstamt="{{@$hotel_list->approved_gst_amount}}" 
                    data-comment="{{@$hotel_list->comment}}" 
                    data-itemid="{{@$hotel_list->id}}"
                    data-expenseid="{{@$hotel_list->expense_detail_id}}" 
                    data-claimedamt="{{@$hotel_list->gst_amount}}" 
                    data-title="Hotel"
                    data-base_amt="{{@$hotel_list->basefare}}"
                    data-apr_base_amt="{{@$hotel_list->approved_amount -@$hotel_list->approved_gst_amount}}"
                    data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
               @if(@$hotel_list->approved_gst_amount > 0 || @$hotel_list->comment)
                  <del>{{number_format(@$hotel_list->gst_amount,2)}} </del> {{@$hotel_list->approved_gst_amount}}
                  @else
                  {{number_format(@$hotel_list->gst_amount,2)}}
                  @endif
                </span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$hotel_list->approved_gst_amount > 0 || @$hotel_list->comment)
                  <del>{{number_format(@$hotel_list->total,2)}} </del> {{@$hotel_list->approved_amount}}
                  @else
                  {{number_format(@$hotel_list->total,2)}}
                  @endif
               
              </span></p>
                <p><span class="titel-span">GST Number </span> <span class="deta-span"><strong>:</strong>{{@$hotel_list->gst_no ? @$hotel_list->gst_no : '-'}}</span></p>
                
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$hotel_list->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if($hotel_list->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$hotel_list->id}}')"> {{count(@$hotel_list->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div>
            @if(count(@$expense->getExpenseItemTaxi) > 1)
                <hr>
                @endif
                @endforeach
                @else 
                No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2">
            <h4><span></span>  Landry Charges</h4>
            <div class="orderr">
                @if(@$expense->getExpenseItemLaundry)
            <div class="mbr2">
                
            	<p><span class="titel-span">Laundry Name </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLaundry->hotel_name}}</span> </p>
                <p><span class="titel-span">Laundry City </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLaundry->hotel_city}}</span> </p>
            	<p><span class="titel-span">Base Fare 
              @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLaundry->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLaundry->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLaundry->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLaundry->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLaundry->gst_amount}}" 
                                data-title="Laundry Charges"
                                data-base_amt="{{@$expense->getExpenseItemLaundry->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemLaundry->approved_amount -@$expense->getExpenseItemLaundry->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif 
              </span> <span class="deta-span"><strong>:</strong>
              @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                    <del>{{number_format(@$expense->getExpenseItemLaundry->basefare,2)}} </del> {{@$expense->getExpenseItemLaundry->approved_amount - @$expense->getExpenseItemLaundry->approved_gst_amount}}
                    @else
                    {{number_format(@$expense->getExpenseItemLaundry->basefare,2)}}
                    @endif
              
             
              </span> </p>
           		<p><span class="titel-span">GST Amount
              @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLaundry->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLaundry->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLaundry->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLaundry->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLaundry->gst_amount}}" 
                                data-title="Laundry Charges"
                                data-base_amt="{{@$expense->getExpenseItemLaundry->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemLaundry->approved_amount -@$expense->getExpenseItemLaundry->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                  <del>{{number_format(@$expense->getExpenseItemLaundry->gst_amount,2)}} </del> {{@$expense->getExpenseItemLaundry->approved_gst_amount}}
                  @else
                  {{number_format(@$expense->getExpenseItemLaundry->gst_amount,2)}}
                  @endif
            </span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemLaundry->approved_gst_amount > 0 || @$expense->getExpenseItemLaundry->comment)
                  <del>{{number_format(@$expense->getExpenseItemLaundry->total,2)}} </del> {{@$expense->getExpenseItemLaundry->approved_amount}}
                  @else
                  {{number_format(@$expense->getExpenseItemLaundry->total,2)}}
                  @endif
              
              </span></p>
           		<p><span class="titel-span">GST Number</span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLaundry->gst_no ? @$expense->getExpenseItemLaundry->gst_no : '-'}}</span></p>
           		<p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLaundry->remark}}</span></p>
                
                <p class="full_infoo_h">
                	<span class="titel-span">Supporting Document </span> 
                    @if(@$expense->getExpenseItemLaundry->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemLaundry->id}}')"> {{count(@$expense->getExpenseItemLaundry->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
                </p>

            </div>
            @else
            No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Breakfast</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemBreakfast)
            <div class="mbr2">
               
              <p><span class="titel-span">Amount
              @if(@$expense->getExpenseItemBreakfast->approved_amount > 0 || @$expense->getExpenseItemBreakfast->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemBreakfast->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemBreakfast->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemBreakfast->id}}"
                                data-expenseid="{{@$expense->getExpenseItemBreakfast->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemBreakfast->basefare}}" 
                                data-title="Breakfast"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
              @if(@$expense->getExpenseItemBreakfast->approved_amount > 0 || @$expense->getExpenseItemBreakfast->comment)
                  <del>{{number_format(@$expense->getExpenseItemBreakfast->basefare,2)}} </del> {{@$expense->getExpenseItemBreakfast->approved_amount}}
                  @else
                  {{number_format(@$expense->getExpenseItemBreakfast->basefare,2)}}
                  @endif
              </span> </p>
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemBreakfast->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if(@$expense->getExpenseItemBreakfast->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemBreakfast->id}}')"> {{count(@$expense->getExpenseItemBreakfast->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div>
            @else
            No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2">
            <h4><span></span> Lunch</h4>
            <div class="orderr">
                @if(@$expense->getExpenseItemLunch)
            <div class="mbr2">
                
              <p><span class="titel-span">Amount
              @if(@$expense->getExpenseItemLunch->approved_amount > 0 || @$expense->getExpenseItemLunch->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLunch->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLunch->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLunch->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLunch->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLunch->basefare}}" 
                                data-title="Lunch"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
              @if(@$expense->getExpenseItemLunch->approved_amount > 0 || @$expense->getExpenseItemLunch->comment)
                  <del>{{number_format(@$expense->getExpenseItemLunch->basefare,2)}} </del> {{@$expense->getExpenseItemLunch->approved_amount}}
                  @else
                  {{number_format(@$expense->getExpenseItemLunch->basefare,2)}}
                  @endif
              </span> </p>
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLunch->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if(@$expense->getExpenseItemLunch->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemLunch->id}}')"> {{count(@$expense->getExpenseItemLunch->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div>
            @else
            No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Dinner</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemDinner)
            <div class="mbr2">
                
              <p><span class="titel-span">Amount
              @if(@$expense->getExpenseItemDinner->approved_amount > 0 || @$expense->getExpenseItemDinner->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemDinner->approved_amount}}" 
                                data-comment="{{@$expense->getExpenseItemDinner->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemDinner->id}}"
                                data-expenseid="{{@$expense->getExpenseItemDinner->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemDinner->basefare}}" 
                                data-title="Dinner"
                                data-gstavailable="No"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
              @if(@$expense->getExpenseItemDinner->approved_amount > 0 || @$expense->getExpenseItemDinner->comment)
                  <del>{{number_format(@$expense->getExpenseItemDinner->basefare,2)}} </del> {{@$expense->getExpenseItemDinner->approved_amount}}
                  @else
                  {{number_format(@$expense->getExpenseItemDinner->basefare,2)}}
                  @endif</span> </p>
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemDinner->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if(@$expense->getExpenseItemDinner->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemDinner->id}}')"> {{count(@$expense->getExpenseItemDinner->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div> 
            @else
            No expense found for this section
            @endif
          </div>
          </div>
          
          
          <div class="fill-inr-box fill2">
            <h4><span></span> Phone</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemPhone)
            <div class="mbr2">
             
           		<p><span class="titel-span">Fare (Exclude GST) 
               @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemPhone->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemPhone->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemPhone->id}}"
                                data-expenseid="{{@$expense->getExpenseItemPhone->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemPhone->gst_amount}}" 
                                data-title="Phone"
                                data-base_amt="{{@$expense->getExpenseItemPhone->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemPhone->approved_amount -@$expense->getExpenseItemPhone->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif
               </span> <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                    <del>{{number_format(@$expense->getExpenseItemPhone->basefare,2)}} </del> {{@$expense->getExpenseItemPhone->approved_amount - @$expense->getExpenseItemPhone->approved_gst_amount}}
                    @else
                    {{number_format(@$expense->getExpenseItemPhone->basefare,2)}}
                    @endif
              
              </span></p>
           		<p><span class="titel-span">GST Amount
              @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemPhone->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemPhone->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemPhone->id}}"
                                data-expenseid="{{@$expense->getExpenseItemPhone->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemPhone->gst_amount}}" 
                                data-title="Phone"
                                data-base_amt="{{@$expense->getExpenseItemPhone->basefare}}"
                                data-apr_base_amt="{{@$expense->getExpenseItemPhone->approved_amount -@$expense->getExpenseItemPhone->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                                 <strike>{{@$expense->getExpenseItemPhone->gst_amount}}</strike> {{@$expense->getExpenseItemPhone->approved_gst_amount}}
                                 @else
                                    {{@$expense->getExpenseItemPhone->gst_amount ? number_format(@$expense->getExpenseItemPhone->gst_amount,2) : 0}}
                                 @endif
              </span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemPhone->approved_gst_amount > 0 || @$expense->getExpenseItemPhone->comment)
                <strike>{{@$expense->getExpenseItemPhone->total}}</strike> {{@$expense->getExpenseItemPhone->approved_amount}}
                @else
                  {{@$expense->getExpenseItemPhone->total ? number_format(@$expense->getExpenseItemPhone->total,2) : 0}}
                @endif
             
              </span></p>
                <p><span class="titel-span">GST Number </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemPhone->gst_no ? @$expense->getExpenseItemPhone->gst_no : '-'}}</span></p>
                
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemPhone->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if(@$expense->getExpenseItemPhone->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemPhone->id}}')"> {{count(@$expense->getExpenseItemPhone->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div>
            @else
            No expense found for this section
            @endif
          </div>
          </div>
          
          
          {{--<div class="fill-inr-box fill2 fill-grey">
            <h4><span></span> Local Convayence</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemLocal)
            <div class="mbr2">
                
            	<p><span class="titel-span">Hotel Name </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLocal->hotel_name}}</span> </p>
           		<p><span class="titel-span">City </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLocal->hotel_city}}</span></p>
           		<p><span class="titel-span">Fare (Exclude GST) </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLocal->basefare}}</span></p>
           		<p><span class="titel-span">GST Amount
              @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$expense->getExpenseItemLocal->approved_gst_amount}}" 
                                data-comment="{{@$expense->getExpenseItemLocal->comment}}" 
                                data-itemid="{{@$expense->getExpenseItemLocal->id}}"
                                data-expenseid="{{@$expense->getExpenseItemLocal->expense_detail_id}}" 
                                data-claimedamt="{{@$expense->getExpenseItemLocal->gst_amount}}" 
                                data-title="Local Convayence"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment)
                                 <strike>{{@$expense->getExpenseItemLocal->gst_amount}}</strike> {{@$expense->getExpenseItemLocal->approved_gst_amount}}
                                 @else
                                    {{@$expense->getExpenseItemLocal->gst_amount ? number_format(@$expense->getExpenseItemLocal->gst_amount,2) : 0}}
                                 @endif
              </span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$expense->getExpenseItemLocal->approved_gst_amount > 0 || @$expense->getExpenseItemLocal->comment)
                <strike>{{@$expense->getExpenseItemLocal->total}}</strike> {{@$expense->getExpenseItemLocal->approved_amount}}
                @else
                  {{@$expense->getExpenseItemLocal->total ? number_format(@$expense->getExpenseItemLocal->total,2) : 0}}
                @endif
              
              </span></p>
                <p><span class="titel-span">GST Number </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLocal->gst_no ? @$expense->getExpenseItemLocal->gst_no : '-'}}</span></p>
                
              <p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseItemLocal->remark}}</span></p>
              <p class="full_infoo_h">
                   <span class="titel-span">Supporting Document </span> 
                   @if(@$expense->getExpenseItemLocal->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$expense->getExpenseItemLocal->id}}')"> {{count(@$expense->getExpenseItemLocal->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
              </p>

            </div>
            @else
            No expense found for this section
            @endif
          </div>
          </div>--}}
          
          
          <div class="fill-inr-box fill2">
            <h4><span></span>Miscellaneous</h4>
            <div class="orderr">
            @if(@$expense->getExpenseItemMisce->isNotEmpty())
            @foreach(@$expense->getExpenseItemMisce as $misce_key=>$misce_list)          
            <div class="mbr2">
            <p><span class="titel-span">Type </span> <span class="deta-span"><strong>:</strong>@if(@$misce_list->misce_option == 'O') Others @else Food @endif</span> </p>
            	<p><span class="titel-span">Base Fare 
              <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$misce_list->approved_gst_amount}}" 
                                data-comment="{{@$misce_list->comment}}" 
                                data-itemid="{{@$misce_list->id}}"
                                data-expenseid="{{@$misce_list->expense_detail_id}}" 
                                data-claimedamt="{{@$misce_list->gst_amount}}" 
                                data-title="Miscellaneous"
                                data-base_amt="{{@$misce_list->basefare}}"
                                data-apr_base_amt="{{@$misce_list->approved_amount -@$misce_list->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
              </span>
              
               <span class="deta-span"><strong>:</strong>
              
              @if(@$misce_list->approved_gst_amount > 0 || @$misce_list->comment)
                    <del>{{number_format(@$misce_list->basefare,2)}} </del> {{@$misce_list->approved_amount - @$misce_list->approved_gst_amount}}
                    @else
                    {{number_format(@$misce_list->basefare,2)}}
                    @endif
              
            </span> </p>
           		<p><span class="titel-span">GST Amount
              @if(@$misce_list->approved_gst_amount > 0 || @$misce_list->comment)
                <span class="commentClick hand_cursor info_icon_desi" 
                                data-apprvedgstamt="{{@$misce_list->approved_gst_amount}}" 
                                data-comment="{{@$misce_list->comment}}" 
                                data-itemid="{{@$misce_list->id}}"
                                data-expenseid="{{@$misce_list->expense_detail_id}}" 
                                data-claimedamt="{{@$misce_list->gst_amount}}" 
                                data-title="Miscellaneous"
                                data-base_amt="{{@$misce_list->basefare}}"
                                data-apr_base_amt="{{@$misce_list->approved_amount -@$misce_list->approved_gst_amount}}"
                                data-gstavailable="Yes"><i class="fa fa-info info_icon"></i></span>
                @endif </span> 
              <span class="deta-span"><strong>:</strong>
               @if(@$misce_list->approved_gst_amount > 0 || @$misce_list->comment)
                                 <strike>{{@$misce_list->gst_amount ? @$misce_list->gst_amount : 0}}</strike> {{@$misce_list->approved_gst_amount}}
                                 @else
                                    {{@$misce_list->gst_amount ? number_format(@$misce_list->gst_amount,2) : 0}}
                                 @endif
              </span></p>
           		<p><span class="titel-span">Total </span> <span class="deta-span"><strong>:</strong>
               @if(@$misce_list->approved_gst_amount > 0 || @$misce_list->comment)
                    <strike>{{@$misce_list->gst_amount ? @$misce_list->total : 0}}</strike> {{@$misce_list->approved_amount}}
                    @else
                      {{@$misce_list->total ? number_format(@$misce_list->total,2) : 0}}
                    @endif

              </span></p>
           		<p><span class="titel-span">GST Number</span> <span class="deta-span"><strong>:</strong>{{@$misce_list->gst_no ? @$misce_list->gst_no : '-'}}</span></p>
           		<p class="remark_full res_full"><span class="titel-span">Remark </span> <span class="deta-span"><strong>:</strong>{{@$misce_list->remark}}</span></p>
                
                <p class="full_infoo_h">
                	<span class="titel-span">Supporting Document </span> 
                    @if(@$misce_list->getExpenseItemDoc->isNotEmpty())
                        <span class="deta-span hand_cursor" style="color:blue" onclick="all_doc_show('{{@$misce_list->id}}')"> {{count(@$misce_list->getExpenseItemDoc)}} Files Uploaded Preview</span>
                        @endif
                </p>

            </div>
            @if(count(@$expense->getExpenseItemMisce) > 1)
                <hr>
                @endif
            @endforeach
            @else
            No expense found for this section
            @endif
          </div>
          </div>
           
        </div>
        
        
        
        
        
        <div class="empl sho_only02 noop">
        <div class="fill-inr-box fill2">
           <h3>Grand Total : @if(@$expense->days_approved > 0) 
             <del>{{@$expense->days_total}} </del> {{@$expense->days_approved}} 
             @else
                    @if(@$expense->is_admin_commented == 'N')
                    {{@$expense->days_total}}                      
                            @else 
                            <del>{{@$expense->days_total}} </del> {{@$expense->days_approved}} 
                            @endif 
              
             @endif
            </h3>
           
           <div class="orderr">
            <h4 class="fultxt mbra2">Attach receipt for each expenditure. Explain details of unusual items.Explain purpose of each trip</h4>
            <div class="col-md-12 mbr2">
            	<p><span class="titel-span">City </span> <span class="deta-span"><strong>:</strong>{{@$expense->day_city_name}}</span> </p>
           		<p><span class="titel-span">Purpose </span> <span class="deta-span"><strong>:</strong>{{@$expense->day_pupose}}</span></p>
            </div>
            @if($expense->getExpenseMaster->type == 'Leave' || $expense->getExpenseMaster->type == 'Holiday')
            <div class="col-md-12 mbr2">
           		<p><span class="titel-span">Reason of No Expense </span> <span class="deta-span"><strong>:</strong>{{@$expense->getExpenseMaster->type}}</span></p>
            </div>
            @endif
          </div>

          
          <form action="{{route('employee.week.report.submit')}}" method="post" id="submit_master_form">
            @csrf
            <input type="hidden" name="expense_master_id" value="{{@$expense->expense_master_id}}">

          </form>
        
          @if(@$expense->getExpenseMaster->status == 'R' || @$expense->getExpenseMaster->status == 'D' )
          @if(@$expense->getExpenseMaster->is_editable == 'Y')
            <div class="fill-inr-box fill-grand">
              <div class="row">
                  <div class="col-xl-12">
                  <button class="fill-submit" style="width: 35% !important;" type="text" id="submit_form">Submit Weekly Report</button>
                  </div>
              </div>
            </div>
            @endif
            @endif
        </div>   
        </div>


       
        
        
    </div>
</section>


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
       <div class="owl-carousel owl-theme popup_images_slider" >      
            <!-- <div class="item">
                <img src="{{asset('public/front_assets/images/log-lft-img.png')}}" alt="">
            </div>
            
            <div class="item">
                 <img src="{{asset('public/front_assets/images/favicon.png')}}" alt="">
            </div>
            
            <div class="item">
                 <img src="{{asset('public/front_assets/images/hd-r8-img.png')}}" alt="">
            </div> -->

          
                        
		</div>
      </div>
   	 <!-- Modal body end-->
     
    </div>
  </div>
</div> 


<!-- ///for showing comment -->
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
                                        <div class="claim_boxx claim_01">
                                            <p id="approved_gst_amount" class="comment_text">0</p>
                                            <span>Rupees Only</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="fill-box comment_err">
                                        <label for="">Comment</label>
                                        <p class="modal_commt" id="comment">abcdgh dhsd sadohsad adhncvasdnv asdovihsd </p>
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

<!-- ////for testing popup -->
<!-- The Modal -->
<div class="modal" id="test_pop_up">
    <div class="modal-dialog popup_for_comment week_succ_moda_dailog">
        <div class="modal-content week_sucess_sbm">

           
            <div class="modal-body">

                <div class="popup_for_comment_info week_succ_modal">
                    <img src="{{asset('public/front_assets/images/verified_report.png')}}" alt="pop_up">
                   <h1>Submission Successfull</h1>
                   <p><a href="{{route('employee.history.report.detail',['id'=>@$expense->id])}}">Click here </a>to track your application status using reference id <a href="javascript:;">{{@$expense->getExpenseMaster->expense_unique_code}}</a></p>
                   
                            <button href="javascript:;" class="fill-edit modal_clo"  type="text" >Close</button>
                       
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

<script>

$(document).ready(function(){  
  
  
  @if(session()->get('success') == "Weekly expense report is successfully submitted for approval")
 
    $('#test_pop_up').show();
  @endif
  $('.modal_clo').click(function(){
    $('#test_pop_up').hide();
  })
  

    //added comment for an item
    $("body").on('click','.commentClick',function(){
        $('.comment_fields').val('');
        $('.comment_text').text('');

        var apprvedgstamt = $(this).data('apprvedgstamt');
        var comment = $(this).data('comment');
        var gstamt = $(this).data('claimedamt');
        var base_clm_amt=$(this).data('base_amt');
        var base_apr_amt=$(this).data('apr_base_amt');
       
        if(base_clm_amt == '' ){
            base_clm_amt = 0;
        }

        if(gstamt == ''){
            gstamt = 0;
        }
        var title = $(this).data('title');
        var isGstAvailable = $(this).data('gstavailable');

        $('#addCommentModal').find('#approved_gst_amount').text(apprvedgstamt);
        $('#addCommentModal').find('#comment').text(comment);
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

$('#submit_form').click(function(){
  var start_date=$('#start_date').val();
    var end_date=$('#end_date').val();
  // if(confirm('Do you want to submit the expense report for approval for '+start_date+' to '+end_date+' ? Once send for approval you can not make any changes for this week. ?') == true)
  // {
  // $('#submit_master_form').submit();
  // }else{
  //     false;
  // }
  swal({
        text: 'Do you want to submit the expense report for approval for '+start_date+' to '+end_date+' ? Once send for approval you can not make any changes for this week.',
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

      

        var day_date=$('#day_date').val();
    // alert(day_date);
    $.ajax({
            url: "{{route('get.week.date')}}",
            dataType: 'json',
            data: {day_date:day_date, type:'view'},
            type: 'get',
            // cache: false,
            // processData: false,
            // contentType: false,
            success: function(resp){
                console.log(resp.day1);
                var date_html ='';
                if(resp.day1 != null){
                   
                   date_html =`<li class="hand_cursor" ><label for="" id="day1_show" onclick="change_day_date('${resp.day1}')" `;
                    if(resp.day1 == resp.selected_date)
                        {
                            date_html+=`class="active"`;
                        }

                      if(resp.is_day1 == 'yes')
                      {
                          date_html+=`style="background-color:#fdff908c"`;
                      }
                    date_html+= `>${resp.day1}</label></li>`;
                }
                if(resp.day2 != null){
                   
                date_html+=`<li class="hand_cursor"><label for="" id="day2_show" onclick="change_day_date('${resp.day2}')"`;
                if(resp.day2 == resp.selected_date)
                {
                    date_html+=`class="active"`;
                }
                if(resp.is_day2 == 'yes')
                      {
                          date_html+=`style="background-color:#fdff908c"`;
                      }
                date_html+= `>${resp.day2}</label></li>`;
                }
                if(resp.day3 != null){
                   
                    date_html+=`<li class="hand_cursor"><label for="" id="day3_show" onclick="change_day_date('${resp.day3}')"`;
                    if(resp.day3 == resp.selected_date)
                        {
                            date_html+=`class="active"`;
                        }  
                    if(resp.is_day3 == 'yes')
                      {
                          date_html+=`style="background-color:#fdff908c"`;
                      }          
                    date_html+= `>${resp.day3}</label></li>`;
                }
                if(resp.day4 != null){
                date_html+=`<li class="hand_cursor"><label for="" id="day4_show" onclick="change_day_date('${resp.day4}')"`;
                if(resp.day4 == resp.selected_date)
                {
                    date_html+=`class="active"`;
                } 
                if(resp.is_day4 == 'yes')
                {
                    date_html+=`style="background-color:#fdff908c"`;
                }                
                date_html+=`>${resp.day4}</label></li>`;
                }
                if(resp.day5 != null){

                date_html+=`<li><label for="" id="day5_show" onclick="change_day_date('${resp.day5}')"`;
                if(resp.day5 == resp.selected_date)
                {
                    date_html+=`class="active"`;
                } 
                if(resp.is_day5 == 'yes')
                {
                    date_html+=`style="background-color:#fdff908c"`;
                }
                date_html+=`>${resp.day5}</label></li>`;

                }
                if(resp.day6 != null){
                date_html+=`<li><label for="" id="day6_show" onclick="change_day_date('${resp.day6}')"`;
                if(resp.day6 == resp.selected_date)
                {
                    date_html+=`class="active"`;
                }
                if(resp.is_day6 == 'yes')
                {
                    date_html+=`style="background-color:#fdff908c"`;
                }
                date_html+=`>${resp.day6}</label></li>`;
                }
                if(resp.day7 != null){
                date_html+=`<li><label for="" id="day7_show" onclick="change_day_date('${resp.day7}')"`;
                if(resp.day7 == resp.selected_date)
                {
                    date_html+=`class="active"`;
                }
                if(resp.is_day7 == 'yes')
                {
                    date_html+=`style="background-color:#fdff908c"`;
                }
                date_html+=`>${resp.day7}</label></li>`;
                }
                $('#day_date_show').html(date_html);

                $('#start_date').val(resp.start_week_date);
                $('#end_date').val(resp.end_week_date);
               
                if(resp.expense_detail.status == 'D')
                {
                  $('#show_status').css('color','#e5e50e');
                  $('#show_status').html('Draft');
                }
                if(resp.expense_detail.status == 'R')
                {
                  $('#show_status').css('color','red');
                  $('#show_status').html('Rejected');
                }
                if(resp.expense_detail.status == 'S')
                {
                  $('#show_status').css('color','blue');
                  $('#show_status').html('Submitted');
                }
                if(resp.expense_detail.status == 'A')
                {
                  $('#show_status').css('color','green');
                  $('#show_status').html('Accepted');
                }
               

                // if(resp.day_error == 'inserted') 
                // {
                //     alert('You have already inserted to in this date,Please try to edit it');
                //     var re_url="{{route('employee.edit.report',['id'=>'pass_id'])}}";
                //     re_url=re_url.replace('pass_id',resp.expense_detail_id);
                //     window.location.assign(re_url);
                // }
                
            },
            error: function(error){

                
            }
            })

           
      });


      function change_day_date(date)
        {
            // alert(date);
            var re_url="{{route('employee.day.date.change.view',['date'=>'pass_date'])}}";
            re_url=re_url.replace('pass_date',date);
            window.location.assign(re_url);
        }
</script>



<script>
                  function all_doc_show(id)
                  {
                      if(id == null || id == "")
                      {
                        swal({
                            text: 'Something is wrong in this doc preview',
                            icon: 'error',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonText: 'OK',
                            dangerMode: true,
                            background: '#28a745',
                            });
                          //alert('Something is wong in this doc preview');
                          false;
                      }
                        //   alert(id);

                      $.ajax({

                            url: "{{route('show.all.docs')}}",
                            dataType: 'json',
                            data: {id:id},
                           
                            type: 'get',
                           
                            success: function(resp){
                                console.log(resp);

                                if(resp.result.img_status == 'Failed')
                                {
                                  swal({
                                  text: 'No Docs found!!',
                                  icon: 'error',
                                  showCancelButton: true,
                                  showConfirmButton: false,
                                  cancelButtonText: 'OK',
                                  dangerMode: true,
                                  background: '#28a745',
                                  });
                                    //alert('No Docs found!!');
                                    false;
                                }
                               
                                if(resp.result.img_status == 'OK')
                                {
                                      
                    
                                    var doc_html='<div class="owl-carousel owl-theme popup_images_slider" >';
                                    var img_folder='';
                                    resp.result.img_doc.forEach(function(item){
                                        if(resp.result.item_type == 'R')
                                           {
                                            img_folder=`rail`;
                                           }
                                           if(resp.result.item_type == 'T')
                                           {
                                            img_folder=`taxi`;
                                           }
                                           if(resp.result.item_type == 'H')
                                           {
                                            img_folder=`hotel`;
                                           }
                                           if(resp.result.item_type == 'L')
                                           {
                                            img_folder=`laundry`;
                                           }
                                           if(resp.result.item_type == 'B')
                                           {
                                            img_folder=`breakfast`;
                                           }
                                           if(resp.result.item_type == 'LU')
                                           {
                                            img_folder=`lunch`;
                                           }
                                           if(resp.result.item_type == 'D')
                                           {
                                            img_folder=`dinner`;
                                           }
                                           if(resp.result.item_type == 'P')
                                           {
                                            img_folder=`phone`;
                                           }
                                           if(resp.result.item_type == 'LC')
                                           {
                                            img_folder=`local`;
                                           }
                                           if(resp.result.item_type == 'M')
                                           {
                                            img_folder=`misce`;
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
                                    $('#myModal').modal('show');
                                    for_slider(resp.result.doc_count);
                        
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

