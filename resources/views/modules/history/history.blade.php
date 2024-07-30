@extends('layouts.app')
@section('title')
Hetero Health Care - Expence History
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
            <h2>History</h2>
            <div class="history-hd d-flex justify-content-between align-items-center">
                <form action="" method="get" id="search_form">
                    <div class="hhd-lft d-flex justify-content-start align-items-center">
                        <div class="hhd-lft-slct">
                            <label for="">Sort by:</label>
                            <select id="search_sort" name="search_sort">
                                <option value="1" @if(@$key['search_sort']=='1' ) selected @endif>All</option>
                                <option value="2" @if(@$key['search_sort']=='2' ) selected @endif>Date(Ascending)</option>
                                <option value="3" @if(@$key['search_sort']=='3' ) selected @endif>Date(Descending)</option>
                                <!-- <option value="3">Name</option> -->
                            </select>
                        </div>
                        <div class="hhd-lft-date">
                            <label for="">View by :</label>
                            <input type="text" placeholder="" value="{{@$key['search_date']}}" name="search_date"
                                id="search_date" readonly>
                        </div>
                    </div>
                    <!-- <div class="hhd-r8">
                        <input type="text" value="{{@$key['search_key']}}" name="search_key" id="search_key" placeholder="Search with employee name / employee Id / headqarters / reference id" class="hhd-srch">
                    </div> -->
                </form>
            </div>
        </div>

        <div class="r8-history-inr">
            @if(@$history->isNotEmpty())
            @foreach(@$history as $data)
            <div class="r8-his-box">
                <div class="his-box-one d-flex justify-content-between align-items-center">
                    <div class="rep-brd">
                        <ul>

                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'ADAS') 
                                    style="color:red" 
                                @endif
                                @if(@$data->approval_stage == 'ADH' || @$data->approval_stage == 'HR' || @$data->approval_stage == 'ACAS' || @$data->approval_stage == 'ACH' || @$data->approval_stage == 'ACHY' )
                                    style="color:blue" 
                                @else 
                                    style="color:grey" 
                                @endif 
                                >Admin Asst.<span>></span>
                                </a>
                            </li>
                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'ADH') 
                                    style="color:red" 
                                @endif 
                                @if(@$data->approval_stage == 'HR' || @$data->approval_stage == 'ACAS' || @$data->approval_stage == 'ACH' || @$data->approval_stage == 'ACHY' ) 
                                    style="color:blue" 
                                @else 
                                    style="color:grey" 
                                @endif
                                >Admin<span>></span>
                                </a>
                            </li>
                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'HR') 
                                    style="color:red" 
                                @endif 
                                @if(@$data->approval_stage == 'ACAS' || @$data->approval_stage == 'ACH' || @$data->approval_stage == 'ACHY')
                                    style="color:blue" 
                                @else 
                                    style="color:grey" 
                                @endif 
                                >HR<span>></span>
                                </a>
                            </li>
                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'ACAS') 
                                    style="color:red" 
                                @endif 
                                @if(@$data->approval_stage == 'ACH' || @$data->approval_stage == 'ACHY' ) 
                                    style="color:blue" 
                                @else 
                                    style="color:grey"
                                @endif
                                >Acct. Asst.<span>></span>
                                </a></li>
                            
                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'ACH') 
                                    style="color:red" 
                                @endif 
                               
                                @if(@$data->approval_stage == 'ACH' || @$data->approval_stage == 'ACHY') 
                                    @if(@$data->status == 'A' || @$data->status == 'H' || @$data->rejected_by == 'ACHY') style="color:blue"  @else style="color:grey" @endif 
                                @else 
                                    style="color:grey" 
                                @endif
                                >Acct. Head<span>></span> 
                                </a></li>

                            <li><a href="javascript:;" class="" 
                                @if(@$data->status == 'R' && @$data->rejected_by == 'ACHY') 
                                    style="color:red"  
                                @endif 
                                @if(@$data->approval_stage == 'ACHY' || @$data->status == 'H') 
                                    @if(@$data->status == 'A') style="color:blue" @elseif(@$data->status == 'H') style="color:#ff9900"  @else style="color:grey" @endif 
                                @else 
                                    style="color:grey" 
                                @endif
                                >Acct. Hyd<span>></span>
                                </a></li>
                            <li><a href="javascript:;" class="" 
                                @if(@$data->getMemo && @$data->approval_stage == 'ACHY' && @$data->status == 'A')  
                                    style="color:blue"  
                                @else 
                                    style="color:grey"
                                @endif
                                >@if(@$data->getMemo->status == 'C') Transaction Completed @else Transaction Initiated @endif</a></li>
                        </ul>
                    </div>
                   
                    <div class="rep-id">
                        <h5 style="color:black">{{@$data->expense_unique_code}}</h5>
                    </div>
                   
                </div>
                <div class="his-box-two d-flex justify-content-between align-items-center">
                    <div class="his-two-lft">
                        <h5>Date</h5>
                        <h3>{{date('d-m-Y',strtotime(@$data->start_date))}} to
                            {{date('d-m-Y',strtotime(@$data->end_date))}}</h3>
                    </div>
                    <div class="his-two-r8">
                        <h5>Grand Total</h5>
                        <h3>
                            @if(@$data->approved_total > 0 || @$data->getCommentExpDetail)
                            <del>{{number_format(@$data->claimed_total,2)}}</del> {{number_format(@$data->approved_total,2)}}
                            @else
                            {{number_format(@$data->claimed_total,2)}}
                            @endif
                        </h3>
                    </div>
                </div>
               
                @if(@$data->status == 'D')
                    <label  style="float:left"><h3 style="color:#e5e50e">Draft</h3></label>
                    @elseif(@$data->status == 'S')
                    <label  style="float:left"><h3 style="color:blue">Submitted</h3></label>
                    @elseif(@$data->status == 'R')
                    <label  style="float:left"><h3 style="color:red">Rejected</h3></label>
                    @elseif(@$data->status == 'A')
                    <label  style="float:left"><h3 style="color:green">@if(@$data->getMemo->status == 'C') Transaction Completed @elseif(@$data->getMemo->status == 'I') Transaction Initiated @else Approved @endif </h3></label>
                    @elseif(@$data->status == 'H')
                    <label  style="float:left"><h3 style="color:#ff9900">On-Hold</h3></label>
                    @endif
                <div class="his-box-three d-flex justify-content-end align-items-center">
                   
                    @if(@$data->status == 'D' || @$data->status == 'R')
                    <a href="{{route('employee.edit.report',['id'=>@$data->getExpenseDetail->id])}}"
                        class="modify">Modify</a>
                    @endif
                    
                    @if(@$data->status == 'A' && @$data->getMemo->status == 'C')
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#receiptModal_{{@$data->id}}"
                        class="modify">Transaction Receipt</a>
                    @endif
                    <a href="{{route('employee.history.report.detail',['id'=>@$data->getExpenseDetail->id])}}"
                        class="view">View Report</a>
                </div>
            </div>
            
            @endforeach
            @else
            <div class="r8-his-box">
                No Reports found
            </div>
            @endif
            <!-- <div class="r8-his-box">
                <div class="his-box-one d-flex justify-content-between align-items-center">
                    <div class="rep-brd">
                        <ul>
                            <li><a href="#" class="blue">Admin Asst.<span>></span></a></li>
                            <li><a href="#" class="">Admin<span>></span></a></li>
                            <li><a href="#" class="">HR<span>></span></a></li>
                            <li><a href="#" class="">Acct. Asst.<span>></span></a></li>
                            <li><a href="#" class="">Acct.<span>></span></a></li>
                            <li><a href="#" class="">Acct. Hyd<span>></span></a></li>
                            <li><a href="#" class="">Transaction Initiated</a></li>
                        </ul>
                    </div>
                    <div class="rep-id"><h5>WE1123445</h5></div>
                </div>
                <div class="his-box-two d-flex justify-content-between align-items-center">
                    <div class="his-two-lft">
                        <h5>Date</h5>
                        <h3>11-08-2022 to 17-08-2022</h3>
                    </div>
                    <div class="his-two-r8">
                        <h5>Grand Total</h5>
                        <h3>2760.00</h3> 
                    </div>
                </div>
                <div class="his-box-three d-flex justify-content-end align-items-center">
                    <a href="#" class="modify disabled">Modify</a>
                    <a href="#" class="view">View Report</a>
                </div>
            </div> -->

        </div>
       
    </div>

