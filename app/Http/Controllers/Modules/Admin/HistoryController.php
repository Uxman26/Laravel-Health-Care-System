<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseDetail;
use App\Models\ExpenseItem;
use App\Models\ExpenseItemDoc;
use App\Models\ExpenseMaster;
use App\User;
use Illuminate\Support\Facades\Auth;
#For Export To Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Excel;
use URL;

class HistoryController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function report(Request $request)
    {
        $data['reports'] = ExpenseMaster::with('getExpenseDetail','getUser')->where('status','!=','D');

        $approval_stage = ["ACHY"];
        if(@Auth::user()->user_type == 'AA'){
            $approval_stage = ["ADH","HR","ACAS","ACH","ACHY"];
        }
        if(@Auth::user()->user_type == 'A'){
            $approval_stage = ["HR","ACAS","ACH","ACHY"];
        }
        if(@Auth::user()->user_type == 'HR'){
            $approval_stage = ["ACAS","ACH","ACHY"];
        }
        if(@Auth::user()->user_type == 'ACA'){
            $approval_stage = ["ACH","ACHY"];
        }
        if(@Auth::user()->user_type == 'ACH'){
            $approval_stage = ["ACH","ACHY"];
        }

        $data['reports'] = $data['reports']->whereIn('approval_stage',@$approval_stage)->where('status','!=','R');

        if(@Auth::user()->user_type == 'AHY' ){
            $data['reports'] = $data['reports']->whereIn('approval_stage',@$approval_stage)->where('status','A');
            $data['reports'] = $data['reports']->whereHas('getMemo',function($q) use($request){
                $q->where('status','C');

            });
        }

        if(@$request->all()){
            //dd(@$request->all());
            if(@$request->division){
                $data['reports'] = $data['reports']->whereHas('getUser',function($q) use($request){
                    $q->where('division',$request->division);

                });
            }

            if(@$request->keyword){ 

                $data['reports'] = $data['reports']->whereHas('getUser',function($q) use($request){

                    $q->where('name','like','%'.$request->keyword.'%');
                    $q->orWhere('mobile','like','%'.$request->keyword.'%');
                    $q->orWhere('empID','like','%'.$request->keyword.'%');
                    $q->orWhere('designation','like','%'.$request->keyword.'%');
                    $q->orWhere('department','like','%'.$request->keyword.'%');
                    $q->orWhere('division','like','%'.$request->keyword.'%');

                })->orWhere('expense_unique_code','like','%'.$request->keyword.'%');
            }
            
            if(@$request->date){ 
                // dd(date('Y-m-d',strtotime($request->date)));
                $data['reports'] = $data['reports']->whereDate('start_date','<=',date('Y-m-d',strtotime($request->date)))->whereDate('end_date','>=',date('Y-m-d',strtotime($request->date)));
            }
                
        }

        if(@$request->Export){
            $data['reports'] = $data['reports']->orderBy('id','desc')->get();
            $reportData = $data['reports'];
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Date');
            $sheet->setCellValue('B1', 'Reference No');
            $sheet->setCellValue('C1', 'Cheque in Favour Of');
            $sheet->setCellValue('D1', 'Narration');
            $sheet->setCellValue('E1', 'Division');
            $sheet->setCellValue('F1', 'PO.NO.');
            $sheet->setCellValue('G1', 'Fees');
            $sheet->setCellValue('H1', 'Total');
            $sheet->setCellValue('I1', 'Current Status');
            $rows = 2;
            $type = 'xls';

            foreach ($reportData as $key=>$val) {

                if(@$val->status == 'S'){
                    $status = "In Progress";
                }elseif(@$val->status == 'R'){
                    $status = "Rejected";
                }elseif(@$val->status == 'A'){
                    $status = "Approved";
                }else{
                    $status = "-";
                } 

                #Approval stage
                if(@$val->approval_stage == 'NA'){
                $approval_stage = "Non-approval Stage";
                }elseif(@$val->approval_stage == 'ADAS'){
                $approval_stage = "Admin Assistant";
                }elseif(@$val->approval_stage == 'HR'){
                $approval_stage = "HR";
                }elseif(@$val->approval_stage == 'ACAS'){
                $approval_stage = "Account Assistant";
                }elseif(@$val->approval_stage == 'ACH'){
                $approval_stage = "Account Head";
                }elseif(@$val->approval_stage == 'ACHY' && @$val->status == 'A'){
                    $approval_stage = "Approved";
                }elseif(@$val->approval_stage == 'ACHY'){
                    $approval_stage = "Account HYD";
                }elseif(@$val->approval_stage == 'ADH'){
                $approval_stage = "Admin head";
                }else{
                    $approval_stage = "-";
                }    

                $total_amt = (@$val->approved_total > 0) ? @$val->approved_total : @$val->claimed_total;

                $sheet->setCellValue('A' . $rows, @$val->start_date ? date('d-m-Y',strtotime(@$val->start_date)) : '-');
                $sheet->setCellValue('B' . $rows, @$val->expense_unique_code ? @$val->expense_unique_code : '-');
                $sheet->setCellValue('C' . $rows, @$val->getUser->name);
                $sheet->setCellValue('D' . $rows, 'Weekly Expense Report');
                $sheet->setCellValue('E' . $rows, @$val->getUser->division);
                $sheet->setCellValue('F' . $rows, '-');
                $sheet->setCellValue('G' . $rows, '-');
                $sheet->setCellValue('H' . $rows, @$total_amt);
                $sheet->setCellValue('I' . $rows, @$approval_stage);
                $rows++;
            }
            $fileName = "Expense-Report".count($reportData)."." . $type;
            if ($type == 'xls') {
                $writer = new Xls($spreadsheet);
            } else if ($type == 'csv') {
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            }
            header("Content-Type: application/vnd.ms-excel");
            header("Content-type: application/csv");
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            return redirect()->back();
            exit();
        }

        $data['key'] = @$request->all();
        $data['reports'] = $data['reports']->orderBy('id','desc')->paginate(20);
        $data['divisions'] = User::select('division')->whereNotNull('division')->distinct()->get();

        return view('modules.admin.history')->with($data);
    }

    public function reportDetail(Request $request, $id=null)
    {
        $data['expense']=ExpenseDetail::where('id',@$id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->first();

        if(!$data['expense'])
        {
            return redirect()->back()->with('error','Expense report not found!!');
        }

        $data['master']=ExpenseMaster::with('getExpenseDetail','getUser')->where('user_id',@$data['expense']->user_id)->where('id',@$data['expense']->expense_master_id)->with('getExpenseDetail')->first();

        $data['allDates'] = ExpenseDetail::where('user_id',@$data['expense']->user_id)->where('expense_master_id',@$data['master']->id)->get();

        $approval_stage = @$data['expense']->approval_stage;
        $user_type = @Auth::user()->user_type;

        $approval_text = "In Progress";
        if((@$user_type == 'AA' && @$approval_stage == "ADH") || (@$user_type == 'A' && @$approval_stage == "HR") || (@$user_type == 'HR' && @$approval_stage == "ACAS") || (@$user_type == 'ACA' && @$approval_stage == "ACH") || (@$user_type == 'ACH' && @$approval_stage == "ACHY") ||(@$user_type == 'AHY' && @$approval_stage == "ACHY") || (@$data['master']->status == 'A')){
            $approval_text = "Approved";
        }
        

        //dd($approval_stage, $user_type, @$data['expense']->status);
        $data['approval_text'] = $approval_text;
        
        if($data['expense'] && checkApproval(@$data['master']->id)){
            return view('modules.admin.history_report_detail')->with($data);
        }else{
            return redirect()->route('all.reports')->with('error','Something went wrong!');
        }
    }

}
