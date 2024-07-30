<?php

use Illuminate\Support\Facades\Route;

// Dashboard
//Route::get('/', 'HomeController@index')->name('home');
Route::group(['namespace' => 'Admin'], function() {


      // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Passwords 
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('password/reset/{token?}/{id?}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::group(['middleware' => 'admin.auth'], function () {
    
          //Dashboard
        Route::get('/dashboard', 'Modules\Dashboard\DashboardController@dashboard')->name('admin.dashboard');
        Route::any('/change-password', 'Modules\Dashboard\DashboardController@changePassword')->name('admin.change.password');
        Route::get('/', 'Modules\Dashboard\DashboardController@dashboard');
        Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');


        Route::group(['middleware' => 'admin.auth.master'], function () {
          
            //for subadmin management
            Route::any('/subadmin-manage', 'Modules\Subadmin\SubadminController@subadminManage')->name('admin.subadmin.manage');
            Route::get('/create-subadmin/{id?}', 'Modules\Subadmin\SubadminController@createSubadmin')->name('admin.create.subadmin');
            Route::post('/create-subadmin-save/{id?}', 'Modules\Subadmin\SubadminController@createSubadminSave')->name('admin.subadmin.save');
            Route::get('/subadmin-status-change/{id}', 'Modules\Subadmin\SubadminController@statusChange')->name('admin.subadmin.status.change');
            Route::get('/subadmin-view/{id}', 'Modules\Subadmin\SubadminController@viewSubadmin')->name('admin.subadmin.view');
            Route::get('/subadmin-delete/{id}', 'Modules\Subadmin\SubadminController@subadminDelete')->name('admin.subadmin.delete');
            Route::post('/subadmin-email-check', 'Modules\Subadmin\SubadminController@subadminEmailCheck')->name('admin.subadmin.email.check');
            
             //for sales employees management 
         Route::any('/manage-sales-employee', 'Modules\Sales\EmployeeController@employeeManage')->name('admin.sales.emp.manage');
         Route::get('/create-sales-employee/{id?}', 'Modules\Sales\EmployeeController@createEmployee')->name('admin.create.sales.employee');
         Route::post('/sales-employee-save/{id?}', 'Modules\Sales\EmployeeController@createEmployeeSave')->name('admin.employee.save');
         Route::get('/employee-view/{id}', 'Modules\Sales\EmployeeController@viewEmployee')->name('admin.employee.view');
         Route::get('/employee-delete/{id}', 'Modules\Sales\EmployeeController@employeeDelete')->name('admin.employee.delete');
         Route::get('/employee-status-change/{id}', 'Modules\Sales\EmployeeController@statusChange')->name('admin.employee.status.change');


        });

        //sales
        Route::get('/profile-sales-employee/{id?}', 'Modules\Sales\EmployeeController@createEmployee')->name('admin.profile.sales.employee');
        Route::post('/profile-employee-update/{id?}', 'Modules\Sales\EmployeeController@updateProfile')->name('admin.employee.update');

         //for customers management 
         Route::any('/manage-customers', 'Modules\Customers\CustomerController@customerManage')->name('admin.manage.customers');
         Route::get('/customer-view/{id}', 'Modules\Customers\CustomerController@viewCustomer')->name('admin.customer.view');
         Route::get('/customer-delete/{id}', 'Modules\Customers\CustomerController@deleteCustomer')->name('admin.customer.delete');
         Route::get('/customer-edit/{id}', 'Modules\Customers\CustomerController@updateCustomer')->name('admin.customer.edit');
         Route::post('/customer-save/{id?}', 'Modules\Customers\CustomerController@customerSave')->name('admin.customer.save');

         //for getting state according to country 
         Route::get('/get-state-admin', 'Modules\Customers\CustomerController@get_state_admin')->name('admin.get.state');

        
         
         //for Car Make management
         Route::get('/manage-car-make/{id?}', 'Modules\Car\CarMakeController@list')->name('admin.car.make');
         Route::post('car-make-save/{id?}', 'Modules\Car\CarMakeController@makeSave')->name('admin.make.save');
         Route::get('/make-delete/{id}', 'Modules\Car\CarMakeController@delete')->name('admin.make.delete');
         
         //for Car Model management
         Route::any('/manage-car-model/{id?}', 'Modules\Car\CarModelController@list')->name('admin.car.model');
         Route::post('car-model-save/{id?}', 'Modules\Car\CarModelController@modelSave')->name('admin.model.save');
         Route::get('/model-delete/{id}', 'Modules\Car\CarModelController@delete')->name('admin.model.delete');
         
         //for Car Model management
         Route::get('/manage-cars', 'Modules\Car\CarController@list')->name('admin.car.list');
         Route::get('/view-car-details/{id?}', 'Modules\Car\CarController@viewCarDetail')->name('admin.view.car');
         Route::get('/add-car-step1/{id?}', 'Modules\Car\CarController@addCarStep1')->name('admin.add.car.step1');
         Route::post('/save-car-step1', 'Modules\Car\CarController@saveCarStep1')->name('admin.save.car.step1');
         Route::get('/car-delete/{id}', 'Modules\Car\CarController@deleteCar')->name('admin.car.delete');

         //for checking the make and model repeatation
         Route::any('/get-car-make-model', 'Modules\Car\CarController@get_make_model')->name('admin.get.make.model');

         Route::get('/add-car-step2/{id?}/{priceid?}', 'Modules\Car\CarController@addCarStep2')->name('admin.add.car.step2');
         Route::post('/save-car-step2', 'Modules\Car\CarController@saveCarStep2')->name('admin.save.car.step2');
         Route::get('/car-price-delete/{id}', 'Modules\Car\CarController@deletePrice')->name('admin.carprice.delete');

         Route::get('/add-car-step3/{id?}/{img_master_id?}', 'Modules\Car\CarImagesController@addCarStep3')->name('admin.add.car.step3');
         Route::post('/save-car-step3', 'Modules\Car\CarImagesController@saveCarStep3')->name('admin.save.car.step3');
         Route::get('/car-image-delete/{id}/{img_id?}', 'Modules\Car\CarImagesController@deleteImage')->name('admin.carimg.delete');
         Route::get('/car-image-remove/{id}/{img_id?}', 'Modules\Car\CarImagesController@removeImage')->name('admin.carimg.remove');

         Route::get('/add-car-step4/{id?}/{addonid?}', 'Modules\Car\CarController@addCarStep4')->name('admin.add.car.step4');
         Route::post('/save-car-step4', 'Modules\Car\CarController@saveCarStep4')->name('admin.save.car.step4');
         Route::get('/car-addon-delete/{id}', 'Modules\Car\CarController@deleteAddon')->name('admin.caraddon.delete');

         Route::get('/add-car-step5/{id?}/{img_master_id?}', 'Modules\Car\CarImagesController@addCarStep5')->name('admin.add.car.step5');
         Route::post('/save-car-step5', 'Modules\Car\CarImagesController@saveCarStep5')->name('admin.save.car.step5');
         Route::get('/car-3dimage-delete/{id}/{img_id?}', 'Modules\Car\CarImagesController@delete3dImage')->name('admin.car3dimg.delete');

         //submit car
         Route::get('/submit-car/{id?}', 'Modules\Car\CarController@submitCar')->name('admin.submit.car');
         
         Route::post('get-models','Modules\Car\AjaxController@getModels')->name('admin.get.models');
         Route::post('get-colors','Modules\Car\AjaxController@getColors')->name('admin.get.colors');
         Route::post('get-wheels','Modules\Car\AjaxController@getWheels')->name('admin.get.wheels');

         //for manage orders
         Route::any('/manage-bookings', 'Modules\Order\OrderController@manage_order')->name('admin.manage.booking');
         Route::get('/booking-details/{id?}', 'Modules\Order\OrderController@order_detail')->name('admin.booking.detail');
         Route::get('/booking-status/{status?}/{id?}', 'Modules\Order\OrderController@status')->name('admin.booking.status');

         //for enquiry management
        Route::get('/manage-enquiry', 'Modules\Enquiry\EnquiryController@enquiryManage')->name('admin.manage.enquiry');
        Route::get('/view-enquiry/{id}', 'Modules\Enquiry\EnquiryController@viewEnquiry')->name('admin.enquiry.view');
        Route::get('/my-leads', 'Modules\Enquiry\EnquiryController@myLeads')->name('admin.my.leads')->middleware('admin.auth.sales');
        Route::post('/save-notes', 'Modules\Enquiry\EnquiryController@saveNote')->name('add.enquiry.notes');
        Route::get('/add-new-lead', 'Modules\Enquiry\EnquiryController@addNewLead')->name('admin.add.new.lead')->middleware('admin.auth.sales');
        Route::post('/save-new-lead', 'Modules\Enquiry\EnquiryController@saveLead')->name('admin.save.new.lead')->middleware('admin.auth.sales');
        Route::get('/enquiry-status-change/{id}/{status?}', 'Modules\Enquiry\EnquiryController@statusChange')->name('admin.enquiry.status.change');
        Route::get('/car-details/{id?}', 'Modules\Enquiry\EnquiryController@viewCarDetail')->name('admin.view.car.detail');
    });       
    
});

