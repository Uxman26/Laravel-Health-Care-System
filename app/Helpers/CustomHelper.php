<?php

use App\Http\Controllers\Modules\Message\MessageController;
use App\User; 
use App\Models\ExpenseMaster;
use App\Models\Memo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

function checkApproval($report_id=null)
{
    $report = ExpenseMaster::where('id',@$report_id)->first();

    $appr_stage = @$report->approval_stage;

    //Admin Assistant
    if(@Auth::user()->user_type == 'AA' && (@$appr_stage == "ADAS" || @$appr_stage == "ADH" || @$appr_stage == "HR" || @$appr_stage == "ACAS" || @$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    //Admin Head
    if(@Auth::user()->user_type == 'A' && (@$appr_stage == "ADH" || @$appr_stage == "HR" || @$appr_stage == "ACAS" || @$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    //HR
    if(@Auth::user()->user_type == 'HR' && (@$appr_stage == "HR" || @$appr_stage == "ACAS" || @$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    //Account Assistant
    if(@Auth::user()->user_type == 'ACA' && (@$appr_stage == "ACAS" || @$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    //Account Head
    if(@Auth::user()->user_type == 'ACH' && (@$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    // Account Hyd
    if(@Auth::user()->user_type == 'AHY' && (@$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }

    return false;

}

function checkApprovalMemo($report_id=null)
{
    $report = ExpenseMaster::where('id',@$report_id)->first();
    
    $appr_stage = @$report->approval_stage;
     //Account Head
    
     if(@Auth::user()->user_type == 'A' && (@$appr_stage == "ADH" || @$appr_stage == "HR" || @$appr_stage == "ACAS" || @$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
    }
    
    //Account Hyd
    if(@Auth::user()->user_type == 'AHY' && (@$appr_stage == "ACH" || @$appr_stage == "ACHY")){
        return true;
       
    }
    
    return false;

}

function checkUserEditAccess($report_id=null)
{
    $report = ExpenseMaster::where('id',@$report_id)->first();
    $is_memo = Memo::where('expense_master_id',@$report_id)->first();

    $appr_stage = @$report->approval_stage; 

    //Admin Assistant
    if(@Auth::user()->user_type == 'AA' && @$appr_stage == "ADAS"){
        return true;
    }

    //Admin Head
    if(@Auth::user()->user_type == 'A' && @$appr_stage == "ADH"){
        return true;
    }

    //HR
    if(@Auth::user()->user_type == 'HR' && @$appr_stage == "HR"){
        return true;
    }

    //Account Assistant
    if(@Auth::user()->user_type == 'ACA' && @$appr_stage == "ACAS"){
        return true;
    }

    //Account Head
    if(@Auth::user()->user_type == 'ACH' && @$appr_stage == "ACH"){
        
        if(@$report->status == 'A' || $is_memo)
        {
            return false;
        }else{
            return true;
        }
    }

    //Account Hyd
    if(@Auth::user()->user_type == 'AHY' && @$appr_stage == "ACHY"){
        return false;
        // if(@$report->status == 'A' || $is_memo)
        // {
        //     return false;
        // }else{
        //     return true;
        // }
        
    }
    

    return false;

}