<?php

namespace App\Http\Controllers\Modules\Admin;

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
            if(in_array(auth()->user()->user_type,['A','AHY'])){

                return $next($request);
            }
            else{
              return redirect()->route('all.reports');
            }
            
        });
    }

    /**
     *   Method      : for generating memo
     *   Description :  for generating memo
     *   Author      : Neha
     *   Date        : 2023-APR-20
     **/

    public function listMemo(Request $request)
    {
        $data['reports'] = ExpenseMaster::with('getExpenseDetail','getUser','getMemo')->whereIn('status',['A','H','R']);

        #if logged in user is Account Hyderabad then get only those memos with status Initiated or completed
        if(auth()->user()->user_type == 'AHY'){
            $report_ids = ExpenseMaster::whereIn('status',['A','H'])->where('approval_stage','ACHY')->pluck('id')->toArray();
            $expense_master_ids = Memo::whereIn('expense_master_id',@$report_ids)->where('status','I')->pluck('expense_master_id')->toArray();
            $data['reports'] = $data['reports']->whereIn('id',@$expense_master_ids); 
        }

        

        if(@$request->all()){

            if(@$request->keyword){

                $data['reports'] = $data['reports']->whereHas('getUser',function($q) use($request){

                    $q->where('name','like','%'.$request->keyword.'%');
                    $q->orWhere('mobile','like','%'.$request->keyword.'%');
                    $q->orWhere('empID','like','%'.$request->keyword.'%');
                    $q->orWhere('designation','like','%'.$request->keyword.'%');
                    $q->orWhere('department','like','%'.$request->keyword.'%');
                    $q->orWhere('division','like','%'.$request->keyword.'%');

                });
            }

            if(@$request->division){
                $data['reports'] = $data['reports']->whereHas('getUser',function($q) use($request){
                    $q->where('division',$request->division);

                });
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
            $sheet->setCellValue('G1', 'Fees');
            $sheet->setCellValue('H1', 'Total');
            $sheet->setCellValue('I1', 'Status');
            $rows = 2;
            $type = 'xls';

            foreach ($reportData as $key=>$val) {

                // if(@$val->status == 'S'){
                //     $status = "Submitted";
                // }elseif(@$val->status == 'R'){
                //     $status = "Rejected";
                // }elseif(@$val->status == 'A'){
                //     $status = "Approved";
                // }else{
                //     $status = "-";
                // } 

                if(@Auth::user()->user_type == 'A'){

                    if(@$val->getMemo){
                        $status = "Acct Hyd.";
                    }else{
                        $status = "-";
                    } 

                }else{

                    if(@$val->getMemo->status == 'I'){
                        $status = "Intiated";
                    }elseif(@$val->getMemo->status == 'C'){
                        $status = "Completed";
                    }else{
                        $status = "-";
                    } 

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
                $sheet->setCellValue('I' . $rows, @$status);
                $rows++;
            }
            $fileName = "Memo-List".count($reportData)."." . $type;
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

        return view('modules.admin.memo_list')->with($data);
    }

    public function createMemo(Request $request, $id=null)
    {
        $data['master'] = ExpenseMaster::with('getExpenseDetail','getExpenseDetailMany','getUser')->where('id',@$id)->whereIn('status',['A','H','R'])->first();
        $data['admin_head'] = User::where('user_type','A')->where('status','A')->first();
        
        if(!$data['master'])
        {
            return redirect()->back()->with('error','Expense report not found!!');
        }
        $data['memo'] = Memo::where('expense_master_id',@$id)->first();

        return view('modules.admin.memo_create')->with($data);
    }

    public function saveMemo(Request $request)
    {
        //dd($request->all());
        $request->validate([            
            'remark' => 'required|max:500',        
            //'signature_image' => 'required',        
            ],
        );
        
        if(@$request->signature_image){
            $Image = @$request->signature_image;
            $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
            Storage::putFileAs('public/images/signature_image/', $Image, $filename);
            $image_name = $filename;  
            //$input['signature'] = $image_name;
            $inSig['signature_image'] = $image_name;
            User::where('user_type','A')->update($inSig);            
        }
        $chk_memo=Memo::where('expense_master_id',$request->expense_master_id)->first();

      

        $input['expense_master_id'] = $request->expense_master_id;
        $input['remark'] = $request->remark;

        if($chk_memo){
            $result = Memo::where('id',@$chk_memo->id)->where('expense_master_id',@$request->expense_master_id)->update($input);
            return redirect()->back()->with('success','Memo successfully generated.');
        }
        $result = Memo::create($input);

        return redirect()->back()->with('success','Memo successfully generated.');
    }

    public function saveReceipt(Request $request)
    {
        //dd($request->all());
        $request->validate([            
            'remark' => 'required|max:500',        
            'transaction_id' => 'required',        
            'receipt_image' => 'required',        
            ],
        );
   
        if(@$request->id && @$request->expense_master_id){

            if(@$request->receipt_image){ 
                $Image = @$request->receipt_image;
                $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
                Storage::putFileAs('public/images/receipts/', $Image, $filename);
                $image_name = $filename;  
                //$input['signature'] = $image_name;
                $upd['transaction_receipt'] = $image_name;           
            }

            $upd['transaction_id']      = $request->transaction_id;
            $upd['transaction_remark']  = $request->remark;
            $upd['status']              = 'C';

            $up_sta['approval_stage']='ACHY';
            ExpenseMaster::where('id',@$request->expense_master_id)->update($up_sta);
            ExpenseDetail::where('expense_master_id',@$request->expense_master_id)->update($up_sta);
            $result = Memo::where('id',@$request->id)->where('expense_master_id',@$request->expense_master_id)->update($upd);
            return redirect()->back()->with('success','Transaction receipt successfully uploaded.');
        }else{            
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function approve_hyd($id = null, $type = null) 
    {
        $chk_master=ExpenseMaster::where('id',@$id)->where('approval_stage','ACH')->whereIn('status',['A','H'])->first();
        if(!$chk_master)
        {
            return redirect()->back()->with('error','Something went worng');
        }
        if($type == 'A')
        {
            $upData['status'] = 'A'; 
            $upData['approval_stage'] = 'ACHY'; 
        }else{
            return redirect()->back()->with('error','Something went worng');
        }
       
        ExpenseDetail::where('expense_master_id',@$chk_master->id)->update($upData);
        ExpenseMaster::where('id',@$chk_master->id)->update($upData);

       

        if($type == 'A')
        {
            $upd['status']              = 'I';
            $result = Memo::where('expense_master_id',@$chk_master->id)->update($upd);
            return redirect()->route('manage.memo.list')->with('success','Report approved successfully');
        }else{
            return redirect()->route('manage.memo.list')->with('error','Something went worng');
        }
    }


    public function reject_hold_hyd(Request $request)
    {
        $id = @$request->id;
        $type=@$request->type;
       

        $chk_master=ExpenseMaster::where('id',@$id)->where('approval_stage','ACH')->whereIn('status',['A','H'])->first();
       
        if(!$chk_master)
        {
            return redirect()->back()->with('error','Something went worng');
        }
        if($type == 'R')
        {
            $upData['status'] = 'R'; 
            $upData['approval_stage'] = 'ACHY'; 
        }elseif($type == 'H'){
            $upData['status'] = 'H'; 
            // $upData['approval_stage'] = 'ACHY'; 
        }else{
            return redirect()->back()->with('error','Something went worng');
        }


        ExpenseDetail::where('expense_master_id',@$chk_master->id)->update($upData);
        
        $upData['rejected_by'] = "ACHY";
        $upData['is_editable'] = 'N';
        ExpenseMaster::where('id',@$chk_master->id)->update($upData);

        if(@$request->comment)
        {
            $upComment['remark'] = @$request->comment;
            ExpenseDetail::where('expense_master_id',@$chk_master->id)->update($upComment);
        }

        if($type == 'R')
        {
            
            $upd['status']              = 'R';
            $result = Memo::where('expense_master_id',@$chk_master->id)->update($upd);
            return redirect()->route('view.receipt',['id'=>@$chk_master->id])->with('success','Report rejected successfully');
        }elseif($type == 'H'){

            $upd['status']              = 'H';
            $result = Memo::where('expense_master_id',@$chk_master->id)->update($upd);
            return redirect()->route('view.receipt',['id'=>@$chk_master->id])->with('success','Report OnHold successfully');
        }else{
            return redirect()->route('view.receipt',['id'=>@$chk_master->id])->with('error','Something went worng');
        }
        
    }

}
