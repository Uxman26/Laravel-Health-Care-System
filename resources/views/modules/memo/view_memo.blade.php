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

<section class="expense-inr d-flex w-100 justify-content-end align-items-strat memo_page">
    @include('includes.sidebar')

    <div class="right-page">
            @include('includes.message')
            
        <div class="r8-page-heading">
            <h2>Memos</h2>
            <h4>Weekly Memos</h4>
            <h3 class="mt-3" style="font-size: 18px;">From: {{date('d-m-Y',strtotime(@$master->start_date))}} to
                            {{date('d-m-Y',strtotime(@$master->end_date))}} <img src="{{asset('public/front_assets/images/calendar-dark.png')}}" alt="" style="width: 16px;margin-top: -4px;"></h3>
        </div>
        
        <div class="admin-apge-inr">
            <div class="empl no-empl">
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
                        <input type="hidden" name="designation" id="designation"
                            value="{{@$master->getUser->designation}}">
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
            <div class="memo">
                <div class="memo-head d-flex justify-content-between align-items-center">
                    <h2>Memo</h2>
                    <a href="{{route('employee.history.report.detail',['id'=>@$master->getExpenseDetail->id])}}" class="d-block">View Report</a>
                </div>
                <form action="{{route('save.memo')}}" method="post" class="memo-frm" id="memo_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="expense_master_id" id="expense_master_id" value="{{@$master->id}}">
                <input type="hidden" name="id" id="id" value="{{@$memo->id}}">
                    @if(count(@$master->getExpenseDetailMany) > 0)
                        @foreach(@$master->getExpenseDetailMany as $data)
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                            <div class="fill-box">
                                <label for="">Date</label>
                                <input type="text" placeholder="" value="{{date('d-m-Y', strtotime(@$data->date))}}" readonly>
                            </div>
                        </div>
                        @if(@$data->days_approved > 0 || @$data->is_admin_commented == 'Y')
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="fill-box">
                                <label for="" class="text-secondary">Claimed Amount</label>
                                <input type="text" placeholder="" value="{{@$data->days_total}}" readonly  class="text-secondary">
                                <span class="text-secondary">Rupees Only</span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="fill-box">
                                <label for="">Approved Amount</label>
                                <input type="text" placeholder="" value="{{@$data->days_approved}}" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @else
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="fill-box">
                                <label for="">Approved Amount</label>
                                <input type="text" placeholder="" value="{{@$data->days_total}}" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @endif
                    </div>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Grand Total</h4>
                        </div>
                        @if(@$master->approved_total > 0 ||  @$master->getCommentExpDetail)
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="empl-box grand_total">
                                <label for="" class="text-secondary">Claimed Amount</label>
                                <!-- <h3>123422</h3> -->
                                <input type="text" placeholder="Enter Here" value="{{@$master->claimed_total}}" class="text-secondary" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="empl-box grand_total">
                                <label for="">Approved Amount</label>
                                <!-- <h3>123422</h3> -->
                                <input type="text" placeholder="Enter Here" value="{{@$master->approved_total}}" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @else 
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="empl-box grand_total">
                                <label for="" >Approved Amount</label>
                                <!-- <h3>123422</h3> -->
                                <input type="text" placeholder="Enter Here" value="{{@$master->claimed_total}}"  readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="remark comment_err">
                                <h3>Remark</h3>                                
                                <textarea placeholder="Enter here" name="remark" id="remark" readonly
                                            class="claim_boxx_mesg comment_fields required">{{@$memo->remark ? @$memo->remark : old('remark')}}</textarea>
                            </div>
                        </div>    
                        <input type="hidden" name="uploaded_img" id="uploaded_img" value="{{@$admin_head->signature_image ? @$admin_head->signature_image : ''}}">                  
                        @if(@$admin_head->signature_image)
                        <div class="col-md-3">      
                            <div class="sign_img">
                                <img src="{{ URL::to('storage/app/public/images/signature_image')}}/{{@$admin_head->signature_image}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-10">                            
                            <div class="signature d-flex justify-content-between align-items-center flex-wrap">                                
                                <div class="sign-lft">
                                    <h6>{{@$admin_head->name}} (Admin)</h6>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if(@$memo->status == 'I')
                            <label  style="float:left"><h3 class="text-warning"><strong>Initiated</strong></h3></label>
                            @elseif(@$memo->status == 'C')
                            <label  style="float:left"><h3 class="text-success"><strong>Completed</strong></h3></label>
                            @endif
                            </div>
                    </div>
                </form>
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
});
</script>
@endsection