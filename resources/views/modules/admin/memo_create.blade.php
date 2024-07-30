@extends('layouts.app')
@section('title')
Transaction Receipt
@endsection
@section('style') 
@include('includes.style')
<style>
    label#receipt_image-error{
        color:red;
    }
</style>
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
                @if(Route::is('view.receipt'))
                <a href="{{route('all.reports')}}" class="back"><img src="{{asset('public/front_assets/images/arrow-left.png')}}" alt=""></a>
                @elseif(Route::is('view.histroy.receipt'))
                <a href="{{route('manage.history')}}" class="back"><img src="{{asset('public/front_assets/images/arrow-left.png')}}" alt=""></a>
                @else 
                <a href="{{route('manage.memo.list')}}" class="back"><img src="{{asset('public/front_assets/images/arrow-left.png')}}" alt=""></a>
                @endif
            <div style="display: flex;align-content: center;justify-content: space-between;">
                <h5> @if(Route::is('view.receipt','view.histroy.receipt')) View Memo @else @if(auth()->user()->user_type == 'AHY') Upload Receipt @else Generate Memo @endif @endif > {{@$master->expense_unique_code}}</h5>
                
                @if(@Auth::user()->user_type == 'A' && @$memo->status == 'I')
                <h3  style="float:left"><h3 class="text-warning"><strong>Initiated</strong></h3></h3>
                @endif
            </div>
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

                    <div class="receipt_btns">
                        @if(@Auth::user()->user_type == 'AHY')
                            
                            @if(@$memo->transaction_id && @$memo->transaction_id)
                                <a href="javascript:;" class="d-block" data-bs-toggle="modal" data-bs-target="#receiptModal">
                                Transaction Receipt
                                </a>
                            @else 
                                @if(@$master->approval_stage == 'ACHY' && @$master->status == 'A')
                                <a href="javascript:;" class="d-block" data-bs-toggle="modal" data-bs-target="#uploadReceiptModal">
                                Upload Transaction Receipt
                                </a>
                                @endif
                            @endif
                            
                        @endif
                        @if(@Auth::user()->user_type == 'A')
                            
                            @if(@$memo->transaction_id && @$memo->transaction_id)
                                <a href="javascript:;" class="d-block" data-bs-toggle="modal" data-bs-target="#receiptModal">
                                Transaction Receipt
                                </a>
                            @endif
                            
                        @endif  
                        @if(@$memo->transaction_id)
                        <a href="{{route('view.history.report',@$master->getExpenseDetail->id)}}" class="d-block memo-hd-vw">View Report</a>
                        @else  
                        @if(Route::is('view.receipt'))
                        <a href="{{route('view.report',@$master->getExpenseDetail->id)}}" class="d-block memo-hd-vw">View Report</a>
                        @else
                        <a href="{{route('view.report.receipt',@$master->getExpenseDetail->id)}}" class="d-block memo-hd-vw">View Report</a>
                        @endif
                        @endif
                        
                    </div>
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
                        {{--@if(@$data->days_approved > 0)--}}
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
                                <input type="text" placeholder="" value="@if(@$data->days_approved > 0 || @$data->is_admin_commented == 'Y') {{@$data->days_approved}}  @else {{@$data->days_total}} @endif" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        {{--@else
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="fill-box">
                                <label for="">Approved Amount</label>
                                <input type="text" placeholder="" value="{{@$data->days_total}}" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @endif--}}
                    </div>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Grand Total</h4>
                        </div>
                        {{--@if(@$master->approved_total > 0)--}}
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
                                <input type="text" placeholder="Enter Here" value="@if(@$master->approved_total > 0 ||  @$master->getCommentExpDetail) {{@$master->approved_total}}  @else {{@$master->claimed_total}} @endif" readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        {{--@else 
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="empl-box grand_total">
                                <label for="" >Approved Amount</label>
                                <!-- <h3>123422</h3> -->
                                <input type="text" placeholder="Enter Here" value="{{@$master->claimed_total}}"  readonly>
                                <span>Rupees Only</span>
                            </div>
                        </div>
                        @endif--}}
                        <div class="col-md-12">
                            <div class="remark comment_err">
                                <h3>Remark</h3>                                
                                <textarea placeholder="Enter here" name="remark" id="remark"
                                            class="claim_boxx_mesg comment_fields required" @if(@Auth::user()->user_type == 'AHY' || @$memo->status == 'C') readonly @endif>{{@$memo->remark ? @$memo->remark : old('remark')}}</textarea>
                            </div>
                        </div>    
                        <input type="hidden" name="uploaded_img" id="uploaded_img" value="{{@$admin_head->signature_image ? @$admin_head->signature_image : ''}}" >                  
                        {{--@if(@$admin_head->signature_image)
                        <div class="col-md-3">      
                            <div class="sign_img">
                                <img  src="{{ URL::to('storage/app/public/images/signature_image')}}/{{@$admin_head->signature_image}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        @endif --}}

                        <!-- //// -->
                            <div class="signature-btns d-flex justify-content-between align-items-center">
                                <div class="signer-lft">
                                    <div class="sign-img">
                                    @if(@$admin_head->signature_image)
                                    <img id="sign_image_show" src="{{ URL::to('storage/app/public/images/signature_image')}}/{{@$admin_head->signature_image}}" alt="" class="img-fluid">
                                    @endif
                                    </div>
                                    <!-- <h5 class="sign-name">Rahul(Admin)</h5> -->
                                </div>
                                @if(auth()->user()->user_type == 'AHY' && @$master->approval_stage != 'ACHY' )
                                <div class="sign-btns-right d-flex justify-content-end align-items-center">
                                  <a href="javscript:;" class="sbt1 approve_btn">Approve</a>
                                  @if(@$master->status != 'H')
                                  <a href="javascript:;" class="sbt2" data-bs-toggle="modal" data-bs-target="#HoldModal">On Hold</a> 
                                  @endif
                                  <a href="javscript:;" class="sbt3 reject_btn" data-bs-toggle="modal" data-bs-target="#RejectModal">Reject</a>
                                </div>
                                @endif
                            </div>

                        <!-- // -->

                        @if(@Auth::user()->user_type == 'A' && !@$memo)
                        <div class="col-md-12">                            
                            <div class="signature d-flex justify-content-between align-items-center flex-wrap">                                
                                <div class="sign-lft">
                                    <label>Recommended dimension 380px * 130px</label>
                                    <div class="sign-upld comment_err">
                                        <input type="file" name="signature_image" id="signature_image" accept="image/png, image/jpeg, image/jpg"  >
                                        <img src="{{asset('public/front_assets/images/upload.png')}}" alt="">
                                        <h5 id="file_name" style="font-size: 16px;font-weight: 600;"></h5>
                                        <h3>Upload Signature</h3>
                                        <!-- <p>Use PNG. JPEG</p>  -->
                                    </div>
                                    <h6>{{@$admin_head->name}} (Admin)</h6>
                                </div>
                                @if(!@$memo)
                                <button class="gener" type="submit"> Generate </button>
                                @endif
                            </div>
                        </div>
                        @endif
                       
                        @if(@Auth::user()->user_type == 'AHY' || (@Auth::user()->user_type == 'A' && @$memo->status != ''))
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
                            @elseif(@$memo->status == 'R')
                            <label  style="float:left"><h3 style="color:red"><strong>Rejected</strong></h3></label>
                            @elseif(@$memo->status == 'H')
                                <label  style="float:left"><h3 class="text-warning"><strong>On Hold</strong></h3></label>
                            @endif
                            </div>
                        @endif
                              
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<!-- The Modal Upload -->
<div class="modal" id="uploadReceiptModal">
    <div class="modal-dialog popup_for_comment">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Upload Receipt</h4>
                <button type="button" class="btn-close closeModal receipt_close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_receipt_info">
                    <form action="{{route('save.receipt')}}" method="post" id="receipt_form" class="log-r8-frm" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                            <input type="hidden" name="expense_master_id" id="" value="{{@$master->id}}">
                            <input type="hidden" name="id" id="" value="{{@$memo->id}}">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="fill-box comment_err">
                                        <label for="" class="approved_title">Transaction ID</label>
                                        <div class="">
                                            <input type="text" placeholder="Transaction ID"
                                                name="transaction_id" id="transaction_id"  class=" required">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="fill-box">
                                        <label for="">Attachment</label>
                                        <div class="fill-box-file">
                                            <h3><span id="rfile_name">Upload Document</span> <img
                                                    src="http://localhost/heterohealthcare/public/front_assets/images/upload.png"
                                                    alt=""></h3>
                                            <input type="file" name="receipt_image" id="receipt_image" data-multiple-caption=""
                                            accept="image/png, image/jpeg, image/jpg" multiple="">
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="fill-box comment_err">
                                        <label for="">Remark</label>
                                        <p class="modal_commt"></p>
                                        <input type="text" placeholder="Remark"
                                                name="remark" id="remark" class=" required">
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="fill-submit" type="submit" id="">Done</button>
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
<!-- The Modal Upload -->
<div class="modal" id="receiptModal">
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
                    <h4>ID: {{@$memo->transaction_id ? @$memo->transaction_id : '-'}}</h4>
                    <h4>Remark: {{@$memo->transaction_remark ? @$memo->transaction_remark : '-'}}</h4>
                    <div class="tran_img" style="width:100%;height:auto">
                    <img src="{{ URL::to('storage/app/public/images/receipts')}}/{{@$memo->transaction_receipt}}" alt="">
                    </div>
                </div>

            </div>
            <!-- Modal body end-->

        </div>
    </div>
</div>


<!-- for Hold memo -->
<!-- The Modal -->
<div class="modal" id="HoldModal">
    <div class="modal-dialog popup_for_comment">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">On-hold</h4>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_comment_info">
                    <form action="{{route('approve.hold.reject.hyd')}}" method="post" id="hold_form" class="log-r8-frm mt-0">
                        <input type="hidden" name="id" value="{{@$master->id}}" >
                        <input type="hidden" name="type" value="H" >
                        @csrf
                        <div class="container">
                            <div class="row">
                                <input type="hidden" class="comment_fields" name="expense_detail_id" id="expense_detail_id" value="{{@$expense->id}}">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="fill-box">
                                        <label for="">Comment</label>
                                        <textarea placeholder="Enter your comment here" name="comment" id="comment"
                                            class="claim_boxx_mesg comment_fields"></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="fill-submit" type="text">Submit</button>
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

<!-- The reject Modal -->
<div class="modal" id="RejectModal">
    <div class="modal-dialog popup_for_comment">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reject23</h4>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_comment_info">
                    <form action="{{route('approve.hold.reject.hyd')}}" method="post" id="reject_form" class="log-r8-frm mt-0">
                        <input type="hidden" name="id" value="{{@$master->id}}" >
                        <input type="hidden" name="type" value="R" >
                        @csrf
                        <div class="container">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="fill-box">
                                        <label for="">Comment</label>
                                        <textarea placeholder="Enter your comment here" name="comment" id="comment"
                                            class="claim_boxx_mesg comment_fields"></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="fill-submit" type="text">Submit</button>
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
@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{asset('public/front_assets/js/sweet-alert.js')}}"></script>
<script>
$(document).ready(function() {
    
    $("#memo_form").validate({
            rules:{
                remark:{
                    required:true,
                    maxlength:500
                },
                signature_image:{
                    required:function(element){
                        return $("#uploaded_img").val()=="";
                    },
                },
                
            },
            messages: {
                remark:{
                    maxlength: 'Please enter not more than 500 characters'
                },
            },
            submitHandler:function(form){
                   form.submit();
                },
        
    });

        $('#signature_image').change(function(e){
            var fileName = e.target.files[0].name;
            // $('#file_name').text(fileName);
            // $('label.error').css('display','none');
            readURL(this);
            

        });

        function readURL(input) {
           
            console.log(input.files);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                   
                    // $(".profiles").show();
                    $('#sign_image_show').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        //Upload receipt by account hyderabad
        $.validator.addMethod("transaction_regex", function(value, element) {
                return this.optional(element) || /^([a-zA-Z0-9\s])+$/.test(value)
            }, "Letters and numbers only please");

        $("#receipt_form").validate({
            rules:{
                transaction_id:{
                    required:true,
                    transaction_regex:true,
                    maxlength:50
                },
                receipt_image:{
                    required:true,
                },
                remark:{
                    required:true,
                    maxlength:500
                },
                
            },
            messages: {
                transaction_id:{
                    maxlength: 'Please enter not more than 50 characters'
                },
                remark:{
                    maxlength: 'Please enter not more than 500 characters'
                },
            },
            submitHandler:function(form){
                   form.submit();
                   //saveComment();
                },
        
        });

        $('#receipt_image').change(function(e){
            var fileName = e.target.files[0].name;
            $('#rfile_name').text(fileName);
            $('label#receipt_image-error').css('display','none');

        });
});

$('.approve_btn').click(function(){
            // var id = $(this).data('id');
            Swal.fire({
                title: 'Approve Weekly Report?',
                text: "Do you want to approve this report?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href ="{{route('approve.report.hyd',['id'=>@$master->id,'type'=>'A'])}}";
                }
            });
        });

        // $('.hold_btn').click(function(){
        //     // var id = $(this).data('id');
        //     Swal.fire({
        //         title: 'Hold Weekly Report?',
        //         text: "Do you want to OnHold this report?",
        //         icon: 'question',
        //         showCancelButton: true,
        //         cancelButtonText: 'No',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             window.location.href ="{{route('approve.report.hyd',['id'=>@$master->id,'type'=>'H'])}}";
        //         }
        //     });
        // });

        $("#hold_form").validate({
            rules:{
                comment:{
                    required:true,
                },
                
            },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

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

       
</script>
@endsection