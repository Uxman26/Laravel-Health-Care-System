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
use App\Models\Memo;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function report(Request $request)
    {
        $data['reports'] = ExpenseMaster::with('getExpenseDetail','getUser');

        $approval_stage = "ACHY";
       
        if(@Auth::user()->user_type == 'AA'){
            $approval_stage = "ADAS";
        }
        if(@Auth::user()->user_type == 'A'){ 
            $approval_stage = "ADH";
        }
        if(@Auth::user()->user_type == 'HR'){
            $approval_stage = "HR";
        }
        if(@Auth::user()->user_type == 'ACA'){
            $approval_stage = "ACAS";
        }
        if(@Auth::user()->user_type == 'ACH'){
            $approval_stage = "ACH";
        }
        if(@Auth::user()->user_type == 'AHY'){
            $approval_stage = ["ACH"]; 
            $data['reports'] = $data['reports']->whereIn('approval_stage',@$approval_stage)->whereIn('status',['A','H'])
                                                ->whereHas('getMemo');
            // dd('123',$approval_stage );
        }else{
            
            $data['reports'] = $data['reports']->where('approval_stage',@$approval_stage)->where('status','S');
        }
        

        // $data['reports'] = $data['reports']->where('approval_stage',@$approval_stage);

        if(@$request->all()){

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

                })->orWhere('expense_unique_code',@$request->keyword);
            }
            
            if(@$request->date){ 
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
            $sheet->setCellValue('G1', 'Approval-Stage');
            $sheet->setCellValue('H1', 'Fees');
            $sheet->setCellValue('I1', 'Total');
            $sheet->setCellValue('J1', 'Status');
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
                $approval_stage = "Accountant Assistant";
                }elseif(@$val->approval_stage == 'ACH'){
                $approval_stage = "Accountant Head";
                }elseif(@$val->approval_stage == 'ACHY'){
                    $approval_stage = "Acountant HYD";
                }elseif(@$val->approval_stage == 'ADH'){
                $approval_stage = "Admin head";
                }else{
                    $approval_stage = "-";
                }        

                $sheet->setCellValue('A' . $rows, @$val->start_date ? date('d-m-Y',strtotime(@$val->start_date)) : '-');
                $sheet->setCellValue('B' . $rows, @$val->expense_unique_code ? @$val->expense_unique_code : '-');
                $sheet->setCellValue('C' . $rows, @$val->getUser->name);
                $sheet->setCellValue('D' . $rows, 'Weekly Expense Report');
                $sheet->setCellValue('E' . $rows, @$val->getUser->division);
                $sheet->setCellValue('F' . $rows, '-');
                $sheet->setCellValue('G' . $rows, @$approval_stage);
                $sheet->setCellValue('H' . $rows, '-');
                $sheet->setCellValue('I' . $rows, @$val->claimed_total);
                $sheet->setCellValue('J' . $rows, @$status);
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

        return view('modules.admin.reports')->with($data);
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
        if((@$user_type == 'AA' && @$approval_stage == "ADH") || (@$user_type == 'A' && @$approval_stage == "HR") || (@$user_type == 'HR' && @$approval_stage == "ACAS") || (@$user_type == 'ACA' && @$approval_stage == "ACH") || (@$user_type == 'ACH' && @$approval_stage == "ACHY")  || (@$data['expense']->status == 'A')){
            $approval_text = "Approved";
        }

        if($data['master']->status == "R"){
            $approval_text = "Rejected";
        }

        if($data['master']->status == "H"){
            $approval_text = "On-Hold";
        }
        

        //dd($data['all_docs']);
        $data['approval_text'] = $approval_text;

        //last report of that week
        $data['last_report']=ExpenseDetail::where('user_id',@$data['expense']->user_id)->where('expense_master_id',@$data['master']->id)->orderBy('id','desc')->first();

        if($data['expense'] && checkApproval(@$data['master']->id)){
           
            return view('modules.admin.report_detail')->with($data);
        }else{
            return redirect()->route('all.reports')->with('error','Something went wrong!'); 
        }
    }

    public function getAllDocuments(Request $request){
        //dd(@$request->all());
        $id=@$request->id;

        $response['result']['img_status'] = (!$id) ? 'Failed' : 'OK';

        $item_ids = ExpenseItem::where('expense_detail_id',@$id)->pluck('id')->toArray();
        $all_doc = ExpenseItemDoc::with('getExpenseItem')->whereIn('expense_item_id',@$item_ids)->get();

        $response['result']['img_doc']=$all_doc;
        return response()->json($response);
    }

    public function addCommentExpenseItem(Request $request)
    {
        // dd(@$request->all());

        // if(empty(@$request->approved_gst_amount) || empty(@$request->comment)){
        //     $response['status'] = "Failed";
        //     $response['error'] = "Something went wrong!";
        //     return response()->json($response);
        // }
        $request->validate([            
            'approved_gst_amount'   => 'required',
            'comment'           => 'required',        
        ]);

        $item = ExpenseItem::where('id',@$request->item_id)->where('expense_detail_id',@$request->expense_detail_id)->first();

        if(!$item)
        {
            return redirect()->back()->with('error','Something went wrong');
        }

        if($item->gst_amount > 0 && (@$request->approved_gst_amount > $item->gst_amount)){
            return redirect()->back()->with('error','Approved Gst amount cannot be greater than claimed Gst amount.');
        }

        if(@$request->approved_gst_amount != null && @$request->gst_available){ 
            $request->validate([            
                'approved_gst_amount'   => 'required',
                'approved_base_amount'  => 'required',
                'comment'           => 'required',        
            ]);
           
            $up['approved_gst_amount'] = @$request->approved_gst_amount;
            $up['approved_amount'] = floatval(@$request->approved_base_amount) + floatval(@$request->approved_gst_amount) ;
            // dd(floatval(@$request->approved_base_amount),floatval(@$request->approved_gst_amount),intval(@$request->approved_base_amount) + intval(@$item->approved_gst_amount));
        }else{
           
            $up['approved_gst_amount'] = @$request->approved_gst_amount; 
                $up['approved_amount'] =@$request->approved_gst_amount;
           
            // if(@$item->type == 'B' || @$item->type == 'LU' || @$item->type == 'D')
            // {
                
            //     if(intval(@$request->approved_gst_amount) == 0)
            //     {
            //         // dd('123');
            //         $up['approved_gst_amount'] = @$request->approved_gst_amount; 
            //         $up['approved_amount'] =@$request->approved_gst_amount;
            //     }else{
                    
            //         $up['approved_gst_amount'] = @$request->approved_gst_amount; 
            //         $up['approved_amount'] =@$request->approved_gst_amount;
            //     }
               
            // }else{
            //     $up['approved_gst_amount'] = @$request->approved_gst_amount; 
            //     $up['approved_amount'] =@$request->approved_gst_amount;
            // }
            
        }
        $up['comment']         = @$request->comment;
        // dd($up,$request->all());

        $res = ExpenseItem::where('id',@$request->item_id)->where('expense_detail_id',@$request->expense_detail_id)->update($up);

        $updateApprovedAmount = $this->updateApprovedAmount(@$request->expense_detail_id, @$request->item_id);

        $item_type = $this->itemType(@$item->type);

        return redirect()->route('view.report',[@$request->expense_detail_id,$item_type])->with('success','Comment added successfully.');
        //$response['item_type'] = @$item_type;
        //$response['status'] = "Success";
        //return response()->json($response);
    }

    public function itemType($type = null){
        $item = "#";
        if($type == 'R'){
            $item = "#rail_box";
        }
        if($type == 'T'){
            $item = "#taxi_box";
        }
        if($type == 'H'){
            $item = "#hotel_box";
        }
        if($type == 'L'){
            $item = "#laundry_box";
        }
        if($type == 'B'){
            $item = "#breakfast_box";
        }
        if($type == 'LU'){
            $item = "#lunch_box";
        }
        if($type == 'D'){
            $item = "#dinner_box";
        }
        if($type == 'P'){
            $item = "#phone_box";
        }
        if($type == 'LC'){
            $item = "#LC_box";
        }
        if($type == 'M'){
            $item = "#misc_box";
        }
        return $item;
    }


    public function updateApprovedAmount($expense_detail_id = null, $expense_item_id = null)
    {
        $expenseDetail = ExpenseDetail::where('id',@$expense_detail_id)->first();
        $master_id = @$expenseDetail->expense_master_id;
        $items = ExpenseItem::where('expense_detail_id',@$expense_detail_id)->get();

        #all items approved amount
        $total_approved_amt = 0;
        // $test=array();
        if(!empty(@$items)){
            foreach(@$items as $item){
                if(@$item->approved_amount > 0 || @$item->comment){
                    // array_push($test,$item->approved_amount);
                    $total_approved_amt += $item->approved_amount;
                }else{
                    // array_push($test,$item->total);
                    if(@$item->type == 'B' || @$item->type == 'LU' || @$item->type == 'D')
                    {
                        if(@$item->comment)
                        {
                            $total_approved_amt += $item->approved_amount;
                        }else{
                            $total_approved_amt += $item->total;
                        }
                        
                    }else{
                        $total_approved_amt += $item->total;
                    }
                    
                }
            }
        }
        // dd($total_approved_amt,$test);

        $up['days_approved'] = $total_approved_amt; 
        $up['is_admin_commented'] = 'Y';
        ExpenseDetail::where('id',@$expense_detail_id)->update($up);

        #all dates expense approved amount
        $sumTotal = 0;

        #get all dates detail
        $weekData = ExpenseDetail::where('expense_master_id',@$master_id)->get();
        if(!empty(@$weekData)){
            foreach(@$weekData as $data){
                if(@$data->days_approved > 0 || @$data->is_admin_commented == 'Y'){
                    $sumTotal += $data->days_approved;
                }else{
                    $sumTotal += $data->days_total;
                }
            }
        }

        $upMaster['approved_total'] =  @$sumTotal;
        ExpenseMaster::where('id',@$master_id)->where('user_id',@$expenseDetail->user_id)->update($upMaster);

        return true;

    }

    public function rejectExpenseReport(Request $request)
    {
        $request->validate([            
            'comment'           => 'required',        
        ]);

        $expense = ExpenseDetail::where('id',@$request->expense_detail_id)->first();

        if(!$expense)
        {
            return redirect()->back()->with('error','Something went wrong');
        }

        $up['status'] = 'R';
        //$up['approval_stage'] = "NA";
        ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($up);

        if(@Auth::user()->user_type == 'AA'){ 
            $user_type = "ADAS";
        }
        if(@Auth::user()->user_type == 'A'){
            $user_type = "ADH";
        }
        if(@Auth::user()->user_type == 'HR'){
            $user_type = "HR";
        }
        if(@Auth::user()->user_type == 'ACA'){
            $user_type = "ACAS";
        }
        if(@Auth::user()->user_type == 'ACH'){
            $user_type = "ACH";
        }
        if(@Auth::user()->user_type == 'AHY'){
            $user_type = "ACHY";
        }
        $up['rejected_by'] = @$user_type;
        $up['is_editable'] = 'N';
        ExpenseMaster::where('id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($up);

        $upComment['remark'] = @$request->comment;
        // ExpenseDetail::where('id',@$request->expense_detail_id)->update($upComment);
        ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->update($upComment);

        return redirect()->route('all.reports')->with('success','Expense report rejected successfully.');
    }
 
    public function approveExpenseReport(Request $request, $id=null)
    {
        $expense = ExpenseDetail::where('id',@$request->id)->first();

        if(!$expense)
        {
            return redirect()->back()->with('error','Something went wrong');
        }
        
        #count all days report
        $expenseAllDays = ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->count();

        if(@Auth::user()->user_type == 'ACH' && @$expense->approval_stage == "ACH"){

            $upData['status'] = 'A'; 
            // $upData['is_admin_commented'] = 'Y';
            //ExpenseDetail::where('id',@$request->id)->where('expense_master_id',@$expense->expense_master_id)->update($upData);
            ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->update($upData);

            #count all days report approval stage is ACHY
            $expenseAllAproval = ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->where('status','A')->where('approval_stage','ACH')->count();

            if($expenseAllDays == $expenseAllAproval){
                
                $up['status'] = 'A';
                ExpenseMaster::where('id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($up);
                ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->update($up);

                
                return redirect()->back()->with('success','Expense report approved successfully.');
            }


            //return redirect()->back()->with('success','Expense report approved successfully.');
            
        }else{

            if(@Auth::user()->user_type == 'AA'){ 
                $up['approval_stage'] = "ADH";
            }
            if(@Auth::user()->user_type == 'A'){
                $up['approval_stage'] = "HR";
            }
            if(@Auth::user()->user_type == 'HR'){
                $up['approval_stage'] = "ACAS";
            }
            if(@Auth::user()->user_type == 'ACA'){
                $up['approval_stage'] = "ACH";
                $chk_memo=Memo::where('expense_master_id',@$expense->expense_master_id)->first();
                if($chk_memo){
                    Memo::where('expense_master_id',@$expense->expense_master_id)->delete();
                   
                }

                $updts['rejected_by']=null;
                ExpenseMaster::where('id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($updts);
               
            }
            // if(@Auth::user()->user_type == 'ACH'){
            //     $up['approval_stage'] = "ACHY";
            // }
            
            $approval_stage = $up['approval_stage'];
            //ExpenseDetail::where('id',@$request->id)->update($up);
            ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->update($up);

            #count all days report approval stage
            $expenseAllAproval = ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->where('approval_stage',$approval_stage)->count();
            // if($expenseAllDays == $expenseAllAproval){
            //     $upD['approval_stage'] = $approval_stage;
            //     ExpenseMaster::where('id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($upD);
            // }
            ExpenseMaster::where('id',@$expense->expense_master_id)->where('user_id',@$expense->user_id)->update($up);

            // $upData['is_admin_commented'] = 'Y';
            // ExpenseDetail::where('expense_master_id',@$expense->expense_master_id)->update($upData);
        }

        return redirect()->back()->with('success','Expense report approved successfully.');
    }
}
