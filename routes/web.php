<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/mail-design", function(){return view("mail.test_mail_design");});

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');   
Route::get('/login', 'Auth\LoginController@showUserLoginForm')->name('login'); 
Route::post('/do-login', 'Auth\LoginController@login')->name('do.login'); 
Route::get('/register', 'Auth\RegisterController@register')->name('register'); 
Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); 


Route::post('/do-registration', 'Auth\RegisterController@do_regiratration')->name('do.register');

Route::get('/registration-verify/{vcode}/{id}', 'Auth\RegisterController@user_verify')->name('registration.verify');
Route::get('/messages', 'Auth\RegisterController@message_view')->name('registration.message');

Route::get('/password-check', 'Modules\User\UserController@check_password')->name('check.password');

//forforget password
Route::get('/forget-password', 'Auth\ForgotPasswordController@forget_password')->name('forget.password'); 
Route::post('/do-forget-password', 'Auth\ForgotPasswordController@do_forget_password')->name('do.forget.password'); 

//for reset password
Route::get('/reset-password/{vcode?}/{id?}', 'Auth\ResetPasswordController@view_reset')->name('reset.password'); 
Route::post('/do-reset-password', 'Auth\ResetPasswordController@reset_password')->name('do.reset.password');

//for checking the phone and email uniqunes
Route::get('/check-email-unique','HomeController@check_gmail_unique')->name('check.email.unique');
Route::get('/check-phone-unique','HomeController@check_phone_unique')->name('check.phone.unique');

