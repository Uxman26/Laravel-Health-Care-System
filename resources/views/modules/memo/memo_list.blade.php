@extends('layouts.app')
@section('title')
Memo
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
            <h2>Memos</h2>
            <h4>Weekly Memos</h4>
            <form action="" method="get" id="searchFOrm">
                <div class=" d-flex justify-content-between align-items-center">
                    <div class="hhd-lft d-flex justify-content-between align-items-center w-100">

                        <div class="hhd-lft-date">
                            <label for="">View by :</label>
                            <input type="text" placeholder=""  value="{{@$key['date']}}" name="date" id="datepicker" readonly>
                            <a href="{{route('emp.memo.list')}}" id="removeDate" @if(!@$key['date']) style="display:none; @endif"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
                    <div class="wd-30 mt-3">
                        <button class="fill-submit3" type="submit">Search</button>
                    </div>
            </form>
        </div>

        <div class="r8-history-inr">
            @if(@$reports->isNotEmpty())
            @foreach(@$reports as $data)
            <div class="r8-his-box">
                <div class="his-box-one d-flex justify-content-between align-items-center">
                   
                    <div class="rep-id">
                        <h5>{{@$data->expense_unique_code}}</h5>
                    </div>
                    <div class="rep-brd">               
                        @if(@$data->getMemo->status == 'I')
                        <label  style="float:left"><h3 class="text-warning"><strong>Initiated</strong></h3></label>
                        @elseif(@$data->getMemo->status == 'C')
                        <label  style="float:left"><h3 class="text-success"><strong>Completed</strong></h3></label>
                    @endif
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
                            {{--<!-- {{number_format(@$data->approved_total,2)}} -->--}}
                            <del>{{number_format(@$data->claimed_total,2)}}</del> {{number_format(@$data->approved_total,2)}}
                            @else
                            {{number_format(@$data->claimed_total,2)}}
                            @endif
                        </h3>
                    </div>
                </div>

                <div class="his-box-three d-flex justify-content-end align-items-center">
                   
                    <a href="{{route('emp.view.memo',@$data->id)}}"
                        class="view">View Memo</a>
                </div>
            </div>
            @endforeach
            @else
            <div class="r8-his-box">
                No Reports found
            </div>
            @endif

            
        </div>

    </div>

</section>
<div class="row">
                <div class="col-xl-12">
                    <nav aria-label="Page navigation" > 
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
     
});
</script>
@endsection