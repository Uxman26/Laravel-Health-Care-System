<?php

namespace App\Http\Controllers\Modules\Report;

use App\Http\Controllers\Controller;
use App\Mail\ExpenseAdded;
use Illuminate\Http\Request;
use App\Models\ExpenseMaster;
use App\Models\ExpenseItemDoc;
use App\Models\ExpenseItem;
use App\Models\ExpenseDetail;
use App\Models\User;
use Storage;
use DateTime;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth:web');
    }
    // Developer: Pawan
    // method : showing add report page
    // description : showing add report page to employee
    // date : 26-03-2023
    public function report($date = null)
    {
        
        $given_date=new DateTime($date);
        $today_date=new DateTime(date('d-m-Y'));
        if($given_date > $today_date )
        { 
            $data['day_date_send']=null;
        }
        
        if(@$date )
        {
            $data['day_date_send']=date('d-m-Y',strtotime(@$date));
        }else{
            $data['day_date_send']=null;
        }
       
       
        return view('modules.report.report',$data);
    }
    
    public function array_sum($arr)
    {
       $sum=0;
       if($arr)
       {
        foreach($arr as $val)
        {
            $sum = $sum + $val;
        }
       }
       
       return $sum;
    }

    // public function report_submit(Request $request) 
    // {
    //     // dd($request->rail_gst_amount);
    //     dd($request->all());
    //     $request->validate([ 
           
    //         'day_date' => 'required',
    //         'travel_from' => 'required',
    //         'travel_to' => 'required',
    //         'overnight_at' => 'required',
    //         'day_city' => 'required',
    //         'day_purpose' => 'required',
          
    //     ]);

    //     $m_ins['user_id']=@$request->user_id;
    //     $m_ins['type']='WE';
    //     // $m_ins['start_date']=
    //     // $m_ins['end_date']=
    //     // $grand_total=array_sum($request->rail_base_fare) + array_sum($request->rail_gst_amount) + array_sum($request->taxi_base_fare) + array_sum($request->taxi_gst_amount) + array_sum($request->hotel_base_fare) + array_sum($request->hotel_gst_amount) + @$request->laundry_total + @$request->breakfast_amount + @$request->lunch_amount + @$request->dinner_amount + @$request->phone_total + @$request->local_total + array_sum($request->misce_base_fare) + array_sum($request->misce_gst_amount);
    //     $m_ins['claimed_total']=@$request->grand_total_show;
    //     // $m_ins['approved_total']=0;
    //     $res_master=ExpenseMaster::create($m_ins);
    //     if(!$res_master)
    //     {
    //         return redirect()->back()->with('error','Something went wrong');
    //     }
    //     $d_ins['expense_master_id']=@$res_master->id;
    //     $d_ins['date']=date('Y-m-d',strtotime(@$request->day_date));
    //     $d_ins['travelling_from']=@$request->travel_from;
    //     $d_ins['travelling_to']=@$request->travel_to;
    //     $d_ins['orvernight_at']=@$request->overnight_at;
    //     $d_ins['days_total']=$m_ins['claimed_total'];
    //     $d_ins['day_city_name']=@$request->day_city;
    //     $d_ins['day_pupose']=@$request->day_purpose;
    //     $res_detail=ExpenseDetail::create($d_ins);
    //     if(!$res_detail)
    //     {
    //         return redirect()->back()->with('error','Something went wrong');
    //     }
    //     if(array_sum($request->rail_base_fare) > 0)
    //     {
    //         foreach($request->rail_base_fare as $key=>$rail)
    //         {
    //             if($rail > 0)
    //             {
    //                 $rail_ins['expense_detail_id']=@$res_detail->id; 
    //                 $rail_ins['type']='R';
    //                 $rail_ins['basefare']=@$rail;
    //                 $rail_ins['gst_amount']=@$request->rail_gst_amount[$key];
    //                 $rail_ins['total']=@$request->rail_total[$key];
    //                 $rail_ins['gst_no']=@$request->rail_gst_number[$key];
    //                 $rail_ins['remark']=@$request->rail_remark[$key];
    //                 $i_res=ExpenseItem::create($rail_ins);
    //                 if(!$i_res)
    //                 {
    //                     return redirect()->back()->with('error','Something went wrong');
    //                 }
    //                 $count_imgs= 0 ;
    //                 if(@$request->rail_doc_count)
    //                 {
    //                     foreach ($request->rail_doc_count as $count_key=>$count_value) 
    //                     {
    //                         if($key != 0)
    //                         {
    //                             if($count_key < $key)
    //                             {
    //                                 $count_imgs = $count_imgs + $count_value - 1;
    //                             }else{
    //                                 break;
    //                             }
    //                         }else{
    //                             $count_imgs = -1;
    //                         }
    //                     } 
    //                 }
    //                 //////////////////////
    //                 if($request->rail_doc_count[$key] > 0)
    //                 {

    //                     foreach ($request->rail_doc as $img_key=>$row) 
    //                     {
    //                         $count_img_2 = $count_imgs + $request->rail_doc_count[$key] + 1;
                            
    //                         if($img_key > $count_imgs && $img_key < $count_img_2)
    //                         {
    //                             if($row != null)
    //                             {
    //                                 $img_ins['expense_item_id']=$i_res->id; 
    //                                 $Image = $row;
    //                                 $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                                 Storage::putFileAs('public/report/rail', $Image, $filename);
    //                                 $img_ins['doc_name'] = $filename;               
    //                                 ExpenseItemDoc::create($img_ins);     
    //                             }
    //                         }
                            
                                        
    //                     }
    //                 }

    //                 //////////////////
    //                 // foreach ($request->rail_doc as $img_key=>$row) 
    //                 // {
    //                 //     $count_img_2 = $count_imgs + $request->rail_doc_count[$key] + 1;
                        
    //                 //     if($img_key > $count_imgs && $img_key < $count_img_2)
    //                 //     {
    //                 //         if($row != null)
    //                 //         {
    //                 //             $img_ins['expense_item_id']=$i_res->id; 
    //                 //             $Image = $row;
    //                 //             $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                 //             Storage::putFileAs('public/report/rail', $Image, $filename);
    //                 //             $img_ins['doc_name'] = $filename;               
    //                 //             ExpenseItemDoc::create($img_ins);     
    //                 //         }
    //                 //     }
                        
                                       
    //                 // }
    //             }
                   
    //         }
    //     }
    //     //for taxi section
    //     if(array_sum($request->taxi_base_fare) > 0)
    //     {
    //         foreach($request->taxi_base_fare as $key=>$taxi)
    //         {
    //             if($taxi > 0)
    //             {
    //                 $taxi_ins['expense_detail_id']=@$res_detail->id; 
    //                 $taxi_ins['type']='T';
    //                 $taxi_ins['basefare']=@$taxi;
    //                 $taxi_ins['gst_amount']=@$request->taxi_gst_amount[$key];
    //                 $taxi_ins['total']=@$request->taxi_total[$key];
    //                 $taxi_ins['gst_no']=@$request->taxi_gst_number[$key];
    //                 $taxi_ins['remark']=@$request->taxi_remark[$key];
    //                 $i_res=ExpenseItem::create($taxi_ins);
    //                 if(!$i_res)
    //                 {
    //                     return redirect()->back()->with('error','Something went wrong');
    //                 }
    //                 $count_imgs= 0 ;
    //                 if(@$request->taxi_doc_count)
    //                 {
    //                     foreach ($request->taxi_doc_count as $count_key=>$count_value) 
    //                     {
    //                         if($key != 0)
    //                         {
    //                             if($count_key < $key)
    //                             {
    //                                 $count_imgs = $count_imgs + $count_value - 1;
    //                             }else{
    //                                 break;
    //                             }
    //                         }else{
    //                             $count_imgs = 0;
    //                         }
    //                     } 
    //                 }
    //                 foreach ($request->taxi_doc as $img_key=>$row) 
    //                 {
    //                     $count_img_2 = $count_imgs + $request->taxi_doc_count[$key] + 1;
    //                     if($img_key > $count_imgs && $img_key < $count_img_2)
    //                     {
    //                         if($row != null)
    //                         {
    //                             $img_ins['expense_item_id']=$i_res->id; 
    //                             $Image = $row;
    //                             $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                             Storage::putFileAs('public/report/taxi', $Image, $filename);
    //                             $img_ins['doc_name'] = $filename;               
    //                             ExpenseItemDoc::create($img_ins);     
    //                         }
    //                     }
                        
                                       
    //                 }
    //             }
                   
    //         }
    //     }


    //     //for hotel section
    //     if(array_sum($request->hotel_base_fare) > 0)
    //     {
    //         foreach($request->hotel_base_fare as $key=>$hotel)
    //         {
    //             if($hotel > 0)
    //             {
    //                 $hotel_ins['expense_detail_id']=@$res_detail->id; 
    //                 $hotel_ins['type']='H';
    //                 $hotel_ins['basefare']=@$hotel;
    //                 $hotel_ins['gst_amount']=@$request->hotel_gst_amount[$key];
    //                 $hotel_ins['total']=@$request->hotel_total[$key];
    //                 $hotel_ins['gst_no']=@$request->hotel_gst_number[$key];
    //                 $hotel_ins['remark']=@$request->hotel_remark[$key];

    //                 $hotel_ins['hotel_name']=@$request->hotel_name[$key];
    //                 $hotel_ins['hotel_city']=@$request->hotel_city[$key];
    //                 $i_res=ExpenseItem::create($hotel_ins);
    //                 if(!$i_res)
    //                 {
    //                     return redirect()->back()->with('error','Something went wrong');
    //                 }
    //                 $count_imgs= 0 ;
    //                 if(@$request->hotel_doc_count)
    //                 {
    //                     foreach ($request->hotel_doc_count as $count_key=>$count_value) 
    //                     {
    //                         if($key != 0)
    //                         {
    //                             if($count_key < $key)
    //                             {
    //                                 $count_imgs = $count_imgs + $count_value - 1;
    //                             }else{
    //                                 break;
    //                             }
    //                         }else{
    //                             $count_imgs = 0;
    //                         }
    //                     } 
    //                 }
    //                 foreach ($request->hotel_doc as $img_key=>$row) 
    //                 {
    //                     $count_img_2 = $count_imgs + $request->hotel_doc_count[$key] + 1;
    //                     if($img_key > $count_imgs && $img_key < $count_img_2)
    //                     {
    //                         if($row != null)
    //                         {
    //                             $img_ins['expense_item_id']=$i_res->id; 
    //                             $Image = $row;
    //                             $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                             Storage::putFileAs('public/report/hotel', $Image, $filename);
    //                             $img_ins['doc_name'] = $filename;               
    //                             ExpenseItemDoc::create($img_ins);     
    //                         }
    //                     }
                        
                                        
    //                 }
    //             }
                    
    //         }
    //     }


    //     if(@$request->laundry_base_fare > 0)
    //     {
    //         $laun_ins['expense_detail_id']=@$res_detail->id; 
    //         $laun_ins['type']='L';
    //         $laun_ins['basefare']=@$request->laundry_base_fare;
    //         $laun_ins['gst_amount']=@$request->laundry_gst_amount;
    //         $laun_ins['total']=@$request->laundry_total;
    //         $laun_ins['gst_no']=@$request->laundry_gst_number;
    //         $laun_ins['remark']=@$request->laundry_remark;

    //         $laun_ins['hotel_name']=@$request->laundry_name;
    //         $laun_ins['hotel_city']=@$request->laundry_city;
    //         $i_res=ExpenseItem::create($laun_ins);

    //         if($i_res)
    //         {
    //             foreach ($request->laundry_doc as $row) 
    //             {
                   
    //                 if($row != null)
    //                 {
    //                     $img_ins['expense_item_id']=$i_res->id; 
    //                     $Image = $row;
    //                     $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                     Storage::putFileAs('public/report/laundry', $Image, $filename);
    //                     $img_ins['doc_name'] = $filename;               
    //                     ExpenseItemDoc::create($img_ins);     
    //                 }
                                    
    //             }
    //         }
            
           
    //     }

    //     //for breakfast

    //     if(@$request->breakfast_amount > 0)
    //     {
    //         $break_ins['expense_detail_id']=@$res_detail->id; 
    //         $break_ins['type']='B';
    //         $break_ins['basefare']=@$request->breakfast_amount;
            
    //         $break_ins['total']=@$request->breakfast_amount;
    //         $break_ins['remark']=@$request->breakfast_remark;

           
    //         $i_res=ExpenseItem::create($break_ins);

    //         if($i_res)
    //         {
    //             if($request->breakfast_doc)
    //             {
    //                 foreach ($request->breakfast_doc as $row) 
    //                 {
                       
    //                     if($row != null)
    //                     {
    //                         $img_ins['expense_item_id']=$i_res->id; 
    //                         $Image = $row;
    //                         $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                         Storage::putFileAs('public/report/breakfast', $Image, $filename);
    //                         $img_ins['doc_name'] = $filename;               
    //                         ExpenseItemDoc::create($img_ins);     
    //                     }
                                        
    //                 }
    //             }
               
    //         }  
           
    //     }

    //     //for lunch

    //     if(@$request->lunch_amount > 0)
    //     {
    //         $lunch_ins['expense_detail_id']=@$res_detail->id; 
    //         $lunch_ins['type']='LU';
    //         $lunch_ins['basefare']=@$request->lunch_amount;
            
    //         $lunch_ins['total']=@$request->lunch_amount;
    //         $lunch_ins['remark']=@$request->lunch_remark;

            
    //         $i_res=ExpenseItem::create($lunch_ins);

    //         if($i_res)
    //         {
    //             if($request->lunch_doc)
    //             {
    //                 foreach ($request->lunch_doc as $row) 
    //                 {
                        
    //                     if($row != null)
    //                     {
    //                         $img_ins['expense_item_id']=$i_res->id; 
    //                         $Image = $row;
    //                         $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                         Storage::putFileAs('public/report/lunch', $Image, $filename);
    //                         $img_ins['doc_name'] = $filename;               
    //                         ExpenseItemDoc::create($img_ins);     
    //                     }
                                        
    //                 }
    //             }
    //         }  
            
    //     }

    //     //for dinner

    //     if(@$request->dinner_amount > 0)
    //     {
    //         $dinner_ins['expense_detail_id']=@$res_detail->id; 
    //         $dinner_ins['type']='D';
    //         $dinner_ins['basefare']=@$request->dinner_amount;
            
    //         $dinner_ins['total']=@$request->dinner_amount;
    //         $dinner_ins['remark']=@$request->dinner_remark;

            
    //         $i_res=ExpenseItem::create($dinner_ins);

    //         if($i_res)
    //         {
    //             if($request->dinner_doc)
    //             {
    //                 foreach ($request->dinner_doc as $row) 
    //                 {
                        
    //                     if($row != null)
    //                     {
    //                         $img_ins['expense_item_id']=$i_res->id; 
    //                         $Image = $row;
    //                         $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                         Storage::putFileAs('public/report/dinner', $Image, $filename);
    //                         $img_ins['doc_name'] = $filename;               
    //                         ExpenseItemDoc::create($img_ins);     
    //                     }
                                        
    //                 }
    //             }
    //         }  
            
    //     }

    //     //for phone

    //     if(@$request->phone_base_fare > 0)
    //     {
    //         $phone_ins['expense_detail_id']=@$res_detail->id; 
    //         $phone_ins['type']='P';
    //         $phone_ins['basefare']=@$request->phone_base_fare;
    //         $phone_ins['gst_amount']=@$request->phone_gst_amount;
    //         $phone_ins['total']=@$request->phone_total;
    //         $phone_ins['gst_no']=@$request->phone_gst_number;
    //         $phone_ins['remark']=@$request->phone_remark;

            
    //         $i_res=ExpenseItem::create($phone_ins);

    //         if($i_res)
    //         {
    //             if($request->phone_doc)
    //             {
    //                 foreach ($request->phone_doc as $row) 
    //                 {
                    
    //                     if($row != null)
    //                     {
    //                         $img_ins['expense_item_id']=$i_res->id; 
    //                         $Image = $row;
    //                         $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                         Storage::putFileAs('public/report/phone', $Image, $filename);
    //                         $img_ins['doc_name'] = $filename;               
    //                         ExpenseItemDoc::create($img_ins);     
    //                     }
                                        
    //                 }
    //             }
    //         }
               
    //     }

    //     //for local
    //     if(@$request->local_base_fare > 0)
    //     {
    //         $local_ins['expense_detail_id']=@$res_detail->id; 
    //         $local_ins['type']='LC';
    //         $local_ins['basefare']=@$request->local_base_fare;
    //         $local_ins['gst_amount']=@$request->local_gst_amount;
    //         $local_ins['total']=@$request->local_total;
    //         $local_ins['gst_no']=@$request->local_gst_number;
    //         $local_ins['remark']=@$request->local_remark;

            
    //         $i_res=ExpenseItem::create($local_ins);

    //         if($i_res)
    //         {
    //             if($request->local_doc)
    //             {
    //                 foreach ($request->local_doc as $row) 
    //                 {
                    
    //                     if($row != null)
    //                     {
    //                         $img_ins['expense_item_id']=$i_res->id; 
    //                         $Image = $row;
    //                         $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                         Storage::putFileAs('public/report/phone', $Image, $filename);
    //                         $img_ins['doc_name'] = $filename;               
    //                         ExpenseItemDoc::create($img_ins);     
    //                     }
                                        
    //                 }
    //             }
    //         }
               
    //     }

    //     //for miscellaneous
    //     if(array_sum($request->misce_base_fare) > 0)
    //     {
    //         foreach($request->misce_base_fare as $key=>$misce)
    //         {
    //             if($misce > 0)
    //             {
    //                 $misce_ins['expense_detail_id']=@$res_detail->id; 
    //                 $misce_ins['type']='M';
    //                 $misce_ins['basefare']=@$misce;
    //                 $misce_ins['gst_amount']=@$request->misce_gst_amount[$key];
    //                 $misce_ins['total']=@$request->misce_total[$key];
    //                 $misce_ins['gst_no']=@$request->misce_gst_number[$key];
    //                 $misce_ins['remark']=@$request->misce_remark[$key];

                   
    //                 $i_res=ExpenseItem::create($misce_ins);
    //                 if(!$i_res)
    //                 {
    //                     return redirect()->back()->with('error','Something went wrong');
    //                 }
    //                 $count_imgs= 0 ;
    //                 if(@$request->misce_doc_count)
    //                 {
    //                     foreach ($request->misce_doc_count as $count_key=>$count_value) 
    //                     {
    //                         if($key != 0)
    //                         {
    //                             if($count_key < $key)
    //                             {
    //                                 $count_imgs = $count_imgs + $count_value - 1;
    //                             }else{
    //                                 break;
    //                             }
    //                         }else{
    //                             $count_imgs = 0;
    //                         }
    //                     } 
    //                 }
    //                 foreach ($request->misce_doc as $img_key=>$row) 
    //                 {
    //                     $count_img_2 = $count_imgs + $request->misce_doc_count[$key] + 1;
    //                     if($img_key > $count_imgs && $img_key < $count_img_2)
    //                     {
    //                         if($row != null)
    //                         {
    //                             $img_ins['expense_item_id']=$i_res->id; 
    //                             $Image = $row;
    //                             $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
    //                             Storage::putFileAs('public/report/misce', $Image, $filename);
    //                             $img_ins['doc_name'] = $filename;               
    //                             ExpenseItemDoc::create($img_ins);     
    //                         }
    //                     }
                        
                                        
    //                 }
    //             }
                    
    //         }
    //     }
    //     // dd('successs');
    //     return redirect()->back()->with('success','Report added successfully');


    // }


    // Developer: Pawan
    // method : showing edit report page
    // description : showing edit report page to employee
    // date : 29-03-2023
    public function edit_report($id = null)
    {
        // dd($id);
        if(!$id)
        {
            return redirect()->back()->with('error','Expense Record not found');
        }
        $data['expense']=ExpenseDetail::where('id',$id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->first();
        if(!$data['expense'])
        {
            return redirect()->back()->with('error','Expense Record not found');
        }
        $chk=ExpenseMaster::where('id',$data['expense']->expense_master_id)->whereIn('status',['S','A','H'])->first();
        if($chk)
        {
            return redirect()->back()->with('error','You cant edit this expense report as this weekly report is in process of approval already ');
        }

        return view('modules.report.edit_report',$data);
    }

    // Developer: Pawan
    // method : when user click on date in edit page then it will redirect
    // description : when user click on date in edit page then it will redirect
    // date : 29-03-2023
    public function change_daye_date($date = null)
    {
        
      
        if(!$date )
        {
            return redirect()->route('employee.report');
        }
        $given_date=new DateTime($date);
        $today_date=new DateTime(date('d-m-Y'));
        if($given_date > $today_date )
        { 
           
            return redirect()->route('employee.report');
        }
       
        // dd(date('d-m-Y',strtotime($date)),date('d-m-Y'));
        $chk=ExpenseDetail::where('date',date('Y-m-d',strtotime($date)))->where('user_id',auth()->user()->id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->first();
        if($chk)
        {
            $chk_master=ExpenseMaster::where('id',$chk->expense_master_id)->whereIn('status',['S','A'])->first();
            if($chk_master)
            {
                return redirect()->route('employee.history.report')->with('error','You cant add expense report on date - '.@$date);
            }
            return redirect()->route('employee.edit.report',['id'=>@$chk->id]);
        }
        
        return redirect()->route('employee.report',['date'=>$date]);

    }

    // Developer: Pawan
    // method : when user click on date in view page then it will redirect
    // description : when user click on date in view page then it will redirect
    // date : 29-03-2023
    public function change_daye_date_view($date = null)
    {
        
        if(!$date)
        {
            return redirect()->route('employee.history.report');
        }
        $chk=ExpenseDetail::where('date',date('Y-m-d',strtotime($date)))->where('user_id',auth()->user()->id)->with('getExpenseMaster','getExpenseItemRail','getExpenseItemTaxi','getExpenseItemHotel','getExpenseItemLaundry','getExpenseItemBreakfast','getExpenseItemLunch','getExpenseItemDinner','getExpenseItemPhone','getExpenseItemLocal','getExpenseItemMisce')->first();
        if($chk)
        {
            return redirect()->route('employee.history.report.detail',['id'=>@$chk->id]);
        }

        return redirect()->back()->with('error','Expense Report no found!!');

    }


    // Developer: Pawan 
    // method : getting week days according to given date using ajax
    // description : getting week days according to given date using ajax
    // date : 29-03-2023
    public function get_week_date(Request $request)
    {
        // $day_date=date('d-m-Y',strtotime('01-03-2023'));
        $day_date=@$request->day_date;
        if(@$request->type != 'view')
        {
            $chk_date_weeke=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day_date)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day_date)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            // dd($chk_date_weeke);
                if($chk_date_weeke)
                {
                    $response['selected_date']=$day_date;
                    $response['day_date_error']='found';
                    return response()->json($response);
                }
            
        }
        
        $response['day_date_error']=null;
        if(!$day_date)
        {
            $response['day1']=null;
            $response['day2']=null;
            $response['day3']=null;
            $response['day4']=null;
            $response['day5']=null;
            $response['day6']=null;
            $response['day7']=null; 
            $response['selected_date']=null;
        }
        $day_date=date('d-m-Y',strtotime($day_date));
        $day2=date('d-m-Y',strtotime($day_date.'+1 days'));
        // dd(date('m',strtotime($day_date)));
        $day_count=date('N',strtotime($day_date));
        if($day_count == '1')
        {
            // $hour_later=date('Y-m-d H:i:s',strtotime(@$rides_date_time.'+24 hours'));
            $day1=$day_date;
            $day2=date('d-m-Y',strtotime($day_date.'+1 days')); 
            $day3=date('d-m-Y',strtotime($day_date.'+2 days'));
            $day4=date('d-m-Y',strtotime($day_date.'+3 days'));
            $day5=date('d-m-Y',strtotime($day_date.'+4 days'));
            $day6=date('d-m-Y',strtotime($day_date.'+5 days'));
            $day7=date('d-m-Y',strtotime($day_date.'+6 days'));

        }
        if($day_count == '2')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day2=$day_date;
            $day3=date('d-m-Y',strtotime($day_date.'+1 days'));
            $day4=date('d-m-Y',strtotime($day_date.'+2 days'));
            $day5=date('d-m-Y',strtotime($day_date.'+3 days'));
            $day6=date('d-m-Y',strtotime($day_date.'+4 days'));
            $day7=date('d-m-Y',strtotime($day_date.'+5 days'));
        }
        if($day_count == '3')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-2 days'));
            $day2=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day3=$day_date;
            $day4=date('d-m-Y',strtotime($day_date.'+1 days'));
            $day5=date('d-m-Y',strtotime($day_date.'+2 days'));
            $day6=date('d-m-Y',strtotime($day_date.'+3 days'));
            $day7=date('d-m-Y',strtotime($day_date.'+4 days'));
        }
        if($day_count == '4')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-3 days'));
            $day2=date('d-m-Y',strtotime($day_date.'-2 days'));
            $day3=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day4=$day_date;
            $day5=date('d-m-Y',strtotime($day_date.'+1 days'));
            $day6=date('d-m-Y',strtotime($day_date.'+2 days'));
            $day7=date('d-m-Y',strtotime($day_date.'+3 days'));
        }
        if($day_count == '5')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-4 days'));
            $day2=date('d-m-Y',strtotime($day_date.'-3 days'));
            $day3=date('d-m-Y',strtotime($day_date.'-2 days'));
            $day4=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day5=$day_date;
            $day6=date('d-m-Y',strtotime($day_date.'+1 days'));
            $day7=date('d-m-Y',strtotime($day_date.'+2 days'));
        }
        if($day_count == '6')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-5 days'));
            $day2=date('d-m-Y',strtotime($day_date.'-4 days'));
            $day3=date('d-m-Y',strtotime($day_date.'-3 days'));
            $day4=date('d-m-Y',strtotime($day_date.'-2 days'));
            $day5=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day6=$day_date;
            $day7=date('d-m-Y',strtotime($day_date.'+1 days'));
        }
        if($day_count == '7')
        {
            $day1=date('d-m-Y',strtotime($day_date.'-6 days'));
            $day2=date('d-m-Y',strtotime($day_date.'-5 days'));
            $day3=date('d-m-Y',strtotime($day_date.'-4 days'));
            $day4=date('d-m-Y',strtotime($day_date.'-3 days'));
            $day5=date('d-m-Y',strtotime($day_date.'-2 days'));
            $day6=date('d-m-Y',strtotime($day_date.'-1 days'));
            $day7=$day_date;
        }
        $todays_dates= date('d-m-Y');
        // dd(date('d-m-Y',strtotime($day1)),date('d-m-Y'));
        if(date('m',strtotime($day1)) == date('m',strtotime($day_date)) && strtotime($day1) <= strtotime($todays_dates))
        {
           
            $day1=$day1;
            $ch_day1=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day1)))->where('user_id',auth()->user()->id)->first();
            if($ch_day1)
            {
                $response['is_day1']='yes';
            }else{
                $response['is_day1']='no';
            }
        }else{
            $day1=null;
        }
       

        if(date('m',strtotime($day2)) == date('m',strtotime($day_date)) && strtotime($day2) <= strtotime($todays_dates))
        {
            $day2=$day2;
            $ch_day2=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day2)))->where('user_id',auth()->user()->id)->first();
            if($ch_day2)
            {
                $response['is_day2']='yes';
            }else{
                $response['is_day2']='no';
            }
        }else{
            $day2=null;
        }

        if(date('m',strtotime($day3)) == date('m',strtotime($day_date)) && strtotime($day3) <= strtotime($todays_dates))
        {
            $day3=$day3;
            $ch_day3=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day3)))->where('user_id',auth()->user()->id)->first();
            if($ch_day3)
            {
                $response['is_day3']='yes';
            }else{
                $response['is_day3']='no';
            }
        }else{
            $day3=null;
        }

        if(date('m',strtotime($day4)) == date('m',strtotime($day_date)) && strtotime($day4) <= strtotime($todays_dates))
        {
            $day4=$day4;
            $ch_day4=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day4)))->where('user_id',auth()->user()->id)->first();
            if($ch_day4)
            {
                $response['is_day4']='yes';
            }else{
                $response['is_day4']='no';
            }
        }else{
            $day4=null;
        }

        if(date('m',strtotime($day5)) == date('m',strtotime($day_date)) && strtotime($day5) <= strtotime($todays_dates))
        {
            $day5=$day5;
            $ch_day5=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day5)))->where('user_id',auth()->user()->id)->first();
            if($ch_day5)
            {
                $response['is_day5']='yes';
            }else{
                $response['is_day5']='no';
            }
        }else{
            $day5=null;
        }

        if(date('m',strtotime($day6)) == date('m',strtotime($day_date)) && strtotime($day6) <= strtotime($todays_dates))
        {
            $day6=$day6;
            $ch_day6=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day6)))->where('user_id',auth()->user()->id)->first();
            if($ch_day6)
            {
                $response['is_day6']='yes';
            }else{
                $response['is_day6']='no';
            }
        }else{
            $day6=null;
        }

        if(date('m',strtotime($day7)) == date('m',strtotime($day_date)) && strtotime($day7) <= strtotime($todays_dates))
        {
            $day7=$day7;
            $ch_day7=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day7)))->where('user_id',auth()->user()->id)->first();
            if($ch_day7)
            {
                $response['is_day7']='yes';
            }else{
                $response['is_day7']='no';
            }
        }else{
            $day7=null;
        }
        $start_week_date=null;
        $end_week_date=null;

        if(@$day1 != null)
        {
            $start_week_date=@$day1;
        }elseif(@$day2 != null && $start_week_date == null)
        {
            $start_week_date=@$day2;
        }elseif(@$day3 != null && $start_week_date == null)
        {
            $start_week_date=@$day3;
        }elseif(@$day4 != null && $start_week_date == null)
        {
            $start_week_date=@$day4;
        }
        elseif(@$day5 != null && $start_week_date == null)
        {
            $start_week_date=@$day5;
        }
        elseif(@$day6 != null && $start_week_date == null)
        {
            $start_week_date=@$day6;
        }
        elseif(@$day7 != null && $start_week_date == null)
        {
            $start_week_date=@$day7;
        }

        //for end week date
        if(@$day7 != null)
        {
            $end_week_date=@$day7;
        }elseif(@$day6 != null && $end_week_date == null)
        {
            $end_week_date=@$day6;
        }elseif(@$day5 != null && $end_week_date == null)
        {
            $end_week_date=@$day5;
        }elseif(@$day4 != null && $end_week_date == null)
        {
            $end_week_date=@$day4;
        }
        elseif(@$day3 != null && $end_week_date == null)
        {
            $end_week_date=@$day3;
        }
        elseif(@$day2 != null && $end_week_date == null)
        {
            $end_week_date=@$day2;
        }
        elseif(@$day1 != null && $end_week_date == null)
        {
            $end_week_date=@$day1;
        }


        $response['day1']=$day1;
        $response['day2']=$day2;
        $response['day3']=$day3;
        $response['day4']=$day4;
        $response['day5']=$day5;
        $response['day6']=$day6;
        $response['day7']=$day7;
        $response['selected_date']=$day_date;

        $chk_date_weekefor_all =0;
        if(@$request->type != 'view')
        {
            $chk_date_weeke_day_1=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day1)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day1)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_2=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day2)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day2)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_3=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day3)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day3)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_4=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day4)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day4)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_5=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day5)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day5)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_6=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day6)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day6)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();
            $chk_date_weeke_day_7=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day7)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day7)))->where('user_id',auth()->user()->id)->whereIn('status',['S','A'])->first();

            if($chk_date_weeke_day_1 || $chk_date_weeke_day_2 || $chk_date_weeke_day_3 || $chk_date_weeke_day_4 || $chk_date_weeke_day_5 || $chk_date_weeke_day_6 || $chk_date_weeke_day_7)
            {
                $chk_date_weekefor_all = '1';
            }
            // dd($chk_date_weeke);
                if($chk_date_weekefor_all == '1')
                {
                    $response['selected_date']=$day_date;
                    $response['day_date_error']='found';
                    return response()->json($response);
                }
            
        }

        $response['start_week_date']=$start_week_date;
        $response['end_week_date']=$end_week_date;

        $response['is_previous_week']=$this->get_last_weeek($start_week_date);

        
        if(@$request->day_id)
        {
            $chk=ExpenseDetail::where('id','!=',@$request->day_id)->where('user_id',auth()->user()->id)->whereDate('date',date('Y-m-d',strtotime($day_date)))->first();
        }else{
            $chk=ExpenseDetail::where('user_id',auth()->user()->id)->whereDate('date',date('Y-m-d',strtotime($day_date)))->first();
        }
       
        // $chk=ExpenseDetail::where('user_id',auth()->user()->id)->where('date',date('Y-m-d',strtotime($day_date)))->first();
        if($chk)
        {
            $response['expense_master_id']=$chk->expense_master_id;
            $response['expense_detail_id']=$chk->id;
            $response['day_error']='inserted';
            $response['expense_detail']=$chk;
        }else{
            $response['day_error']=null;
        }
        return response()->json($response);
        
    }

    public function submit_week_report(Request $request)
    {
        $id=@$request->expense_master_id;
        if(!$id)
        {
            return redirect()->back()->with('error','No Expense report found!!. Please enter atleast any 1 date expense data.');
        }
        $chk=ExpenseMaster::where('id',$id)->first();
        if(!$chk)
        {
            return redirect()->back()->with('error','Please enter atleast any 1 date expense data.');
        }
        if($chk->status == 'A')
        {
            return redirect()->back()->with('error','This expense report is already approved');
        }

        if($chk->status == 'S')
        {
            return redirect()->back()->with('error','This expense report is already submitted for approval');
        }
        $chk_exp_detail=ExpenseDetail::where('expense_master_id',@$id)->where('user_id',auth()->user()->id)->first();
        if(!$chk_exp_detail)
        {
            return redirect()->back()->with('error','Please enter atleast any 1 date expense data.'); 
        }

        # Reference Number
        if($chk->status == 'D'){            
            $upd1['expense_unique_code']='WE'.auth()->user()->id.'-'.time();
        }
        $upd1['claimed_total']=ExpenseDetail::where('expense_master_id',@$id)->sum('days_total');

        $upd1['status']='S';
        $upd1['approval_stage']='ADAS';
        $upd1['approved_total']=0;
        $result=ExpenseMaster::where('id',$id)->update($upd1);
        $upd['status']='S';
        $upd['is_admin_commented']='N';
        $upd['approval_stage']='ADAS';
        ExpenseDetail::where('expense_master_id',@$id)->where('user_id',auth()->user()->id)->update($upd);

        $ecpense_detail_id=ExpenseDetail::where('expense_master_id',@$id)->where('user_id',auth()->user()->id)->first();


        $chk_ecp_deta=ExpenseDetail::where('expense_master_id',@$id)->get();
        // if($chk_ecp_deta->isNotEmpty())
        // {
        //     foreach(@$chk_ecp_deta as $expd)
        //     {
        //         if($expd->days_approved > 0)
        //         {
                   
        //                 $items = ExpenseItem::where('expense_detail_id',@$expd->id)->get();
    
        //                 #all items approved amount
        //                 $total_approved_amt = 0;
        //                 // $test=array();
        //                 if(!empty(@$items)){
        //                     foreach(@$items as $item){
        //                         if(@$item->approved_amount > 0 ){
        //                             // array_push($test,$item->approved_amount);
        //                             $total_approved_amt += $item->approved_amount;
        //                         }else{
        //                             // array_push($test,$item->total);
        //                             $total_approved_amt += $item->total;
        //                         }
        //                     }
        //                 }
        //                 $upde['days_approved'] = $total_approved_amt; 
        //                 ExpenseDetail::where('id',@$expd->id)->update($upde);  
    
        //                 $weekData = ExpenseDetail::where('expense_master_id',@$expd->expense_master_id)->get();
        //                 $sumTotal=0;
                       
        //                 if(!empty(@$weekData)){
        //                     foreach(@$weekData as $data){
        //                         if(@$data->days_approved > 0 ){
        //                             $sumTotal += $data->days_approved;
        //                         }else{
        //                             $sumTotal += $data->days_total;
        //                         }
                               
        //                     }
        //                 }
    
        //                 $upMaster['approved_total'] =  @$sumTotal;
        //                 // $upMaster['claimed_total'] =  @$act_sum_total;
        //                 ExpenseMaster::where('id',@$expd->expense_master_id)->where('user_id',@$expd->user_id)->update($upMaster);
                    
                    
        //         }
        //     }
           
        // }

        if($chk_ecp_deta->isNotEmpty())
        {
            foreach(@$chk_ecp_deta as $expd)
            {
                $updei['approved_gst_amount']=0;
                $updei['approved_amount']=0;
                $updei['comment']=null;
                 ExpenseItem::where('expense_detail_id',@$expd->id)->update($updei);
                 $updei_de['days_approved']=0;
                 ExpenseDetail::where('expense_master_id',@$id)->update($updei_de);
            } 
    
        }

        if($result)
        {
            if($ecpense_detail_id)
            {
                if(auth()->user()->user_type == 'E'){
                    $array = ['AA'] ;
                } elseif(auth()->user()->user_type == 'AA'){
                    $array = ['A'] ;
                } elseif(auth()->user()->user_type == 'A'){
                    $array = ['HR'] ;
                } elseif(auth()->user()->user_type == 'HR'){
                    $array = ['ACA'] ;
                } elseif(auth()->user()->user_type == 'ACA'){
                    $array = ['ACH'] ;
                } elseif(auth()->user()->user_type == 'ACH'){
                    $array = ['AHY'] ;
                } elseif(auth()->user()->user_type == 'AHY'){
                    $array = ['DIR'] ;
                } else {
                    $array = [];
                }
                $users = User::whereIn('user_type', $array)->get();
                foreach($users as $user){
                    $user_id = $user->id;
                    // SendExpenseEmail::dispatch($expense_detail_id, $user_id);
                    $user = User::where('id',$user_id)->first();
                if ($user && $user->pro_email) {
                    Mail::to($user->pro_email)->send(new ExpenseAdded($ecpense_detail_id->id, $user_id));
                }
                }
                return redirect()->route('employee.history.report.detail',['id'=>@$ecpense_detail_id->id])->with('success','Weekly expense report is successfully submitted for approval');

            }else{
                return redirect()->route('employee.history.report')->with('success','Weekly expense report is successfully submitted for approval');
            }
            
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }

    }

    public function get_last_weeek($date)
    {
      // $day_date=date('d-m-Y',strtotime('01-03-2023'));
      $day_date=date('d-m-Y',strtotime(@$date));
      
     
      
      $response['day_date_error']=null;
      if(!$day_date)
      {
          $response['day1']=null;
          $response['day2']=null;
          $response['day3']=null;
          $response['day4']=null;
          $response['day5']=null;
          $response['day6']=null;
          $response['day7']=null; 
          $response['selected_date']=null;
      }
      $day_date=date('d-m-Y',strtotime($day_date.'-1 days'));
     
      $day2=date('d-m-Y',strtotime($day_date.'+1 days'));
      // dd(date('m',strtotime($day_date)));
      $day_count=date('N',strtotime($day_date));
     
      if($day_count == '1')
      {
          // $hour_later=date('Y-m-d H:i:s',strtotime(@$rides_date_time.'+24 hours'));
          $day1=$day_date;
          $day2=date('d-m-Y',strtotime($day_date.'+1 days')); 
          $day3=date('d-m-Y',strtotime($day_date.'+2 days'));
          $day4=date('d-m-Y',strtotime($day_date.'+3 days'));
          $day5=date('d-m-Y',strtotime($day_date.'+4 days'));
          $day6=date('d-m-Y',strtotime($day_date.'+5 days'));
          $day7=date('d-m-Y',strtotime($day_date.'+6 days'));

      }
      if($day_count == '2')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day2=$day_date;
          $day3=date('d-m-Y',strtotime($day_date.'+1 days'));
          $day4=date('d-m-Y',strtotime($day_date.'+2 days'));
          $day5=date('d-m-Y',strtotime($day_date.'+3 days'));
          $day6=date('d-m-Y',strtotime($day_date.'+4 days'));
          $day7=date('d-m-Y',strtotime($day_date.'+5 days'));
      }
      if($day_count == '3')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-2 days'));
          $day2=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day3=$day_date;
          $day4=date('d-m-Y',strtotime($day_date.'+1 days'));
          $day5=date('d-m-Y',strtotime($day_date.'+2 days'));
          $day6=date('d-m-Y',strtotime($day_date.'+3 days'));
          $day7=date('d-m-Y',strtotime($day_date.'+4 days'));
      }
      if($day_count == '4')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-3 days'));
          $day2=date('d-m-Y',strtotime($day_date.'-2 days'));
          $day3=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day4=$day_date;
          $day5=date('d-m-Y',strtotime($day_date.'+1 days'));
          $day6=date('d-m-Y',strtotime($day_date.'+2 days'));
          $day7=date('d-m-Y',strtotime($day_date.'+3 days'));
      }
      if($day_count == '5')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-4 days'));
          $day2=date('d-m-Y',strtotime($day_date.'-3 days'));
          $day3=date('d-m-Y',strtotime($day_date.'-2 days'));
          $day4=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day5=$day_date;
          $day6=date('d-m-Y',strtotime($day_date.'+1 days'));
          $day7=date('d-m-Y',strtotime($day_date.'+2 days'));
      }
      if($day_count == '6')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-5 days'));
          $day2=date('d-m-Y',strtotime($day_date.'-4 days'));
          $day3=date('d-m-Y',strtotime($day_date.'-3 days'));
          $day4=date('d-m-Y',strtotime($day_date.'-2 days'));
          $day5=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day6=$day_date;
          $day7=date('d-m-Y',strtotime($day_date.'+1 days'));
      }
      if($day_count == '7')
      {
          $day1=date('d-m-Y',strtotime($day_date.'-6 days'));
          $day2=date('d-m-Y',strtotime($day_date.'-5 days'));
          $day3=date('d-m-Y',strtotime($day_date.'-4 days'));
          $day4=date('d-m-Y',strtotime($day_date.'-3 days'));
          $day5=date('d-m-Y',strtotime($day_date.'-2 days'));
          $day6=date('d-m-Y',strtotime($day_date.'-1 days'));
          $day7=$day_date;
      }
      $todays_dates= date('d-m-Y');
        // dd(date('d-m-Y',strtotime($day1)),date('d-m-Y'));
        if(date('m',strtotime($day1)) == date('m',strtotime($day_date)) && strtotime($day1) <= strtotime($todays_dates))
        {
           
            $day1=$day1;
            $ch_day1=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day1)))->where('user_id',auth()->user()->id)->first();
            if($ch_day1)
            {
                $response['is_day1']='yes';
            }else{
                $response['is_day1']='no';
            }
        }else{
            $day1=null;
        }
       

        if(date('m',strtotime($day2)) == date('m',strtotime($day_date)) && strtotime($day2) <= strtotime($todays_dates))
        {
            $day2=$day2;
            $ch_day2=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day2)))->where('user_id',auth()->user()->id)->first();
            if($ch_day2)
            {
                $response['is_day2']='yes';
            }else{
                $response['is_day2']='no';
            }
        }else{
            $day2=null;
        }

        if(date('m',strtotime($day3)) == date('m',strtotime($day_date)) && strtotime($day3) <= strtotime($todays_dates))
        {
            $day3=$day3;
            $ch_day3=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day3)))->where('user_id',auth()->user()->id)->first();
            if($ch_day3)
            {
                $response['is_day3']='yes';
            }else{
                $response['is_day3']='no';
            }
        }else{
            $day3=null;
        }

        if(date('m',strtotime($day4)) == date('m',strtotime($day_date)) && strtotime($day4) <= strtotime($todays_dates))
        {
            $day4=$day4;
            $ch_day4=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day4)))->where('user_id',auth()->user()->id)->first();
            if($ch_day4)
            {
                $response['is_day4']='yes';
            }else{
                $response['is_day4']='no';
            }
        }else{
            $day4=null;
        }

        if(date('m',strtotime($day5)) == date('m',strtotime($day_date)) && strtotime($day5) <= strtotime($todays_dates))
        {
            $day5=$day5;
            $ch_day5=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day5)))->where('user_id',auth()->user()->id)->first();
            if($ch_day5)
            {
                $response['is_day5']='yes';
            }else{
                $response['is_day5']='no';
            }
        }else{
            $day5=null;
        }

        if(date('m',strtotime($day6)) == date('m',strtotime($day_date)) && strtotime($day6) <= strtotime($todays_dates))
        {
            $day6=$day6;
            $ch_day6=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day6)))->where('user_id',auth()->user()->id)->first();
            if($ch_day6)
            {
                $response['is_day6']='yes';
            }else{
                $response['is_day6']='no';
            }
        }else{
            $day6=null;
        }

        if(date('m',strtotime($day7)) == date('m',strtotime($day_date)) && strtotime($day7) <= strtotime($todays_dates))
        {
            $day7=$day7;
            $ch_day7=ExpenseDetail::whereDate('date',date('Y-m-d',   strtotime($day7)))->where('user_id',auth()->user()->id)->first();
            if($ch_day7)
            {
                $response['is_day7']='yes';
            }else{
                $response['is_day7']='no';
            }
        }else{
            $day7=null;
        }

      $start_week_date=null;
      $end_week_date=null;

      if(@$day1 != null)
      {
          $start_week_date=@$day1;
      }elseif(@$day2 != null && $start_week_date == null)
      {
          $start_week_date=@$day2;
      }elseif(@$day3 != null && $start_week_date == null)
      {
          $start_week_date=@$day3;
      }elseif(@$day4 != null && $start_week_date == null)
      {
          $start_week_date=@$day4;
      }
      elseif(@$day5 != null && $start_week_date == null)
      {
          $start_week_date=@$day5;
      }
      elseif(@$day6 != null && $start_week_date == null)
      {
          $start_week_date=@$day6;
      }
      elseif(@$day7 != null && $start_week_date == null)
      {
          $start_week_date=@$day7;
      }

      //for end week date
      if(@$day7 != null)
      {
          $end_week_date=@$day7;
      }elseif(@$day6 != null && $end_week_date == null)
      {
          $end_week_date=@$day6;
      }elseif(@$day5 != null && $end_week_date == null)
      {
          $end_week_date=@$day5;
      }elseif(@$day4 != null && $end_week_date == null)
      {
          $end_week_date=@$day4;
      }
      elseif(@$day3 != null && $end_week_date == null)
      {
          $end_week_date=@$day3;
      }
      elseif(@$day2 != null && $end_week_date == null)
      {
          $end_week_date=@$day2;
      }
      elseif(@$day1 != null && $end_week_date == null)
      {
          $end_week_date=@$day1;
      }


      $response['day1']=$day1;
      $response['day2']=$day2;
      $response['day3']=$day3;
      $response['day4']=$day4;
      $response['day5']=$day5;
      $response['day6']=$day6;
      $response['day7']=$day7;
      $response['selected_date']=$day_date;
    //   dd($response);

      $chk_date_weekefor_all =0;
      
          $chk_date_weeke_day_1=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day1)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day1)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_2=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day2)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day2)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_3=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day3)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day3)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_4=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day4)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day4)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_5=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day5)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day5)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_6=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day6)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day6)))->where('user_id',auth()->user()->id)->first();
          $chk_date_weeke_day_7=ExpenseMaster::whereDate('start_date','<=',date('Y-m-d',strtotime($day7)))->whereDate('end_date','>=',date('Y-m-d',strtotime($day7)))->where('user_id',auth()->user()->id)->first();

          if($chk_date_weeke_day_1 || $chk_date_weeke_day_2 || $chk_date_weeke_day_3 || $chk_date_weeke_day_4 || $chk_date_weeke_day_5 || $chk_date_weeke_day_6 || $chk_date_weeke_day_7)
          {
              $chk_date_weekefor_all = '1';
          }
          // dd($chk_date_weeke);
              if($chk_date_weekefor_all == '1')
              {
                  return 'yes';
              }else{
                  return 'no';
              }
          
      

     

      
      
    }

  
}