</section>
<div class="row">

<div class="col-xl-12">
    <nav aria-label="Page navigation" >
    {{@$history->appends(request()->except(['page', '_token']))->links('pagination2')}}
    </nav>
</div>
</div>

@if(@$history->isNotEmpty())
@foreach(@$history as $data1)
<!-- The Modal Upload -->
<div class="modal" id="receiptModal_{{@$data1->id}}">
    <div class="modal-dialog popup_for_comment">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Transaction Receipt</h4>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_receipt_info">
                    <h4 style="padding-left: 28px;">ID: {{@$data1->getMemo->transaction_id ? @$data1->getMemo->transaction_id : '-'}}</h4>
                    <h4 style="padding-left: 28px;">Remark: {{@$data1->getMemo->transaction_remark ? @$data1->getMemo->transaction_remark : '-'}}</h4>
                    <div class="tran_img" style="display: flex;justify-content: center;margin: auto;padding:30px">
                    <img src="{{ URL::to('storage/app/public/images/receipts')}}/{{@$data1->getMemo->transaction_receipt}}" alt="" style="width:100%">
                    </div>
                </div>

            </div>
            <!-- Modal body end-->

        </div>
    </div>
</div>
@endforeach
@endif

@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script>
$(document).ready(function() {
    $('#search_date').datepicker({
        maxDate: 0,
        dateFormat: "dd-mm-yy",
    });

    $('#search_sort,#search_date,#search_key').change(function() {
        // alert('213');
        // var search_sort=$('#search_sort').val();
        // var search_date=$('#search_date').val();
        // var search_key=$('#search_key').val();
        $('#search_form').submit();

    })


});
</script>
@endsection