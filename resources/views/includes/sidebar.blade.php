<div class="left-bar">
        <a href="#" class="logo-header"><img src="{{asset('public/front_assets/images/logo1.png')}}" alt=""></a>
        <div class="lft-bar-inr">
            <ul>
                @if(@Auth::user()->user_type == 'E')
                <li>
                    <a href="{{route('employee.report')}}" @if(Route::is('employee.report')  ) class="active" @endif ><img src="{{asset('public/front_assets/images/lft-list1.png')}}" alt="">Expenses Report</a>
                </li>
                <li>
                    <a href="{{route('employee.history.report')}}" @if(Route::is('employee.history.report') || Route::is('employee.history.report.detail') || Route::is('employee.edit.report')) class="active" @endif > <img src="{{asset('public/front_assets/images/lft-list4.png')}}" alt="">History</a>
                </li>
                <li>
                    <a href="{{route('content.policy.show')}}"  @if(Route::is('content.policy.show')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list5.png')}}" alt="">Policies</a>
                </li>
                <li>
                    <a href="{{route('emp.memo.list')}}" class="{{Route::is('emp.memo.list','emp.view.memo') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/lft-list6.png')}}" alt="">Weekly Memos</a>
                </li>
                <li>
                    <a href="{{route('employee.password')}}"  @if(Route::is('employee.password')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list7.png')}}" alt="">Change Password</a>
                </li>
                <li>
                    <a href="{{route('content.help')}}" @if(Route::is('content.help') || Route::is('content.user.guide') || Route::is('content.contact.show') || Route::is('content.remark')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list8.png')}}" alt="">Help</a>
                </li>
                @else 
                <li>
                    <a href="{{ Route('all.reports') }}" class="{{Route::is('all.reports','view.report','view.receipt') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/lft-list1.png')}}" alt="">Reports</a>
                </li>

                @if(@Auth::user()->user_type == 'A') 
                <li>
                    <a href="{{route('manage.memo.list')}}" class="{{Route::is('manage.memo.list','create.memo','view.report.receipt') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/memo-icon.png')}}" alt="">Generate Memo</a>
                </li>
                @endif
                @if(@Auth::user()->user_type == 'AHY')
                <li>
                    <a href="{{route('manage.memo.list')}}" class="{{Route::is('manage.memo.list','upload.receipt','view.report.receipt') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/lft-list6.png')}}" alt="">Upload Receipt</a>
                </li>
                @endif
               
                <li>
                    <a href="{{route('manage.history')}}" class="{{Route::is('manage.history','view.history.report','view.histroy.receipt') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/lft-list4.png')}}" alt="">History</a>
                </li>
                
                
                @if(@Auth::user()->user_type == 'AA') 
                <li>
                    <a href="{{route('admin.password.requests')}}" class="{{Route::is('admin.password.requests') ? 'active' : ''}}"><img src="{{asset('public/front_assets/images/lft-list7.png')}}" alt="">Password Requests</a>
                </li>
                @endif
                <li>
                @if(@Auth::user()->user_type == 'A' || @Auth::user()->user_type == 'AA' )
                    <a href="{{route('content.policy')}}" @if(Route::is('content.policy') || Route::is('content.policy.edit')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list5.png')}}" alt="">Policies</a>
                    @else
                    <a href="{{route('content.policy.show')}}"  @if(Route::is('content.policy.show')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list5.png')}}" alt="">Policies</a>
                    @endif
                </li>
               
                <li>
                @if(@Auth::user()->user_type == 'A' || @Auth::user()->user_type == 'AA')
                    <a href="{{route('content.help')}}" @if(Route::is('content.help') || Route::is('content.remark')  || Route::is('content.user.guide.list')  || Route::is('content.manage.user.guide') || Route::is('content.contact.edit') || Route::is('content.contact.edit') || Route::is('content.contact.show') || Route::is('content.remark.list')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list8.png')}}" alt="">Help</a>
                @else
                    <a href="{{route('content.help')}}" @if(Route::is('content.help') || Route::is('content.remark') || Route::is('content.user.guide') || Route::is('content.contact.show')) class="active" @endif><img src="{{asset('public/front_assets/images/lft-list8.png')}}" alt="">Help</a>
                @endif
                </li>
                @endif 
                <li>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logoutModal"><img src="{{asset('public/front_assets/images/lft-list9.png')}}" alt="">LOG OUT</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- The Modal Logout -->
<div class="modal" id="logoutModal">
    <div class="modal-dialog popup_for_comment logout-modal">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">

                <div class="popup_for_receipt_info">
                    <h4>Are you sure. You want to Log Out?</h4>
                </div>

                <div class="reject_approv_btn">
                    <button type="button" class="fill-submit for_rject_only" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ Route('logout') }}" class="fill-submit approve_btn_2">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div>