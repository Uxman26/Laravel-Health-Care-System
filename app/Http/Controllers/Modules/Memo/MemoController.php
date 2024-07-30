<?php

namespace App\Http\Controllers\Modules\Memo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseDetail;
use App\Models\ExpenseItem;
use App\Models\ExpenseItemDoc;
use App\Models\ExpenseMaster;
use App\Models\Memo;
use App\User;
use Illuminate\Support\Facades\Auth; 
#For Export To Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Excel;
use URL;
use Storage;

class MemoController extends Controller
{
      public function __construct()
    {
        $this->middleware(function ($request, $next) {      
            if(in_array(auth()->user()->user_type,['E'])){

                return $next($request);
            }
            else{
              return redirect()->back();
            }
            
        });
    }

    /**
     *   Method      : for weekly memos
     *   Description :  for weekly memos
     *   Author      : Neha
     *   Date        : 2023-APR-28
     **/

    public function listMemo(Request $request)
    {
        $report_ids = ExpenseMaster::where('user_id',auth()->user()->id)->where('status','A')->pluck('id')->toArray();
        $expense_master_ids = Memo::whereIn('expense_master_id',@$report_ids)->pluck('expense_master_id')->toArray();

        $data['reports'] = ExpenseMaster::with('getExpenseDetail','getUser','getMemo')->where('user_id',auth()->user()->id)->whereIn('id',@$expense_master_ids)->where('status','A');
        if($request->all())
        {
            if(@$request->date)
            {
                $data['reports'] = $data['reports']->whereDate('start_date','<=',date('Y-m-d',strtotime($request->date)))->whereDate('end_date','>=',date('Y-m-d',strtotime($request->date)));
            }
        }
        $data['key'] = @$request->all(); 
        $data['reports'] = $data['reports']->orderBy('id','desc')->paginate(10);

        return view('modules.memo.memo_list')->with($data);
    }

    public function viewMemo(Request $request, $id=null)
    {
        $data['master'] = ExpenseMaster::with('getExpenseDetail','getExpenseDetailMany','getUser')->where('id',@$id)->where('status','A')->first();
        $data['admin_head'] = User::where('user_type','A')->where('status','A')->first();
        
        if(!$data['master'])
        {
            return redirect()->back()->with('error','Expense report not found!!');
        }
        $data['memo'] = Memo::where('expense_master_id',@$id)->first();

        return view('modules.memo.view_memo')->with($data);
    }

}
