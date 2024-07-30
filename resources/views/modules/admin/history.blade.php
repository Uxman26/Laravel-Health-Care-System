@extends('layouts.app')
@section('title')
History
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

    <div class="right-page padd_pagine">
        <div class="r8-page-heading history-hd pb-2">
            @include('includes.message')
            <h2>History</h2>
            <form action="{{ route('manage.history') }}" method="get" id="searchFOrm">
                <div class=" d-flex justify-content-between align-items-center">
                    <div class="hhd-lft d-flex justify-content-between align-items-center w-100 a_history">
                        <div class="hhd-lft-slct wd-20">

                            <select id="" name="division">
                                <option value="">Select Division</option>
                                @if(count(@$divisions) > 0)
                                @foreach(@$divisions as $val)
                                <option value="{{@$val->division}}" {{@$key['division']==@$val->division ? 'selected' : ''}}>{{@$val->division}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="hhd-r8">
                            <input type="text"
                                placeholder="Search with employee name / employee Id / headqarters / reference id"
                                class="hhd-srch" name="keyword" value="{{@$key['keyword']}}">
                        </div>
                        <div class="hhd-lft-date">
                            <label for="">View by :</label>
                            <input type="text" placeholder=""  value="{{@$key['date']}}" name="date" id="datepicker" autocomplete="off">
                            <a id="removeDate" @if(!@$key['date']) style="display:none; @endif"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
                    <div class="wd-30 mt-3">
                        <button class="fill-submit3" type="submit">Search</button>
                    </div>
            </form>
        </div>

        <div class="result_para">
            @if(@$key)
            <h2>Result</h2>
            @endif
            <div class="result_info">
                <div>
                @if(@$key)
                    <h3>@if(@$key['date']) {{ date('d-m-Y', strtotime(@$key['date'])) }} @endif</h3>
                    <p>{{count(@$reports)}} Reports</p>
                @endif
                </div>
                <a href="{{ route('manage.history',['Export'=>1]) }}"><img src="{{asset('public/front_assets/images/arrow-down-circle 1.png')}}" alt=""> Download Reports</a>
            </div>
        </div>

        <div class="reports_table">
            <div class="table-responsive">
                <table class="table  table-striped2 table-hover ">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference No</th>
                            <th class="white-space">Cheque in Favour Of</th>
                            <th class="wd-30">Narration</th>
                            <th>Division</th>
                            <th class="text-center">PO.NO.</th>
                            <th class="text-center">Fees</th>
                            {{--<th class="text-center">Fuel</th>--}}
                            <th class="text-center">Total</th>
                            <th class="text-center">Current Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count(@$reports) > 0)
                        @foreach(@$reports as $data)
                        <tr>
                            <td class="white-space">{{@$data->start_date ? date('d-m-Y',strtotime(@$data->start_date)) : '-'}}</td>
                            <td class="white-space">{{@$data->expense_unique_code ? @$data->expense_unique_code : '-'}}</td>
                            <td class="white-space">{{@$data->getUser ? @$data->getUser->name : '-'}}</td>
                            <td class="wd-30">Weekly Expense Report</td>
                            <td>{{@$data->getUser ? @$data->getUser->division : '-'}}</td>
                            <td class="text-center">-</td>
                            {{--<td class="text-center">
                                @if(@$data->approval_stage == 'NA')
                                Non-approval Stage
                                @elseif(@$data->approval_stage == 'ADAS')
                                Admin Assistant
                                @elseif(@$data->approval_stage == 'HR')
                                HR
                                @elseif(@$data->approval_stage == 'ACAS')
                                Accountant Assistant
                                @elseif(@$data->approval_stage == 'ACH')
                                Accountant Head
                                @elseif(@$data->approval_stage == 'ACHY')
                                Acountant HYD
                                @elseif(@$data->approval_stage == 'ADH')
                                Admin head
                                @elseif(@$data->approval_stage == 'ACHY' && @$data->status == "A")
                                <span >Approved</span>
                                @endif
                            </td>--}}
                            <td class="text-center">0</td>
                            {{--<td class="text-center">0</td>--}}
                            <td class="text-center">
                                @if(@$data->approved_total > 0 ||  @$data->getCommentExpDetail)
                                {{--{{@$data->approved_total ? @$data->approved_total : 0}}--}}
                                <del>{{number_format(@$data->claimed_total,2)}}</del> {{number_format(@$data->approved_total,2)}}
                                @else 
                                {{@$data->claimed_total ? @$data->claimed_total : 0}}
                                @endif
                            </td>
                            <td class="text-center {{@$data->status}}">
                                <span class="" style="color: #0072BC;">
                                @if(@$data->approval_stage == 'ADAS')
                                Admin Asst.
                                @elseif(@$data->approval_stage == 'HR')
                                HR
                                @elseif(@$data->approval_stage == 'ACAS')
                                Acct Asst.
                                @elseif(@$data->approval_stage == 'ACH')
                                Acct Head.
                                @elseif(@$data->approval_stage == 'ACHY' && @$data->status == "A")
                                    @if(@$data->getMemo->status == 'I')
                                    <span class="text-success">Transaction Initiated</span>
                                    @elseif(@$data->getMemo->status == 'C')
                                    <span class="text-success">Transaction Completed</span>
                                    @else
                                    <span class="text-success">Approved</span>
                                    @endif
                                @elseif(@$data->approval_stage == 'ACHY')
                                Acct Hyd.
                                @elseif(@$data->approval_stage == 'ADH')
                                Admin Head
                                @endif
                                </span> 
                            </td>
                            <td class="text-center">
                                @if(checkApproval(@$data->id))
                                    @if(auth()->user()->user_type == 'AHY')
                                    <a href="{{route('view.histroy.receipt',@$data->id)}}" class="v-icon"><img src="{{asset('public/front_assets/images/eye.png')}}" alt="">View</a>
                                    @else
                                    <a href="{{route('view.history.report',@$data->getExpenseDetail->id)}}" class="v-icon"><img src="{{asset('public/front_assets/images/eye.png')}}" alt="">View</a>
                                    @endif
                                @else 
                                -
                                @endif
                            </td>
                        </tr>
                            @endforeach
                            @else
                            <tr>
                            <td colspan="10">No data found</td>
                            </tr>
                            @endif 

                    </tbody>
                </table>
            </div>
            
        </div>




    </div>

</section>
<div class="row"> 

                <div class="col-xl-12">
                    <nav aria-label="Page navigation " >
                    {{@$reports->appends(request()->except(['page', '_token']))->links('pagination2')}}
                    </nav>
                </div>
            </div>
@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script>
$(document).ready(function() {
    $("body").on('click','#removeDate',function(){
        $("#datepicker").val("");
        $("#removeDate").css("display",'none');
        $("#searchFOrm").submit();
        //window.location.href = '{{ route("manage.history") }} ';
    });

    $('#datepicker').change(function(){
        $("#removeDate").css("display",'block');
    });

});
</script>
@endsection