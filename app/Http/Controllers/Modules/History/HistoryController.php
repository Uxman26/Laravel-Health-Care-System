<?php

namespace App\Http\Controllers\Modules\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseMaster;
use App\Models\ExpenseItemDoc;
use App\Models\ExpenseItem;
use App\Models\ExpenseDetail;
use App\Models\Memo;

class HistoryController extends Controller
{
    public function report_history(Request $request)
    {
        // $data['history']=ExpenseDetail::where('user_id',auth()->user()->id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->paginate(10);
        $data['history']=ExpenseMaster::where('user_id',auth()->user()->id)->with('getExpenseDetail','getMemo');
        if($request->all())
        {
           
            // if($request->search_sort == '3')
            // {
            //     $data['history']=$data['history']->
            // }

            if($request->search_date)
            {
                // dD('123');
                // dd($request->search_date); 
                
                $data['history']=$data['history']->whereDate('start_date','<=',date('Y-m-d',strtotime($request->search_date)))->whereDate('end_date','>=',date('Y-m-d',strtotime($request->search_date)));
            }
            
        }
        
        if(@$request->search_sort == '2')
        {
            $data['history']=$data['history']->orderBy('start_date','asc');
        }elseif(@$request->search_sort == '3')
        {
            $data['history']=$data['history']->orderBy('start_date','desc');
        }else{
            $data['history']=$data['history']->orderBy('id','desc');
        }
        
        $data['history']=$data['history']->paginate(20);
        $data['key']=@$request->all();
        return view('modules.history.history',$data);
    }

    public function report_history_detail($id = null) 
    {
        if(!$id)
        {
            return redirect()->back();
        }
        $data['expense']=ExpenseDetail::where('user_id',auth()->user()->id)->where('id',$id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->first();
        if(!$data['expense'])
        {
            return redirect()->back()->with('error','Expense report not found!!');
        }
        $data['master']=ExpenseMaster::where('user_id',auth()->user()->id)->where('id',$data['expense']->expense_master_id)->with('getExpenseDetail')->first();
        return view('modules.history.history_report_detail', $data);
    }

}
