@extends('layouts.app')
@section('title')
Hetero Health Care - Change Password
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

    <div class="right-page">   <!-- new section starts here -->
        <div class="r8-page-heading frpass">
            <h2>Remarks By Users</h2>
            
        </div>  

        <div class="pass-req-table"> 
            @if(@$remark->isNotEmpty())
            @foreach(@$remark as $list)
          <div class="pass-req-box d-flex justify-content-between align-items-center">
            <div class="req-lft"><span>{{@$list->getUser->empID}}</span><h3 id="emp_name">{{@$list->getUser->name}}</h3></div>
            <div class="req-mid"><span>Remark</span>{{strlen(@$list->remark) > 100 ? substr(@$list->remark,0,100).'...' : @$list->remark}}</div>
            <div class="req-right"><a href="javascript:;" id="show_detail_{{@$list->id}}">Show</a></div>
          </div>
          
          @endforeach
          @else
          <h2>No Request Found!! </h2>
          @endif
        </div>


        
    </div><!-- new section ends here -->
  
</section>
<div class="col-xl-12">
<nav aria-label="Page navigation example" class="examples_list">
            {{@$remark->appends(request()->except(['page', '_token']))->links('pagination3')}}
            </nav>
</div>

<div class="modal" id="myModal" style="padding-top: 50px;">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <center> <h4 class="modal-title" id="emp_name_show" style="text-align:center"> </h4> </center>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div id="remark_content" style="padding-bottom: 70px;padding-right: 17px;padding-left: 28px;">

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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
 @if(@$remark->isNotEmpty())
    @foreach(@$remark as $list)
      $('#show_detail_{{@$list->id}}').click(function(){
        //   var em_name=$('#emp_name').html();
          $('#emp_name_show').html('{{@$list->getUser->name}}');
          $('#myModal').modal('show');
          $('#remark_content').html('{{@$list->remark}}');
      })
      @endforeach
      @endif

  </script>
    
@endsection