Route::group(['middleware' => 'auth'], function() {

//for report
Route::get('/add-report/{date?}','Modules\Report\ReportController@report')->name('employee.report');
Route::get('/edit-report/{id?}','Modules\Report\ReportController@edit_report')->name('employee.edit.report');
Route::post('/report','Modules\Report\ReportAjaxController@report_submit')->name('employee.report.submit');
Route::any('/report-save','Modules\Report\ReportAjaxController@reportSave')->name('employee.report.save');
Route::any('/report-save-expense-data','Modules\Report\ReportAjaxController@saveExpenseData')->name('employee.report.saveExpenseData');
Route::post('/report-submit','Modules\Report\ReportAjaxController@report_submit')->name('employee.report.submit.final');


//for delete item doc
Route::get('/report-delete-doc','Modules\Report\ReportAjaxController@delete_particular_doc')->name('employee.report.delete.doc');
//for delete item doc
Route::get('/report-delete-particular-row','Modules\Report\ReportAjaxController@remove_report_row')->name('employee.report.delete.row');

//for dates
Route::get('/get_week_date','Modules\Report\ReportController@get_week_date')->name('get.week.date');

//for history
Route::get('/history','Modules\History\HistoryController@report_history')->name('employee.history.report');
Route::get('/history-report-detail/{id?}','Modules\History\HistoryController@report_history_detail')->name('employee.history.report.detail');

//for submitting the week report
Route::post('/week-report-submit','Modules\Report\ReportController@submit_week_report')->name('employee.week.report.submit');

//for showing docs and image in modal ajax
Route::get('/show-all-docs','Modules\Report\ReportAjaxController@show_all_docs')->name('show.all.docs');

//for showing docs and image in modal ajax during add
Route::get('/show-all-docs-during-add','Modules\Report\ReportAjaxController@show_all_docs_add')->name('show.all.doc.during.add');


//for day date chnage 
Route::get('/day-date/{date?}','Modules\Report\ReportController@change_daye_date')->name('employee.day.date.change');
Route::get('/day-date-view/{date?}','Modules\Report\ReportController@change_daye_date_view')->name('employee.day.date.change.view');

Route::get('/policy','Modules\Content\ContentController@policy_show')->name('content.policy.show');

Route::get('/help','Modules\Content\ContentController@help')->name('content.help');
Route::get('/contact','Modules\Content\ContentController@contact_show')->name('content.contact.show');

//for remark 
Route::get('/remark','Modules\Content\ContentController@remark')->name('content.remark');
Route::post('/remark-submit','Modules\Content\ContentController@remark_submit')->name('content.remark.submit');


//for passowrd change for employee 
Route::get('/change-password','Modules\PasswordRequest\PasswordRequestController@password_view')->name('employee.password');
Route::get('/check-password','Modules\PasswordRequest\PasswordRequestController@check_password')->name('check.password');

// for user guide
Route::get('/user-guide','Modules\Content\ContentController@user_guide')->name('content.user.guide');


//for passowrd change for admin 
Route::any('/change-password-requests','Modules\PasswordRequest\PasswordRequestController@chnage_password_by_adminas')->name('admin.password.requests');

//FOR WEEKLY MEMOS
Route::any('/memo-list','Modules\Memo\MemoController@listMemo')->name('emp.memo.list');
Route::any('/view-memo/{id?}','Modules\Memo\MemoController@viewMemo')->name('emp.view.memo');

#All ADMINS ROUTES
Route::group(['middleware' => 'check.admins'], function() {  
    //for report
    Route::get('/reports','Modules\Admin\ReportController@report')->name('all.reports');
    Route::get('/report-detail/{id?}','Modules\Admin\ReportController@reportDetail')->name('view.report');
    Route::post('/add-comment','Modules\Admin\ReportController@addCommentExpenseItem')->name('expense.item.add.comment');
    Route::post('/reject-expense-report','Modules\Admin\ReportController@rejectExpenseReport')->name('reject.expense.item');
    Route::get('/approve-expense-report/{id?}','Modules\Admin\ReportController@approveExpenseReport')->name('approve.expense.report');


    //for receipt history 
    Route::get('/report-details/{id?}','Modules\Admin\HistoryController@reportDetail')->name('view.report.receipt');
    //for downloading all supporting docs and images 
    Route::get('/get-all-docs','Modules\Admin\ReportController@getAllDocuments')->name('get.all.docs');
    
    //for history 
    Route::get('manage-history','Modules\Admin\HistoryController@report')->name('manage.history');
    Route::get('/history-report/{id?}','Modules\Admin\HistoryController@reportDetail')->name('view.history.report');

    //for Memos
    Route::any('manage-memo','Modules\Admin\MemoController@listMemo')->name('manage.memo.list');
    Route::any('generate-memo/{id?}','Modules\Admin\MemoController@createMemo')->name('create.memo');
    Route::post('save-memo','Modules\Admin\MemoController@saveMemo')->name('save.memo');

    //for Upload Receipt
    Route::any('upload-receipt/{id?}','Modules\Admin\MemoController@createMemo')->name('upload.receipt');
    Route::any('save-receipt','Modules\Admin\MemoController@saveReceipt')->name('save.receipt');

    //for view receipt
    Route::any('view-receipt/{id?}','Modules\Admin\MemoController@createMemo')->name('view.receipt');
    Route::any('view-history-receipt/{id?}','Modules\Admin\MemoController@createMemo')->name('view.histroy.receipt');

    Route::any('approve-admin-hyd/{id?}/{type?}','Modules\Admin\MemoController@approve_hyd')->name('approve.report.hyd');

    Route::post('reject-hold-hyd','Modules\Admin\MemoController@reject_hold_hyd')->name('approve.hold.reject.hyd');

    //for policy content for admin head user_type = 'A'
    Route::get('/manage-contact','Modules\Content\ContentController@contact_edit_show')->name('content.contact.edit');
    Route::post('/manage-contact-submit','Modules\Content\ContentController@contact_submit')->name('content.contact.submit');
    Route::get('/manage-policy','Modules\Content\ContentController@policy')->name('content.policy'); 
    Route::get('/manage-policy-edit','Modules\Content\ContentController@policy_manage')->name('content.policy.edit');
    Route::get('/delete-policy/{id?}','Modules\Content\ContentController@policy_delete')->name('content.policy.delete');
    Route::post('/manage-policy-submit','Modules\Content\ContentController@policy_submit')->name('content.policy.submit');

    //for USer Guide 
    Route::get('/user-guide-list','Modules\Content\ContentController@user_guide_list')->name('content.user.guide.list');
    Route::get('/manage-user-guide','Modules\Content\ContentController@manage_user_guide')->name('content.manage.user.guide');
    Route::post('/user-guide-submit','Modules\Content\ContentController@user_guide_submit')->name('content.user.guide.submit');
    Route::get('/delete-user-guide/{id?}','Modules\Content\ContentController@delete_user_guide')->name('content.delete.user.guide');

    //for remark listing 
    Route::get('/remark_list','Modules\Content\ContentController@remark_list')->name('content.remark.list');

    //for generation of password  
    Route::get('/generate-password/{id?}','Modules\PasswordRequest\PasswordRequestController@password_generate')->name('admin.generate.password');
});

});

Route::post('/change-password-submit','Modules\PasswordRequest\PasswordRequestController@employee_change_pass')->name('employee.password.submit');








//Clear configurations:
Route::get('/config-clear', function() {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function() {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

//Clear configuration cache:
Route::get('/config-cache', function() {
    $status = Artisan::call('config:cache');
    return '<h1>Configurations cache cleared</h1>';
});