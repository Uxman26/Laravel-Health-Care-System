@extends('layouts.app')
@section('title')
Expence Report
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
        <div class="r8-page-heading history-hd pb-2">
            @include('includes.message')
            <h2>Reports</h2> 
            <form action="{{ route('all.reports') }}" method="get" id="searchFOrm">
                <div class=" d-flex justify-content-between align-items-center">
                    <div class="hhd-lft d-flex justify-content-between align-items-center w-100">
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
                <a href="{{ route('all.reports',['Export'=>1]) }}"><img src="{{asset('public/front_assets/images/arrow-down-circle 1.png')}}" alt=""> Download Reports</a>
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
                            @if(auth()->user()->user_type != 'AHY')<th class="text-center">Approval-Stage</th> @endif
                            <th class="text-center">Fees</th>
                            {{--<th class="text-center">Fuel</th>--}}
                            <th class="text-center">Total</th>
                            <th class="text-center">Status</th>
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
                            @if(auth()->user()->user_type != 'AHY')
                            <td class="text-center">
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
                               
                                @endif
                            </td>
                            @endif
                            <td class="text-center">0</td> 
                            {{--<td class="text-center">0</td>--}}
                           
                            @if(@$data->approved_total > 0 || @$data->getCommentExpDetail)
                                @if(@$data->getCommentExpDetail)
                                <td class="text-center"><strike>{{@$data->claimed_total}}</strike> {{@$data->approved_total}}</td>
                                @else
                                <td class="text-center">{{@$data->claimed_total ? @$data->claimed_total : 0}}</td>
                                @endif
                            @else
                            <td class="text-center">{{@$data->claimed_total ? @$data->claimed_total : 0}}</td>
                            @endif
                            
                            <td class="text-center">
                            @if(auth()->user()->user_type == 'AHY')
                                @if(@$data->approval_stage == 'ACHY')
                                    @if(@$data->status == 'S')
                                    <span class="holds">In Progress</span>
                                    @elseif(@$data->status == 'R')
                                    <span class="rejected">Rejected</span>
                                    @elseif(@$data->status == 'A')
                                    <span class="apprd">Approved</span>
                                    @endif 
                                @else
                                    @if(@$data->status == 'H')
                                    On Hold
                                    @else
                                    -
                                    @endif
                                @endif

                            @else
                                @if(@$data->status == 'S')
                                <span class="holds">In Progress</span>
                                @elseif(@$data->status == 'R')
                                <span class="rejected">Rejected</span>
                                @elseif(@$data->status == 'A')
                                <span class="apprd">Approved</span>
                                @endif 
                            @endif
                            </td>
                            <td class="text-center">
                                @if(checkApproval(@$data->id))
                                    @if(auth()->user()->user_type == 'AHY') 
                                        @if(@$data->getMemo)
                                        <a href="{{route('view.receipt',@$data->id)}}" class="v-icon"><img src="{{asset('public/front_assets/images/eye.png')}}" alt="">View
                                        @else
                                        - 
                                        @endif
                                    @else
                                    <a href="{{route('view.report',@$data->getExpenseDetail->id)}}" class="v-icon"><img src="{{asset('public/front_assets/images/eye.png')}}" alt="">View
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

                        {{--
                        <tr>
                            <td class="white-space">23 Jan 2023</td>
                            <td class="white-space"><a href="#">Bharath Maduguru</a></td>
                            <td class="wd-30">Lorem Ipsum is simply dummy text of the printing and typesetting </td>
                            <td>ONCO</td>
                            <td class="text-center">1234567890</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center"><span class="apprd">Approved</span></td>
                            <td class="text-center"><a href="javascript:;" class="v-icon"><img src="{{asset('public/front_assets/images/eye.png')}}" alt="">View</td>
                        </tr>

                        <tr>
                            <td class="white-space">23 Jan 2023</td>
                            <td class="white-space"><a href="#">Bharath Maduguru</a></td>
                            <td class="wd-30">Lorem Ipsum </td>
                            <td>ONCO</td>
                            <td class="text-center">1234567890</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center"><span class="holds">On Hold</span></td>
                            <td class="text-center"><span class="holds">On Hold</span></td>
                        </tr>

                        <tr>
                            <td class="white-space">23 Jan 2023</td>
                            <td class="white-space"><a href="#">Bharath Maduguru</a></td>
                            <td class="wd-30">Lorem Ipsum is simply dummy text of the printing and typesetting </td>
                            <td>ONCO</td>
                            <td class="text-center">1234567890</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center">0</td>
                            <td class="text-center">0</td>
                            <td class="text-center">1234546</td>
                            <td class="text-center"><span class="rejected">Rejected</span></td>
                            <td class="text-center"><span class="rejected">Rejected</span></td>
                        </tr>--}}

                    </tbody>
                </table>
            </div>
            <div class="row">
                {{--<div class="col-xl-12">
                    <button class="fill-submit2" type="text">Proceed to Admin Head</button>
                </div>--}}

                <div class="col-xl-12">
                    <nav aria-label="Page navigation " >
                    {{@$reports->appends(request()->except(['page', '_token']))->links('pagination2')}}
                        {{--<ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#"><img src="{{asset('public/front_assets/images/chevron-down2.png')}}" alt=""></a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#"><img src="{{asset('public/front_assets/images/chevron-down1.png')}}" alt=""></a></li>
                        </ul>--}}
                    </nav>
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