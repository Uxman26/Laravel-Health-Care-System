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
        @include('includes.message')
            <h2>Password Request</h2>
            <form action="" method="post" id="admin_form">
                @csrf
            <div class="history-hd d-flex justify-content-start align-items-center w-100 for-pas-rec">
               
                    <div class="hhd-lft-slct">                        
                        <select id="division" name="division">
                        <option value="">Select Division</option>
                            @if(@$divisions->isNotEmpty())
                            @foreach(@$divisions as $list)
                            <option value="{{@$list->division}}" {{@$key['division']==@$list->division ? 'selected' : ''}}>{{@$list->division}}</option>
                            @endforeach
                            @endif
                        </select> 
                    </div>
                    <div class="hhd-r8">
                      <input type="text" name="srh_emp" id="srf_emp" value="{{@$key['srh_emp']}}" placeholder="Search with employee name / employee Id" class="hhd-srch">
                    </div>               
            </div>
                <div class="wd-30 mt-3">
                        <button class="fill-submit3" type="submit">Search</button>
                        <a href="{{route('admin.password.requests')}}" style="text-align: center;padding-top: 11px;color: white;" class="fill-submit3" type="submit">Reset</a>
                </div>
            </form>
        </div>  

        <div class="pass-req-table"> 
            @if(@$password->isNotEmpty())
            @foreach(@$password as $list)
          <div class="pass-req-box d-flex justify-content-between align-items-center">
            <div class="req-lft"><span>{{@$list->getUser->empID}}</span><h3>{{@$list->name}}</h3></div>
            <div class="req-mid"><span>Division</span><h3>{{@$list->getUser->division}}</h3></div>
            <div class="req-right"><a href="{{route('admin.generate.password',['id'=>$list->id])}}">Generate</a></div>
          </div>
          
          @endforeach
          @else
          <h2>No Request Found!! </h2>
          @endif
        </div>

        
        
        
    </div><!-- new section ends here -->
</section>
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

      $(document).ready(function(){  
        $("#password_form").validate({
            rules:{
             
                old_password:{
                    required:true,
                remote:{
                        url: "{{route('check.password')}}",
                        type: "GET",
                        data: {
                            password: function() {
                                return $( "#password" ).val();
                                },
                            
                                _token:'{{csrf_token()}}',
                            }
                        },
                },
                new_password:{
                    required:true,
                },
                confirm_password:{
                    required:true,
                    equalTo:'#password2',
                }


            },messages:{
                  
                  old_password:{ 
                    remote:"Please enter correct passord",
                    },
                    confirm_password:{ 
                    remote:"Please Enter same password as new password",
                    },


                },
            submitHandler:function(form){
                   form.submit();
                },
        
        });

        $('#dob').datepicker();
      });

 

  </script>
    
@endsection