<?php

namespace App\Http\Controllers\Modules\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseMaster;
use App\Models\ExpenseItemDoc;
use App\Models\ExpenseItem;
use App\Models\ExpenseDetail;
use App\Mail\ExpenseAdded;
use App\Models\User;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Mail;
use Storage;
use App\Jobs\SendExpenseEmail;

class ReportAjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function saveExpenseData(Request $request)
    {
        $expenseDetail = ExpenseDetail::where('date', date('Y-m-d', strtotime(@$request->day_date)))->first();
        $expenseMaster = ExpenseMaster::where('start_date',  date('Y-m-d', strtotime(@$request->start_date)))->orWhere('end_date',  date('Y-m-d', strtotime(@$request->end_date)))->first();
        if(!isset($expenseMaster)){
            $response['result']['status'] = "Success";
        $response['result']['error'] = "Expense Not Available";
        return response()->json($response);
        }
        $expenseItem = ExpenseItem::where('expense_detail_id', $expenseDetail->id)->latest()->first();
        if ($request->expense_type == 'Addition') {
            $expenseMaster->claimed_total = (float)$expenseMaster->claimed_total + (float)$request->expense_amount;
        } elseif ($request->expense_type == 'Subtraction') {
            $expenseMaster->claimed_total = (float)$expenseMaster->claimed_total - (float)$request->expense_amount;
        }
        $expenseMaster->save();

        foreach ($request->expense_supporting_document as $img_key => $row) {

            $count_img_2 = $request->expense_data_count[0];
            // dd($count_img_2,$count_imgs);
            // if ($img_key > $count_imgs && $img_key < $count_img_2) {
                if ($row != null) {
                    $img_ins['expense_item_id'] = $expenseItem->id;
                    $Image = $row;
                    $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                    Storage::putFileAs('public/report/rail', $Image, $filename);
                    $img_ins['doc_name'] = $filename;
                    if (@$Image->getClientOriginalExtension() == "pdf") {
                        $file_type = 'pdf';
                    } else {
                        $file_type = 'image';
                    }
                    $img_ins['file_type'] = $file_type;
                    ExpenseItemDoc::create($img_ins);
                }
            // }
        }

        $response['result']['status'] = "Success";
        $response['result']['error'] = "Data Saved";
        return response()->json($response);
    }
    public function reportSave(Request $request)
    {
        //print("<pre>".print_r($request->all(),true)."</pre>");die;

        #Check if report already exist or not
        $reportExist = ExpenseDetail::where('user_id', @$request->user_id)->where('date', date('Y-m-d', strtotime(@$request->day_date)))->first();

        $d_ins['date']              =  date('Y-m-d', strtotime(@$request->day_date));
        $d_ins['travelling_from']   =  @$request->travel_from ?? null;
        $d_ins['travelling_to']     =  @$request->travel_to ?? null;
        $d_ins['orvernight_at']     =  @$request->overnight_at ?? null;
        // $d_ins['day_city_name']     =  @$request->day_city;
        // $d_ins['day_pupose']        =  @$request->day_purpose;

        if (!$reportExist) {

            $chk_master = ExpenseMaster::whereDate('start_date',  $d_ins['date'])->whereDate('end_date', '>=', $d_ins['date'])->where('user_id', @$request->user_id)->first();
            // dd($chk_master,$d_ins['date']);
            #Insert into expense master table
            if (!$chk_master) {
                $m_ins['user_id']       =  @$request->user_id;
                $m_ins['type']          =  @$request->expense_type;
                //$m_ins['expense_unique_code']='WE'.auth()->user()->id.'-'.time();
                if (@$request->start_date) {
                    $m_ins['start_date']       =  date('Y-m-d', strtotime(@$request->start_date));
                }
                if (@$request->end_date) {
                    $m_ins['end_date']       =  date('Y-m-d', strtotime(@$request->end_date));
                }
                $m_ins['is_editable'] = 'Y';
                $res_master = ExpenseMaster::create($m_ins);

                $edit_expense_master_id = @$res_master->id;
            } else {
                $edit_expense_master_id = @$chk_master->id;
            }

            if (!$edit_expense_master_id) {

                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Insert into expense details table
            $d_ins['expense_master_id'] =  @$edit_expense_master_id;
            $d_ins['user_id']           =  @$request->user_id;
            $res_detail = ExpenseDetail::create($d_ins);
            $expense_detail_id = @$res_detail->id;
            $expense_master_id = @$edit_expense_master_id;
        } else {
            #update into expense details table
            $res_detail = ExpenseDetail::where('id', @$reportExist->id)->update($d_ins);
            $expense_detail_id = @$reportExist->id;
            $expense_master_id = @$reportExist->expense_master_id;
        }

        if (!$res_detail) {

            return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
        }

        $grand_total = 0;

        #Rail/Air
        if (@$request->type == 'R') {
            if (array_sum($request->rail_base_fare) > 0) {
                $rail_item_ids = array(); # to store all items ID
                $grand_total += array_sum($request->rail_base_fare) + array_sum($request->rail_gst_amount);
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $item_ids = array();
                if (@$request->rail_already_ids) {
                    $rail_previous_id = explode(',', @$request->rail_already_ids);
                    foreach ($rail_previous_id as $pre_list) {
                        $rail_prev_id = ExpenseItem::where('id', @$pre_list)->first();
                        if ($rail_prev_id) {
                            array_push($item_ids, $rail_prev_id->id);
                        }
                    }
                } else {
                    $item_ids = array();
                }

                // dd($item_ids,explode(',', @$request->rail_already_ids));
                $false_array_return_rail = [];
                $doc_count_array_return_rail = [];
                foreach ($request->rail_base_fare as $key => $rail) {
                    if ($rail > 0) {

                        $rail_ins['expense_detail_id']  =  @$expense_detail_id;
                        $rail_ins['type']               =  'R';
                        $rail_ins['basefare']           =  @$rail;
                        $rail_ins['gst_amount']         =  @$request->rail_gst_amount[$key];
                        $rail_ins['total']              =  @$request->rail_total[$key];
                        $rail_ins['gst_no']             =  @$request->rail_gst_number[$key] ? strtoupper(@$request->rail_gst_number[$key]) : '';
                        $rail_ins['remark']             =  @$request->rail_remark[$key];
                        $rail_ins['item_false_id']      =  @$request->rail_false_id[$key];


                        if (!empty(@$item_ids[$key])) {
                            #updating record
                            $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($rail_ins);
                            $exp_itemID = @$item_ids[$key];
                        } else {
                            #inserting record
                            $i_res = ExpenseItem::create($rail_ins);
                            $exp_itemID = @$i_res->id;
                        }

                        if (!$i_res) {
                            // dd($rail_ins);
                            return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                        }

                        #adding item ID to send in response
                        array_push($rail_item_ids, $exp_itemID);

                        #Rail Docs                        
                        if (!empty(@$request->rail_doc)) {

                            $count_imgs = 0;
                            if (@$request->rail_doc_count) {
                                foreach ($request->rail_doc_count as $count_key => $count_value) {
                                    if ($key != 0) {
                                        if ($count_key < $key) {
                                            $count_imgs = $count_imgs + $count_value - 1;
                                        } else {
                                            break;
                                        }
                                    } else {
                                        $count_imgs = -1;
                                    }
                                }
                            }

                            if (@$request->rail_doc_count[$key] > 0) {

                                //deleting previous files
                                // if(!empty(@$item_ids[$key])){
                                //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                                // }

                                if ($count_imgs < -1) {
                                    $count_imgs = -1;
                                }
                                foreach ($request->rail_doc as $img_key => $row) {

                                    $count_img_2 = $count_imgs + $request->rail_doc_count[$key] + 1;
                                    // dd($count_img_2,$count_imgs);
                                    if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                        if ($row != null) {
                                            $img_ins['expense_item_id'] = @$exp_itemID;
                                            $Image = $row;
                                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                            Storage::putFileAs('public/report/rail', $Image, $filename);
                                            $img_ins['doc_name'] = $filename;
                                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                                $file_type = 'pdf';
                                            } else {
                                                $file_type = 'image';
                                            }
                                            $img_ins['file_type'] = $file_type;
                                            ExpenseItemDoc::create($img_ins);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $false_return_rail = ExpenseItem::where('id', @$exp_itemID)->first();
                    array_push($false_array_return_rail, @$false_return_rail->item_false_id);

                    $doc_return_rail = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                    $count_doc_return_rail = count($doc_return_rail);
                    array_push($doc_count_array_return_rail, $count_doc_return_rail);
                }

                $response['result']['rail_item_ids'] = $rail_item_ids;

                $response['result']['rail_false_id'] = $false_array_return_rail;
                $response['result']['rail_doc_count'] = $doc_count_array_return_rail;
            }
        }

        #Taxi/Bus/Rickshaw
        if (@$request->type == 'T') {
            if (array_sum($request->taxi_base_fare) > 0) {
                $taxi_item_ids = array(); # to store all items ID
                $grand_total += array_sum($request->taxi_base_fare) + array_sum($request->taxi_gst_amount);
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $item_ids = array();
                if (@$request->taxi_already_ids) {
                    $taxi_previous_id = explode(',', @$request->taxi_already_ids);
                    foreach ($taxi_previous_id as $pre_list) {
                        $taxi_prev_id = ExpenseItem::where('id', @$pre_list)->first();
                        if ($taxi_prev_id) {
                            array_push($item_ids, $taxi_prev_id->id);
                        }
                    }
                }

                $false_array_return_taxi = [];
                $doc_count_array_return_taxi = [];
                foreach ($request->taxi_base_fare as $key => $taxi) {
                    if ($taxi > 0) {

                        $taxi_ins['expense_detail_id']  =  @$expense_detail_id;
                        $taxi_ins['type']               =  'T';
                        $taxi_ins['basefare']           =  @$taxi;
                        $taxi_ins['gst_amount']         =  @$request->taxi_gst_amount[$key];
                        $taxi_ins['total']              =  @$request->taxi_total[$key];
                        $taxi_ins['gst_no']             =  @$request->taxi_gst_number[$key] ? strtoupper(@$request->taxi_gst_number[$key]) : '';
                        $taxi_ins['remark']             =  @$request->taxi_remark[$key];
                        $taxi_ins['item_false_id']      =  @$request->taxi_false_id[$key];
                        $taxi_ins['taxi_option']      =  @$request->taxi_select[$key];

                        if (!empty(@$item_ids[$key])) {
                            #updating record
                            $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($taxi_ins);
                            $exp_itemID = @$item_ids[$key];
                        } else {
                            #inserting record
                            $i_res = ExpenseItem::create($taxi_ins);
                            $exp_itemID = @$i_res->id;
                        }

                        if (!$i_res) {
                            return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                        }

                        #adding item ID to send in response
                        array_push($taxi_item_ids, $exp_itemID);

                        #Taxi Docs                     
                        if (!empty(@$request->taxi_doc)) {

                            $count_imgs = 0;
                            if (@$request->taxi_doc_count) {
                                foreach ($request->taxi_doc_count as $count_key => $count_value) {
                                    if ($key != 0) {
                                        if ($count_key < $key) {
                                            $count_imgs = $count_imgs + $count_value - 1;
                                        } else {
                                            break;
                                        }
                                    } else {
                                        $count_imgs = -1;
                                    }
                                }
                            }

                            if (@$request->taxi_doc_count[$key] > 0) {

                                //deleting previous files
                                // if(!empty(@$item_ids[$key])){
                                //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                                // }

                                if ($count_imgs < -1) {
                                    $count_imgs = -1;
                                }

                                foreach ($request->taxi_doc as $img_key => $row) {
                                    $count_img_2 = $count_imgs + $request->taxi_doc_count[$key] + 1;
                                    if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                        if ($row != null) {
                                            $img_ins['expense_item_id'] = @$exp_itemID;
                                            $Image = $row;
                                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                            Storage::putFileAs('public/report/taxi', $Image, $filename);
                                            $img_ins['doc_name'] = $filename;
                                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                                $file_type = 'pdf';
                                            } else {
                                                $file_type = 'image';
                                            }
                                            $img_ins['file_type'] = $file_type;
                                            ExpenseItemDoc::create($img_ins);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $false_return_taxi = ExpenseItem::where('id', @$exp_itemID)->first();
                    array_push($false_array_return_taxi, @$false_return_taxi->item_false_id);

                    $doc_return_taxi = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                    $count_doc_return_taxi = count($doc_return_taxi);
                    array_push($doc_count_array_return_taxi, $count_doc_return_taxi);
                }
                $response['result']['taxi_item_ids'] = $taxi_item_ids;

                $response['result']['taxi_false_id'] = $false_array_return_taxi;
                $response['result']['taxi_doc_count'] = $doc_count_array_return_taxi;
            }
        }

        #Hotel
        if (@$request->type == 'H') {
            if (array_sum($request->hotel_base_fare) > 0) {

                $hotel_item_ids = array(); # to store all items ID
                $grand_total += array_sum($request->hotel_base_fare) + array_sum($request->hotel_gst_number);
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $item_ids = array();
                if (@$request->hotel_already_ids) {
                    // $item_ids = explode(',', @$request->hotel_already_ids);
                    $hotel_previous_id = explode(',', @$request->hotel_already_ids);
                    foreach ($hotel_previous_id as $pre_list) {
                        $hotel_prev_id = ExpenseItem::where('id', @$pre_list)->first();
                        if ($hotel_prev_id) {
                            array_push($item_ids, $hotel_prev_id->id);
                        }
                    }
                } else {
                    $item_ids = array();
                }
                $false_array_return_hotel = [];
                $doc_count_array_return_hotel = [];

                foreach ($request->hotel_base_fare as $key => $hotel) {
                    if ($hotel > 0) {
                        $hotel_ins['expense_detail_id'] =  @$expense_detail_id;
                        $hotel_ins['type']              =  'H';
                        $hotel_ins['basefare']          =  @$hotel;
                        $hotel_ins['gst_amount']        =  @$request->hotel_gst_amount[$key];
                        $hotel_ins['total']             =  @$request->hotel_total[$key];
                        $hotel_ins['gst_no']            =  strtoupper(@$request->hotel_gst_number[$key]);
                        $hotel_ins['remark']            =  @$request->hotel_remark[$key];
                        $hotel_ins['hotel_name']        =  @$request->hotel_name[$key];
                        $hotel_ins['hotel_city']        =  @$request->hotel_city[$key];
                        $hotel_ins['item_false_id']      =  @$request->hotel_false_id[$key];

                        if (@$item_ids[$key]) {
                            #updating record
                            $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($hotel_ins);
                            $exp_itemID = @$item_ids[$key];
                        } else {
                            #inserting record
                            $i_res = ExpenseItem::create($hotel_ins);
                            $exp_itemID = @$i_res->id;
                        }

                        if (!$i_res) {
                            return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                        }

                        #adding item ID to send in response
                        array_push($hotel_item_ids, $exp_itemID);

                        #Hotel Docs                     
                        if (!empty(@$request->hotel_doc)) {

                            $count_imgs = 0;
                            if (@$request->hotel_doc_count) {
                                foreach ($request->hotel_doc_count as $count_key => $count_value) {
                                    if ($key != 0) {
                                        if ($count_key < $key) {
                                            $count_imgs = $count_imgs + $count_value - 1;
                                        } else {
                                            break;
                                        }
                                    } else {
                                        $count_imgs = -1;
                                    }
                                }
                            }

                            if (@$request->hotel_doc_count[$key] > 0) {

                                //deleting previous files
                                // if(!empty(@$item_ids[$key])){
                                //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                                // }

                                if ($count_imgs < -1) {
                                    $count_imgs = -1;
                                }

                                foreach ($request->hotel_doc as $img_key => $row) {
                                    $count_img_2 = $count_imgs + $request->hotel_doc_count[$key] + 1;
                                    if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                        if ($row != null) {
                                            $img_ins['expense_item_id'] = @$exp_itemID;
                                            $Image = $row;
                                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                            Storage::putFileAs('public/report/hotel', $Image, $filename);
                                            $img_ins['doc_name'] = $filename;
                                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                                $file_type = 'pdf';
                                            } else {
                                                $file_type = 'image';
                                            }
                                            $img_ins['file_type'] = $file_type;
                                            ExpenseItemDoc::create($img_ins);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $false_return_hotel = ExpenseItem::where('id', @$exp_itemID)->first();
                    array_push($false_array_return_hotel, @$false_return_hotel->item_false_id);

                    $doc_return_hotel = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                    $count_doc_return_hotel = count($doc_return_hotel);
                    array_push($doc_count_array_return_hotel, $count_doc_return_hotel);
                }

                $response['result']['hotel_item_ids'] = $hotel_item_ids;

                $response['result']['hotel_false_id'] = $false_array_return_hotel;
                $response['result']['hotel_doc_count'] = $doc_count_array_return_hotel;
            }
        }

        #Laundry Charges
        if (@$request->type == 'L') {
            if (@$request->laundry_base_fare > 0) {
                $laundry_item_ids = ""; # to store all items ID
                $grand_total += $request->laundry_base_fare + $request->laundry_gst_amount;
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $laun_ins['expense_detail_id']  =  @$expense_detail_id;
                $laun_ins['type']               =  'L';
                $laun_ins['basefare']           =  @$request->laundry_base_fare;
                $laun_ins['gst_amount']         =  @$request->laundry_gst_amount;
                $laun_ins['total']              =  @$request->laundry_total;
                $laun_ins['gst_no']             =  @$request->laundry_gst_number ? strtoupper(@$request->laundry_gst_number) : '';
                $laun_ins['remark']             =  @$request->laundry_remark;
                $laun_ins['hotel_name']         =  @$request->laundry_name;
                $laun_ins['hotel_city']         =  @$request->laundry_city;

                if (@$request->laundry_already_ids) {
                    #updating record
                    $i_res = ExpenseItem::where('id', @$request->laundry_already_ids)->update($laun_ins);
                    $exp_itemID = @$request->laundry_already_ids;
                } else {
                    #inserting record
                    $i_res = ExpenseItem::create($laun_ins);
                    $exp_itemID = @$i_res->id;
                }

                if (!$i_res) {
                    return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                }


                #Laundry Docs                     
                if (!empty(@$request->laundry_doc)) {

                    // if(@$request->laundry_already_ids){
                    //     ExpenseItemDoc::where('expense_item_id',@$request->laundry_already_ids)->delete(); 
                    // }

                    foreach ($request->laundry_doc as $row) {
                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/laundry', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }

                $doc_return_laundry = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                $count_doc_return_laundry = count($doc_return_laundry);
                $response['result']['laundry_doc_count'] = $count_doc_return_laundry;

                $response['result']['laundry_item_ids'] = @$exp_itemID;
            }
        }

        #Breakfast Charges
        if (@$request->type == 'B') {
            if (@$request->breakfast_amount > 0) {
                $breakfast_item_ids = ""; # to store all items ID
                $grand_total += $request->breakfast_amount;
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $break_ins['expense_detail_id'] =  @$expense_detail_id;
                $break_ins['type']              =  'B';
                $break_ins['basefare']          =  @$request->breakfast_amount;
                $break_ins['total']             =  @$request->breakfast_amount;
                $break_ins['remark']            =  @$request->breakfast_remark;

                if (@$request->breakfast_already_ids) {
                    #updating record
                    $i_res = ExpenseItem::where('id', @$request->breakfast_already_ids)->update($break_ins);
                    $exp_itemID = @$request->breakfast_already_ids;
                } else {
                    #inserting record
                    $i_res = ExpenseItem::create($break_ins);
                    $exp_itemID = @$i_res->id;
                }

                if (!$i_res) {
                    return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                }

                #Breakfast Docs                     
                if (!empty(@$request->breakfast_doc)) {

                    // if(@$request->breakfast_already_ids){
                    //     ExpenseItemDoc::where('expense_item_id',@$request->breakfast_already_ids)->delete(); 
                    // }

                    foreach ($request->breakfast_doc as $row) {
                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/breakfast', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }
                $doc_return_breakfast = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                $count_doc_return_breakfast = count($doc_return_breakfast);
                $response['result']['breakfast_doc_count'] = $count_doc_return_breakfast;

                $response['result']['breakfast_item_ids'] = $exp_itemID;
            }
        }

        #Lunch Charges
        if (@$request->type == 'LU') {
            if (@$request->lunch_amount > 0) {
                $lunch_item_ids = ""; # to store all items ID
                $grand_total += $request->lunch_amount;
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $lunch_ins['expense_detail_id'] =  @$expense_detail_id;
                $lunch_ins['type']              =  'LU';
                $lunch_ins['basefare']          =  @$request->lunch_amount;
                $lunch_ins['total']             =  @$request->lunch_amount;
                $lunch_ins['remark']            =  @$request->lunch_remark;

                if (@$request->lunch_already_ids) {
                    #updating record
                    $i_res = ExpenseItem::where('id', @$request->lunch_already_ids)->update($lunch_ins);
                    $exp_itemID = @$request->lunch_already_ids;
                } else {
                    #inserting record
                    $i_res = ExpenseItem::create($lunch_ins);
                    $exp_itemID = @$i_res->id;
                }

                if (!$i_res) {
                    return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                }

                #Lunch Docs                     
                if (!empty(@$request->lunch_doc)) {

                    // if(@$request->lunch_already_ids){
                    //     ExpenseItemDoc::where('expense_item_id',@$request->lunch_already_ids)->delete(); 
                    // }

                    foreach ($request->lunch_doc as $row) {

                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/lunch', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }
                $doc_return_lunch = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                $count_doc_return_lunch = count($doc_return_lunch);
                $response['result']['lunch_doc_count'] = $count_doc_return_lunch;

                $response['result']['lunch_item_ids'] = $exp_itemID;
            }
        }

        #Dinner
        if (@$request->type == 'D') {
            if (@$request->dinner_amount > 0) {
                $dinner_item_ids = ""; # to store all items ID
                $grand_total += $request->dinner_amount;
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $dinner_ins['expense_detail_id']    =  @$expense_detail_id;
                $dinner_ins['type']                 =  'D';
                $dinner_ins['basefare']             =  @$request->dinner_amount;
                $dinner_ins['total']                =  @$request->dinner_amount;
                $dinner_ins['remark']               =  @$request->dinner_remark;

                if (@$request->dinner_already_ids) {
                    #updating record
                    $i_res = ExpenseItem::where('id', @$request->dinner_already_ids)->update($dinner_ins);
                    $exp_itemID = @$request->dinner_already_ids;
                } else {
                    #inserting record
                    $i_res = ExpenseItem::create($dinner_ins);
                    $exp_itemID = @$i_res->id;
                }

                if (!$i_res) {
                    return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                }

                #Dinner Docs                     
                if (!empty(@$request->dinner_doc)) {

                    // if(@$request->dinner_already_ids){
                    //     ExpenseItemDoc::where('expense_item_id',@$request->dinner_already_ids)->delete(); 
                    // }

                    foreach ($request->dinner_doc as $row) {

                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/dinner', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }

                $doc_return_dinner = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                $count_doc_return_dinner = count($doc_return_dinner);
                $response['result']['dinner_doc_count'] = $count_doc_return_dinner;

                $response['result']['dinner_item_ids'] = $exp_itemID;
            }
        }

        #Phone
        if (@$request->type == 'P') {
            if (@$request->phone_base_fare > 0) {
                $phone_item_ids = ""; # to store all items ID
                $grand_total += $request->phone_total;
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $phone_ins['expense_detail_id']   =  @$expense_detail_id;
                $phone_ins['type']                =  'P';
                $phone_ins['basefare']            =  @$request->phone_base_fare;
                $phone_ins['gst_amount']          =  @$request->phone_gst_amount;
                $phone_ins['total']               =  @$request->phone_total;
                $phone_ins['gst_no']              =  @$request->phone_gst_number ? strtoupper(@$request->phone_gst_number) : '';
                $phone_ins['remark']              =  @$request->phone_remark;

                if (@$request->phone_already_ids) {
                    #updating record
                    $i_res = ExpenseItem::where('id', @$request->phone_already_ids)->update($phone_ins);
                    $exp_itemID = @$request->phone_already_ids;
                } else {
                    #inserting record
                    $i_res = ExpenseItem::create($phone_ins);
                    $exp_itemID = @$i_res->id;
                }

                if (!$i_res) {
                    return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                }

                #Phone Docs                     
                if (!empty(@$request->phone_doc)) {

                    // if(@$request->phone_already_ids){
                    //     ExpenseItemDoc::where('expense_item_id',@$request->phone_already_ids)->delete(); 
                    // }

                    foreach ($request->phone_doc as $row) {

                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/phone', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }

                $doc_return_phone = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                $count_doc_return_phone = count($doc_return_phone);
                $response['result']['phone_doc_count'] = $count_doc_return_phone;

                $response['result']['phone_item_ids'] = $exp_itemID;
            }
        }

        #Local Convayence
        // if(@$request->type == 'LC'){
        //     if(@$request->local_base_fare > 0)
        //     {
        //         $local_item_ids = ""; # to store all items ID
        //         $grand_total += $request->local_total;

        //         $local_ins['expense_detail_id'] =  @$expense_detail_id; 
        //         $local_ins['type']              =  'LC';
        //         $local_ins['basefare']          =  @$request->local_base_fare;
        //         $local_ins['gst_amount']        =  @$request->local_gst_amount;
        //         $local_ins['total']             =  @$request->local_total;
        //         $local_ins['gst_no']            =  @$request->local_gst_number ? strtoupper(@$request->local_gst_number) : '';
        //         $local_ins['remark']            =  @$request->local_remark;
        //         $local_ins['hotel_name']        =  @$request->local_name;
        //         $local_ins['hotel_city']        =  @$request->local_city;

        //         if(@$request->local_already_ids){
        //             #updating record
        //             $i_res = ExpenseItem::where('id',@$request->local_already_ids)->update($local_ins);
        //             $exp_itemID = @$request->local_already_ids;

        //         }else{
        //             #inserting record
        //             $i_res = ExpenseItem::create($local_ins);
        //             $exp_itemID = @$i_res->id;
        //         }

        //         if(!$i_res){
        //             return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
        //         }

        //         #Local Docs                     
        //         if(!empty(@$request->local_doc)){

        //             // if(@$request->local_already_ids){
        //             //     ExpenseItemDoc::where('expense_item_id',@$request->local_already_ids)->delete(); 
        //             // }

        //             foreach ($request->local_doc as $row) 
        //             {

        //                 if($row != null)
        //                 {
        //                     $img_ins['expense_item_id'] = @$exp_itemID; 
        //                     $Image = $row;
        //                     $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
        //                     Storage::putFileAs('public/report/local', $Image, $filename);
        //                     $img_ins['doc_name'] = $filename;   
        //                     if(@$Image->getClientOriginalExtension() == "pdf"){
        //                         $file_type = 'pdf';
        //                     }else{
        //                         $file_type = 'image';
        //                     }  
        //                     $img_ins['file_type'] = $file_type;               
        //                     ExpenseItemDoc::create($img_ins);     
        //                 }

        //             }
        //         }

        //         $doc_return_local= ExpenseItemDoc::where('expense_item_id',@$exp_itemID)->get();
        //         $count_doc_return_local=count($doc_return_local);
        //         $response['result']['local_doc_count'] = $count_doc_return_local;

        //         $response['result']['local_item_ids'] = $exp_itemID;
        //     }
        // }

        #Miscellaneous
        if (@$request->type == 'M') {
            if (array_sum($request->misce_base_fare) > 0) {
                $misc_item_ids = array(); # to store all items ID
                $grand_total += array_sum($request->misce_base_fare) + array_sum($request->misce_gst_amount);
                if ($grand_total > 100000) {
                    $response['result']['status'] = "error";
                    $response['result']['error'] = "Total Expense of week should be Less or Equal to 1 Lakh !";
                    return response()->json($response);
                }
                $item_ids = array();
                if (@$request->misce_already_ids) {
                    // $item_ids = explode(',', @$request->misce_already_ids);

                    $misce_previous_id = explode(',', @$request->misce_already_ids);
                    foreach ($misce_previous_id as $pre_list) {
                        $misce_prev_id = ExpenseItem::where('id', @$pre_list)->first();
                        if ($misce_prev_id) {
                            array_push($item_ids, $misce_prev_id->id);
                        }
                    }
                } else {
                    $item_ids = array();
                }
                $false_array_return_misc = [];
                $doc_count_array_return_misc = [];

                foreach ($request->misce_base_fare as $key => $misce) {
                    if ($misce > 0) {
                        $misce_ins['expense_detail_id'] =  @$expense_detail_id;
                        $misce_ins['type']              =  'M';
                        $misce_ins['basefare']          =  @$misce;
                        $misce_ins['gst_amount']        =  @$request->misce_gst_amount[$key];
                        $misce_ins['total']             =  @$request->misce_total[$key];
                        $misce_ins['gst_no']            =  @$request->misce_gst_number[$key] ? strtoupper(@$request->misce_gst_number[$key]) : '';
                        $misce_ins['remark']            =  @$request->misce_remark[$key];
                        $misce_ins['item_false_id']      =  @$request->misce_false_id[$key];
                        $misce_ins['misce_option']      =  @$request->misce_select[$key];

                        if (@$item_ids[$key]) {
                            #updating record
                            $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($misce_ins);
                            $exp_itemID = @$item_ids[$key];
                        } else {
                            #inserting record
                            $i_res = ExpenseItem::create($misce_ins);
                            $exp_itemID = @$i_res->id;
                        }

                        if (!$i_res) {
                            return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
                        }

                        #adding item ID to send in response
                        array_push($misc_item_ids, $exp_itemID);

                        #Misc Docs                     
                        if (!empty(@$request->misce_doc)) {

                            $count_imgs = 0;
                            if (@$request->misce_doc_count) {
                                foreach ($request->misce_doc_count as $count_key => $count_value) {
                                    if ($key != 0) {
                                        if ($count_key < $key) {
                                            $count_imgs = $count_imgs + $count_value - 1;
                                        } else {
                                            break;
                                        }
                                    } else {
                                        $count_imgs = -1;
                                    }
                                }
                            }

                            if (@$request->misce_doc_count[$key] > 0) {

                                //deleting previous files
                                // if(!empty(@$item_ids[$key])){
                                //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                                // }

                                if ($count_imgs < -1) {
                                    $count_imgs = -1;
                                }

                                foreach ($request->misce_doc as $img_key => $row) {
                                    $count_img_2 = $count_imgs + $request->misce_doc_count[$key] + 1;
                                    if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                        if ($row != null) {
                                            $img_ins['expense_item_id'] = @$exp_itemID;
                                            $Image = $row;
                                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                            Storage::putFileAs('public/report/misce', $Image, $filename);
                                            $img_ins['doc_name'] = $filename;
                                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                                $file_type = 'pdf';
                                            } else {
                                                $file_type = 'image';
                                            }
                                            $img_ins['file_type'] = $file_type;
                                            ExpenseItemDoc::create($img_ins);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $false_return_misc = ExpenseItem::where('id', @$exp_itemID)->first();
                    array_push($false_array_return_misc, @$false_return_misc->item_false_id);

                    $doc_return_misc = ExpenseItemDoc::where('expense_item_id', @$exp_itemID)->get();
                    $count_doc_return_misc = count($doc_return_misc);
                    array_push($doc_count_array_return_misc, $count_doc_return_misc);
                }

                $response['result']['misc_item_ids'] = $misc_item_ids;

                $response['result']['misc_false_id'] = $false_array_return_misc;
                $response['result']['misc_doc_count'] = $doc_count_array_return_misc;
            }
        }

        #get total amount 
        $total_claimed_amt = ExpenseItem::where('expense_detail_id', @$expense_detail_id)->sum('total');

        #update Grandtotal amount in expense details table
        $upd['days_total'] =  @$total_claimed_amt;
        ExpenseDetail::where('id', @$expense_detail_id)->where('expense_master_id', @$expense_master_id)->where('user_id', @$request->user_id)->update($upd);

        $tot_cliamed_amt_all_detail = ExpenseDetail::where('expense_master_id', $expense_master_id)->sum('days_total');
        //dd($tot_cliamed_amt_all_detail,$total_claimed_amt,@$request->user_id,@$expense_master_id);
        #update Grandtotal amount in expense master table
        $update['claimed_total'] =  @$tot_cliamed_amt_all_detail;
        $update['is_editable'] = 'Y';
        ExpenseMaster::where('id', @$expense_master_id)->where('user_id', @$request->user_id)->update($update);

        $response['result']['status'] = "Success";
        $response['result']['expense_detail_id'] = @$expense_detail_id;
        $response['result']['expense_master_id'] = @$expense_master_id;
        $response['result']['expense_detail'] = ExpenseDetail::where('id', @$expense_detail_id)->with('getExpenseMaster', 'getExpenseItemRail', 'getExpenseItemTaxi', 'getExpenseItemHotel', 'getExpenseItemLaundry', 'getExpenseItemBreakfast', 'getExpenseItemLunch', 'getExpenseItemDinner', 'getExpenseItemPhone', 'getExpenseItemLocal', 'getExpenseItemMisce')->first();
        // ['DIR', 'AHY', 'ACH', 'ACA', 'HR', 'A', 'AA', 'E'] 
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
            Mail::to($user->pro_email)->send(new ExpenseAdded($expense_detail_id, $user_id));
        }
        }
        return response()->json($response);
    }

    public function report_submit(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'day_city'      => 'required',
            'day_purpose'   => 'required',
        ]);

        #Check if report already exist or not
        $report = ExpenseDetail::where('id', @$request->expense_detail_id)->where('user_id', @$request->user_id)->where('date', date('Y-m-d', strtotime(@$request->day_date)))->first();

        if (@$report) {
            $up['orvernight_at'] = @$request->overnight_at;
            $up['day_city_name'] = @$request->day_city;
            $up['day_pupose'] = @$request->day_purpose;
            $up['status'] = 'S';
            // dd($up);
            $res_detail = ExpenseDetail::where('id', @$report->id)->update($up);
            // $res_master = ExpenseMaster::where('id',@$report->expense_master_id)->where('user_id',@$request->user_id)->update($up);

            if ($res_detail) {
                return redirect()->route('employee.edit.report', ['id' => @$report->id])->with('success', 'Expenses report saved successfully');
                // return redirect()->back()->with('success','Expenses report saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            return redirect()->back()->with('error', 'No record found! Please submit atleast one expense item.');
        }
    }
    public function report_submit2(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'day_date'      => 'required',
            'travel_from'   => 'required',
            'travel_to'     => 'required',
            'overnight_at'  => 'required',
            'day_city'      => 'required',
            'day_purpose'   => 'required',
        ]);

        #Check if report already exist or not
        $reportExist = ExpenseDetail::where('user_id', @$request->user_id)->where('date', date('Y-m-d', strtotime(@$request->day_date)))->first();

        $d_ins['date']                  =   date('Y-m-d', strtotime(@$request->day_date));
        $d_ins['travelling_from']       =   @$request->travel_from;
        $d_ins['travelling_to']         =   @$request->travel_to;
        $d_ins['orvernight_at']         =   @$request->overnight_at;
        $d_ins['day_city_name']         =   @$request->day_city;
        $d_ins['day_pupose']            =   @$request->day_purpose;

        if (!$reportExist) {

            #Insert into expense master table
            $m_ins['user_id']       =   @$request->user_id;
            $m_ins['type']          =   'WE';
            $m_ins['claimed_total'] =   @$request->grand_total_show;
            // $m_ins['approved_total']=0;
            $res_master = ExpenseMaster::create($m_ins);
            if (!$res_master) {
                return redirect()->back()->with('error', 'Something went wrong');
            }

            #Insert into expense details table
            $d_ins['expense_master_id'] =  @$res_master->id;
            $d_ins['user_id']           =  @$request->user_id;
            $d_ins['days_total']        =  @$m_ins['claimed_total'];
            $res_detail = ExpenseDetail::create($d_ins);
            $expense_detail_id = @$res_detail->id;
            $expense_master_id = @$res_master->id;
        } else {
            #update into expense details table
            $res_detail = ExpenseDetail::where('id', @$reportExist->id)->update($d_ins);
            $expense_detail_id = @$reportExist->id;
            $expense_master_id = @$reportExist->expense_master_id;
        }

        if (!$res_detail) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        #Rail/Air
        if (array_sum($request->rail_base_fare) > 0) {
            if (@$request->rail_already_ids) {
                $item_ids = explode(',', @$request->rail_already_ids);
            } else {
                $item_ids = array();
            }

            foreach ($request->rail_base_fare as $key => $rail) {
                if ($rail > 0) {
                    $rail_ins['expense_detail_id']  =  @$expense_detail_id;
                    $rail_ins['type']               =  'R';
                    $rail_ins['basefare']           =  @$rail;
                    $rail_ins['gst_amount']         =  @$request->rail_gst_amount[$key];
                    $rail_ins['total']              =  @$request->rail_total[$key];
                    $rail_ins['gst_no']             =  @$request->rail_gst_number[$key];
                    $rail_ins['remark']             =  @$request->rail_remark[$key];

                    if (!empty(@$item_ids[$key])) {
                        #updating record
                        $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($rail_ins);
                        $exp_itemID = @$item_ids[$key];
                    } else {
                        #inserting record
                        $i_res = ExpenseItem::create($rail_ins);
                        $exp_itemID = @$i_res->id;
                    }

                    if (!$i_res) {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }

                    $count_imgs = 0;
                    if (@$request->rail_doc_count) {
                        foreach ($request->rail_doc_count as $count_key => $count_value) {
                            if ($key != 0) {
                                if ($count_key < $key) {
                                    $count_imgs = $count_imgs + $count_value - 1;
                                } else {
                                    break;
                                }
                            } else {
                                $count_imgs = -1;
                            }
                        }
                    }

                    #Rail Docs                        
                    if (!empty(@$request->rail_doc)) {

                        // if(!empty(@$item_ids[$key]) && !empty(@$request->rail_doc_count)){
                        //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                        // }

                        foreach ($request->rail_doc as $img_key => $row) {
                            $count_img_2 = $count_imgs + $request->rail_doc_count[$key] + 1;
                            if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                if ($row != null) {
                                    $img_ins['expense_item_id'] = @$exp_itemID;
                                    $Image = $row;
                                    $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                    Storage::putFileAs('public/report/rail', $Image, $filename);
                                    $img_ins['doc_name'] = $filename;
                                    if (@$Image->getClientOriginalExtension() == "pdf") {
                                        $file_type = 'pdf';
                                    } else {
                                        $file_type = 'image';
                                    }
                                    $img_ins['file_type'] = $file_type;
                                    ExpenseItemDoc::create($img_ins);
                                }
                            }
                        }
                    }
                }
            }
        }

        #Taxi/Bus/Rickshaw
        if (array_sum($request->taxi_base_fare) > 0) {
            if (@$request->taxi_already_ids) {
                $item_ids = explode(',', @$request->taxi_already_ids);
            } else {
                $item_ids = array();
            }

            foreach ($request->taxi_base_fare as $key => $taxi) {
                if ($taxi > 0) {
                    $taxi_ins['expense_detail_id']  =  @$expense_detail_id;
                    $taxi_ins['type']               =  'T';
                    $taxi_ins['basefare']           =  @$taxi;
                    $taxi_ins['gst_amount']         =  @$request->taxi_gst_amount[$key];
                    $taxi_ins['total']              =  @$request->taxi_total[$key];
                    $taxi_ins['gst_no']             =  @$request->taxi_gst_number[$key];
                    $taxi_ins['remark']             =  @$request->taxi_remark[$key];

                    if (!empty(@$item_ids[$key])) {
                        #updating record
                        $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($taxi_ins);
                        $exp_itemID = @$item_ids[$key];
                    } else {
                        #inserting record
                        $i_res = ExpenseItem::create($taxi_ins);
                        $exp_itemID = @$i_res->id;
                    }

                    if (!$i_res) {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }

                    #Taxi Docs                     
                    if (!empty(@$request->taxi_doc)) {

                        // if(!empty(@$item_ids[$key])){
                        //     ExpenseItemDoc::where('expense_item_id',@$item_ids[$key])->delete(); 
                        // }

                        $count_imgs = 0;
                        if (@$request->taxi_doc_count) {
                            foreach ($request->taxi_doc_count as $count_key => $count_value) {
                                if ($key != 0) {
                                    if ($count_key < $key) {
                                        $count_imgs = $count_imgs + $count_value - 1;
                                    } else {
                                        break;
                                    }
                                } else {
                                    $count_imgs = -1;
                                }
                            }
                        }

                        foreach ($request->taxi_doc as $img_key => $row) {
                            $count_img_2 = $count_imgs + $request->taxi_doc_count[$key] + 1;
                            if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                if ($row != null) {
                                    $img_ins['expense_item_id'] = @$exp_itemID;
                                    $Image = $row;
                                    $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                    Storage::putFileAs('public/report/taxi', $Image, $filename);
                                    $img_ins['doc_name'] = $filename;
                                    if (@$Image->getClientOriginalExtension() == "pdf") {
                                        $file_type = 'pdf';
                                    } else {
                                        $file_type = 'image';
                                    }
                                    $img_ins['file_type'] = $file_type;
                                    ExpenseItemDoc::create($img_ins);
                                }
                            }
                        }
                    }
                }
            }
        }


        #Hotel
        if (array_sum($request->hotel_base_fare) > 0) {
            if (@$request->hotel_already_ids) {
                $item_ids = explode(',', @$request->hotel_already_ids);
            } else {
                $item_ids = array();
            }

            foreach ($request->hotel_base_fare as $key => $hotel) {
                if ($hotel > 0) {
                    $hotel_ins['expense_detail_id'] =  @$expense_detail_id;
                    $hotel_ins['type']              =  'H';
                    $hotel_ins['basefare']          =  @$hotel;
                    $hotel_ins['gst_amount']        =  @$request->hotel_gst_amount[$key];
                    $hotel_ins['total']             =  @$request->hotel_total[$key];
                    $hotel_ins['gst_no']            =  @$request->hotel_gst_number[$key];
                    $hotel_ins['remark']            =  @$request->hotel_remark[$key];
                    $hotel_ins['hotel_name']        =  @$request->hotel_name[$key];
                    $hotel_ins['hotel_city']        =  @$request->hotel_city[$key];

                    if (@$item_ids[$key]) {
                        #updating record
                        $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($hotel_ins);
                        $exp_itemID = @$item_ids[$key];
                    } else {
                        #inserting record
                        $i_res = ExpenseItem::create($hotel_ins);
                        $exp_itemID = @$i_res->id;
                    }

                    if (!$i_res) {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }

                    #Hotel Docs                     
                    if (!empty(@$request->hotel_doc)) {

                        if (@$item_ids[$key]) {
                            ExpenseItemDoc::where('expense_item_id', @$item_ids[$key])->delete();
                        }

                        $count_imgs = 0;
                        if (@$request->hotel_doc_count) {
                            foreach ($request->hotel_doc_count as $count_key => $count_value) {
                                if ($key != 0) {
                                    if ($count_key < $key) {
                                        $count_imgs = $count_imgs + $count_value - 1;
                                    } else {
                                        break;
                                    }
                                } else {
                                    $count_imgs = -1;
                                }
                            }
                        }

                        foreach ($request->hotel_doc as $img_key => $row) {
                            $count_img_2 = $count_imgs + $request->hotel_doc_count[$key] + 1;
                            if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                if ($row != null) {
                                    $img_ins['expense_item_id'] = @$exp_itemID;
                                    $Image = $row;
                                    $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                    Storage::putFileAs('public/report/hotel', $Image, $filename);
                                    $img_ins['doc_name'] = $filename;
                                    if (@$Image->getClientOriginalExtension() == "pdf") {
                                        $file_type = 'pdf';
                                    } else {
                                        $file_type = 'image';
                                    }
                                    $img_ins['file_type'] = $file_type;
                                    ExpenseItemDoc::create($img_ins);
                                }
                            }
                        }
                    }
                }
            }
        }

        #Laundry Charges
        if (@$request->laundry_base_fare > 0) {
            $laun_ins['expense_detail_id']  =  @$expense_detail_id;
            $laun_ins['type']               =  'L';
            $laun_ins['basefare']           =  @$request->laundry_base_fare;
            $laun_ins['gst_amount']         =  @$request->laundry_gst_amount;
            $laun_ins['total']              =  @$request->laundry_total;
            $laun_ins['gst_no']             =  @$request->laundry_gst_number;
            $laun_ins['remark']             =  @$request->laundry_remark;
            $laun_ins['hotel_name']         =  @$request->laundry_name;
            $laun_ins['hotel_city']         =  @$request->laundry_city;

            if (@$request->laundry_already_ids) {
                #updating record
                $i_res = ExpenseItem::where('id', @$request->laundry_already_ids)->update($laun_ins);
                $exp_itemID = @$request->laundry_already_ids;
            } else {
                #inserting record
                $i_res = ExpenseItem::create($laun_ins);
                $exp_itemID = @$i_res->id;
            }

            if (!$i_res) {
                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Laundry Docs                     
            if (!empty(@$request->laundry_doc)) {

                if (@$request->laundry_already_ids) {
                    ExpenseItemDoc::where('expense_item_id', @$request->laundry_already_ids)->delete();
                }

                foreach ($request->laundry_doc as $row) {

                    if ($row != null) {
                        $img_ins['expense_item_id'] = @$exp_itemID;
                        $Image = $row;
                        $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                        Storage::putFileAs('public/report/laundry', $Image, $filename);
                        $img_ins['doc_name'] = $filename;
                        if (@$Image->getClientOriginalExtension() == "pdf") {
                            $file_type = 'pdf';
                        } else {
                            $file_type = 'image';
                        }
                        $img_ins['file_type'] = $file_type;
                        ExpenseItemDoc::create($img_ins);
                    }
                }
            }
        }

        #Breakfast Charges
        if (@$request->breakfast_amount > 0) {
            $break_ins['expense_detail_id'] =  @$expense_detail_id;
            $break_ins['type']              =  'B';
            $break_ins['basefare']          =  @$request->breakfast_amount;
            $break_ins['total']             =  @$request->breakfast_amount;
            $break_ins['remark']            =  @$request->breakfast_remark;

            if (@$request->breakfast_already_ids) {
                #updating record
                $i_res = ExpenseItem::where('id', @$request->breakfast_already_ids)->update($break_ins);
                $exp_itemID = @$request->breakfast_already_ids;
            } else {
                #inserting record
                $i_res = ExpenseItem::create($break_ins);
                $exp_itemID = @$i_res->id;
            }

            if (!$i_res) {
                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Breakfast Docs                     
            if (!empty(@$request->breakfast_doc)) {

                if (@$request->breakfast_already_ids) {
                    ExpenseItemDoc::where('expense_item_id', @$request->breakfast_already_ids)->delete();
                }

                if ($request->breakfast_doc) {
                    foreach ($request->breakfast_doc as $row) {

                        if ($row != null) {
                            $img_ins['expense_item_id'] = @$exp_itemID;
                            $Image = $row;
                            $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                            Storage::putFileAs('public/report/breakfast', $Image, $filename);
                            $img_ins['doc_name'] = $filename;
                            if (@$Image->getClientOriginalExtension() == "pdf") {
                                $file_type = 'pdf';
                            } else {
                                $file_type = 'image';
                            }
                            $img_ins['file_type'] = $file_type;
                            ExpenseItemDoc::create($img_ins);
                        }
                    }
                }
            }
        }

        #Lunch Charges
        if (@$request->lunch_amount > 0) {
            $lunch_ins['expense_detail_id'] =  @$expense_detail_id;
            $lunch_ins['type']              =  'LU';
            $lunch_ins['basefare']          =  @$request->lunch_amount;
            $lunch_ins['total']             =  @$request->lunch_amount;
            $lunch_ins['remark']            =  @$request->lunch_remark;

            if (@$request->lunch_already_ids) {
                #updating record
                $i_res = ExpenseItem::where('id', @$request->lunch_already_ids)->update($lunch_ins);
                $exp_itemID = @$request->lunch_already_ids;
            } else {
                #inserting record
                $i_res = ExpenseItem::create($lunch_ins);
                $exp_itemID = @$i_res->id;
            }

            if (!$i_res) {
                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Lunch Docs                     
            if (!empty(@$request->lunch_doc)) {

                if (@$request->lunch_already_ids) {
                    ExpenseItemDoc::where('expense_item_id', @$request->lunch_already_ids)->delete();
                }

                foreach ($request->lunch_doc as $row) {

                    if ($row != null) {
                        $img_ins['expense_item_id'] = @$exp_itemID;
                        $Image = $row;
                        $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                        Storage::putFileAs('public/report/lunch', $Image, $filename);
                        $img_ins['doc_name'] = $filename;
                        if (@$Image->getClientOriginalExtension() == "pdf") {
                            $file_type = 'pdf';
                        } else {
                            $file_type = 'image';
                        }
                        $img_ins['file_type'] = $file_type;
                        ExpenseItemDoc::create($img_ins);
                    }
                }
            }
        }

        #Dinner
        if (@$request->dinner_amount > 0) {
            $dinner_ins['expense_detail_id']    =  @$expense_detail_id;
            $dinner_ins['type']                 =  'D';
            $dinner_ins['basefare']             =  @$request->dinner_amount;
            $dinner_ins['total']                =  @$request->dinner_amount;
            $dinner_ins['remark']               =  @$request->dinner_remark;

            if (@$request->dinner_already_ids) {
                #updating record
                $i_res = ExpenseItem::where('id', @$request->dinner_already_ids)->update($dinner_ins);
                $exp_itemID = @$request->dinner_already_ids;
            } else {
                #inserting record
                $i_res = ExpenseItem::create($dinner_ins);
                $exp_itemID = @$i_res->id;
            }

            if (!$i_res) {
                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Dinner Docs                     
            if (!empty(@$request->dinner_doc)) {

                if (@$request->dinner_already_ids) {
                    ExpenseItemDoc::where('expense_item_id', @$request->dinner_already_ids)->delete();
                }
                foreach ($request->dinner_doc as $row) {

                    if ($row != null) {
                        $img_ins['expense_item_id'] = @$exp_itemID;
                        $Image = $row;
                        $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                        Storage::putFileAs('public/report/dinner', $Image, $filename);
                        $img_ins['doc_name'] = $filename;
                        if (@$Image->getClientOriginalExtension() == "pdf") {
                            $file_type = 'pdf';
                        } else {
                            $file_type = 'image';
                        }
                        $img_ins['file_type'] = $file_type;
                        ExpenseItemDoc::create($img_ins);
                    }
                }
            }
        }

        #Phone
        if (@$request->phone_base_fare > 0) {
            $phone_ins['expense_detail_id']   =  @$expense_detail_id;
            $phone_ins['type']                =  'P';
            $phone_ins['basefare']            =  @$request->phone_base_fare;
            $phone_ins['gst_amount']          =  @$request->phone_gst_amount;
            $phone_ins['total']               =  @$request->phone_total;
            $phone_ins['gst_no']              =  @$request->phone_gst_number;
            $phone_ins['remark']              =  @$request->phone_remark;

            if (@$request->phone_already_ids) {
                #updating record
                $i_res = ExpenseItem::where('id', @$request->phone_already_ids)->update($phone_ins);
                $exp_itemID = @$request->phone_already_ids;
            } else {
                #inserting record
                $i_res = ExpenseItem::create($phone_ins);
                $exp_itemID = @$i_res->id;
            }

            if (!$i_res) {
                return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
            }

            #Phone Docs                     
            if (!empty(@$request->phone_doc)) {

                if (@$request->phone_already_ids) {
                    ExpenseItemDoc::where('expense_item_id', @$request->phone_already_ids)->delete();
                }

                foreach ($request->phone_doc as $row) {

                    if ($row != null) {
                        $img_ins['expense_item_id'] = @$exp_itemID;
                        $Image = $row;
                        $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                        Storage::putFileAs('public/report/phone', $Image, $filename);
                        $img_ins['doc_name'] = $filename;
                        if (@$Image->getClientOriginalExtension() == "pdf") {
                            $file_type = 'pdf';
                        } else {
                            $file_type = 'image';
                        }
                        $img_ins['file_type'] = $file_type;
                        ExpenseItemDoc::create($img_ins);
                    }
                }
            }
        }

        #Local Convayence
        // if(@$request->local_base_fare > 0)
        // {
        //     $local_ins['expense_detail_id'] =  @$expense_detail_id; 
        //     $local_ins['type']              =  'LC';
        //     $local_ins['basefare']          =  @$request->local_base_fare;
        //     $local_ins['gst_amount']        =  @$request->local_gst_amount;
        //     $local_ins['total']             =  @$request->local_total;
        //     $local_ins['gst_no']            =  @$request->local_gst_number;
        //     $local_ins['remark']            =  @$request->local_remark;
        //     $local_ins['hotel_name']        =  @$request->local_name;
        //     $local_ins['hotel_city']        =  @$request->local_city;

        //     if(@$request->local_already_ids){
        //         #updating record
        //         $i_res = ExpenseItem::where('id',@$request->local_already_ids)->update($local_ins);
        //         $exp_itemID = @$request->local_already_ids;

        //     }else{
        //         #inserting record
        //         $i_res = ExpenseItem::create($local_ins);
        //         $exp_itemID = @$i_res->id;
        //     }

        //     if(!$i_res){
        //         return response()->json(array('status' => 'Failed', 'error' => "Something went wrong!"));
        //     }

        //     #Local Docs                     
        //     if(!empty(@$request->local_doc)){

        //         if(@$request->local_already_ids){
        //             ExpenseItemDoc::where('expense_item_id',@$request->local_already_ids)->delete(); 
        //         }
        //             foreach ($request->local_doc as $row) 
        //             {

        //                 if($row != null)
        //                 {
        //                     $img_ins['expense_item_id'] = @$exp_itemID; 
        //                     $Image = $row;
        //                     $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
        //                     Storage::putFileAs('public/report/local', $Image, $filename);
        //                     $img_ins['doc_name'] = $filename;    
        //                     if(@$Image->getClientOriginalExtension() == "pdf"){
        //                         $file_type = 'pdf';
        //                     }else{
        //                         $file_type = 'image';
        //                     }  
        //                     $img_ins['file_type'] = $file_type;              
        //                     ExpenseItemDoc::create($img_ins);     
        //                 }

        //             }
        //     }

        // }

        #Miscellaneous
        if (array_sum($request->misce_base_fare) > 0) {
            if (@$request->misce_already_ids) {
                $item_ids = explode(',', @$request->misce_already_ids);
            } else {
                $item_ids = array();
            }

            foreach ($request->misce_base_fare as $key => $misce) {
                if ($misce > 0) {
                    $misce_ins['expense_detail_id'] =  @$expense_detail_id;
                    $misce_ins['type']              =  'M';
                    $misce_ins['basefare']          =  @$misce;
                    $misce_ins['gst_amount']        =  @$request->misce_gst_amount[$key];
                    $misce_ins['total']             =  @$request->misce_total[$key];
                    $misce_ins['gst_no']            =  @$request->misce_gst_number[$key];
                    $misce_ins['remark']            =  @$request->misce_remark[$key];

                    if (@$item_ids[$key]) {
                        #updating record
                        $i_res = ExpenseItem::where('id', @$item_ids[$key])->update($misce_ins);
                        $exp_itemID = @$item_ids[$key];
                    } else {
                        #inserting record
                        $i_res = ExpenseItem::create($misce_ins);
                        $exp_itemID = @$i_res->id;
                    }

                    if (!$i_res) {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }

                    #Misc Docs                     
                    if (!empty(@$request->misce_doc)) {

                        if (@$item_ids[$key]) {
                            ExpenseItemDoc::where('expense_item_id', @$item_ids[$key])->delete();
                        }

                        $count_imgs = 0;
                        if (@$request->misce_doc_count) {
                            foreach ($request->misce_doc_count as $count_key => $count_value) {
                                if ($key != 0) {
                                    if ($count_key < $key) {
                                        $count_imgs = $count_imgs + $count_value - 1;
                                    } else {
                                        break;
                                    }
                                } else {
                                    $count_imgs = -1;
                                }
                            }
                        }
                        foreach ($request->misce_doc as $img_key => $row) {
                            $count_img_2 = $count_imgs + $request->misce_doc_count[$key] + 1;
                            if ($img_key > $count_imgs && $img_key < $count_img_2) {
                                if ($row != null) {
                                    $img_ins['expense_item_id'] = @$exp_itemID;
                                    $Image = $row;
                                    $filename = time() . '-' . rand(1000, 9999) . '.' . $Image->getClientOriginalExtension();
                                    Storage::putFileAs('public/report/misce', $Image, $filename);
                                    $img_ins['doc_name'] = $filename;
                                    if (@$Image->getClientOriginalExtension() == "pdf") {
                                        $file_type = 'pdf';
                                    } else {
                                        $file_type = 'image';
                                    }
                                    $img_ins['file_type'] = $file_type;
                                    ExpenseItemDoc::create($img_ins);
                                }
                            }
                        }
                    }
                }
            }
        }

        #get total amount 
        $total_claimed_amt = ExpenseItem::where('expense_detail_id', @$expense_detail_id)->sum('total');

        #update Grandtotal amount in expense master table
        $update['claimed_total'] =  @$total_claimed_amt;
        //ExpenseMaster::where('id',@$expense_master_id)->where('user_id',@$request->user_id)->update($update);

        #update Grandtotal amount in expense details table
        $upd['days_total'] =  @$total_claimed_amt;
        //ExpenseDetail::where('id',@$expense_detail_id)->where('expense_master_id',@$expense_master_id)->where('user_id',@$request->user_id)->update($upd);

        return redirect()->back()->with('success', 'Report added successfully');
    }


    //Developer : Pawan
    //Method : for showing docs and image of report through ajax
    //date : 29-03-2023

    public function show_all_docs(Request $request)
    {
        $id = @$request->id;
        if (!$id) {
            $response['result']['img_status'] = 'Failed';
        }
        $response['result']['img_status'] = 'OK';
        $chk_details = ExpenseItem::where('id', $id)->first();
        $chk_doc = ExpenseItemDoc::where('expense_item_id', $id)->get();

        $response['result']['img_doc'] = $chk_doc;
        $response['result']['item_type'] = $chk_details->type;
        $response['result']['doc_count'] = count($chk_doc);
        return response()->json($response);
    }

    public function delete_particular_doc(Request $request)
    {
        $id = @$request->doc_id;
        $item_id = @$request->item_id;
        if (!$id || !$item_id) {
            $response['result']['error'] = 'yes';
            return response()->json($response);
        }
        $chk = ExpenseItemDoc::where('id', @$id)->first();
        $chk_item = ExpenseItem::where('id', @$item_id)->first();
        if (!$chk || !$chk_item) {
            $response['result']['error'] = 'yes';
            return response()->json($response);
        }

        if ($chk->doc_name) {
            if (@$chk_item->type == 'R') {
                @unlink(storage_path('app/public/report/rail/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'T') {
                @unlink(storage_path('app/public/report/taxi/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'H') {
                @unlink(storage_path('app/public/report/hotel/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'L') {
                @unlink(storage_path('app/public/report/laundry/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'B') {
                @unlink(storage_path('app/public/report/breakfast/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'LU') {
                @unlink(storage_path('app/public/report/lunch/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'D') {
                @unlink(storage_path('app/public/report/dinner/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'P') {
                @unlink(storage_path('app/public/report/phone/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'LC') {
                @unlink(storage_path('app/public/report/local/' . @$chk->doc_name));
            } elseif (@$chk_item->type == 'M') {
                @unlink(storage_path('app/public/report/misce/' . @$chk->doc_name));
            }
        }


        $result = ExpenseItemDoc::where('id', @$id)->delete();
        if ($result) {
            $count = ExpenseItemDoc::where('expense_item_id', @$chk->expense_item_id)->get();
            $response['result']['doc_count_shw'] = count($count);
            $response['result']['error'] = 'No';
            return response()->json($response);
        } else {
            $response['result']['error'] = 'yes';
            return response()->json($response);
        }
    }



    //Developer : Pawan
    //Method : for showing docs and image of report through ajax during add
    //date : 18-04-2023

    public function show_all_docs_add(Request $request)
    {
        $false_id = @$request->false_id;
        $exp_detail_id = @$request->exp_detail_id;
        $type = @$request->type;

        if (!$false_id || !$exp_detail_id || !$type) {
            $response['result']['img_status'] = 'Failed';
            return response()->json($response);
        }
        if ($type == 'R' || $type == 'T' || $type == 'H' || $type == 'M') {
            $is_item = ExpenseItem::where('item_false_id', $false_id)->where('expense_detail_id', $exp_detail_id)->where('type', $type)->first();
        } else {
            $is_item = ExpenseItem::where('expense_detail_id', $exp_detail_id)->where('type', $type)->first();
        }

        if (!$is_item) {
            $response['result']['img_status'] = 'No found Expense item';
            return response()->json($response);
        }
        $id = @$is_item->id;
        if (!$id) {
            $response['result']['img_status'] = 'Failed';
        }
        $response['result']['img_status'] = 'OK';
        $chk_details = ExpenseItem::where('id', $id)->first();
        $chk_doc = ExpenseItemDoc::where('expense_item_id', $id)->get();

        $response['result']['img_doc'] = $chk_doc;
        $response['result']['item_type'] = $chk_details->type;
        $response['result']['doc_count'] = count($chk_doc);
        return response()->json($response);
    }




    //Developer : Pawan
    //Method : for deleteing particular rows od report
    //date : 13-04-2023

    public function remove_report_row(Request $request)
    {
        $row_false_id = @$request->row_id;
        $expense_detail_id = @$request->expense_detail_id;
        $type = @$request->type;
        if ($row_false_id && $expense_detail_id && $type) {
            $chk = ExpenseItem::where('expense_detail_id', $expense_detail_id)->where('type', $type)->where('item_false_id', $row_false_id)->first();
            if (!$chk) {
                $response['result']['error'] = 'yes';
                return response()->json($response);
            }



            $result = ExpenseItem::where('id', $chk->id)->delete();
            $expense_doc = ExpenseItemDoc::where('expense_item_id', @$chk->id)->get();
            if ($expense_doc->isNotEmpty()) {
                foreach ($expense_doc as $list) {
                    if (@$chk->type == 'R') {
                        @unlink(storage_path('app/public/report/rail/' . @$list->doc_name));
                    } elseif (@$chk->type == 'T') {
                        @unlink(storage_path('app/public/report/taxi/' . @$list->doc_name));
                    } elseif (@$chk->type == 'H') {
                        @unlink(storage_path('app/public/report/hotel/' . @$list->doc_name));
                    } elseif (@$chk->type == 'L') {
                        @unlink(storage_path('app/public/report/laundry/' . @$list->doc_name));
                    } elseif (@$chk->type == 'B') {
                        @unlink(storage_path('app/public/report/breakfast/' . @$list->doc_name));
                    } elseif (@$chk->type == 'LU') {
                        @unlink(storage_path('app/public/report/lunch/' . @$list->doc_name));
                    } elseif (@$chk->type == 'D') {
                        @unlink(storage_path('app/public/report/dinner/' . @$list->doc_name));
                    } elseif (@$chk->type == 'P') {
                        @unlink(storage_path('app/public/report/phone/' . @$list->doc_name));
                    } elseif (@$chk->type == 'LC') {
                        @unlink(storage_path('app/public/report/local/' . @$list->doc_name));
                    } elseif (@$chk->type == 'M') {
                        @unlink(storage_path('app/public/report/misce/' . @$list->doc_name));
                    }
                }
            }
            ExpenseItemDoc::where('expense_item_id', @$chk->id)->delete();
            $calu_all = ExpenseItem::where('expense_detail_id', $expense_detail_id)->get();


            if ($calu_all->isNotEmpty()) {
                $updas['days_total'] = $calu_all->sum('total');
                ExpenseDetail::where('id', @$expense_detail_id)->update($updas);
            }

            $chk_ecp_deta = ExpenseDetail::where('id', @$expense_detail_id)->first();
            if ($chk_ecp_deta) {
                if ($chk_ecp_deta->days_approved > 0) {

                    $items = ExpenseItem::where('expense_detail_id', @$expense_detail_id)->get();

                    #all items approved amount
                    $total_approved_amt = 0;
                    // $test=array();
                    if (!empty(@$items)) {
                        foreach (@$items as $item) {
                            if (@$item->approved_amount > 0) {
                                // array_push($test,$item->approved_amount);
                                $total_approved_amt += $item->approved_amount;
                            } else {
                                // array_push($test,$item->total);
                                $total_approved_amt += $item->total;
                            }
                        }
                    }
                    $upde['days_approved'] = $total_approved_amt;
                    ExpenseDetail::where('id', @$expense_detail_id)->update($upde);

                    $weekData = ExpenseDetail::where('expense_master_id', @$chk_ecp_deta->expense_master_id)->get();
                    $sumTotal = 0;
                    $act_sum_total = 0;
                    if (!empty(@$weekData)) {
                        foreach (@$weekData as $data) {
                            if (@$data->days_approved > 0) {
                                $sumTotal += $data->days_approved;
                            } else {
                                $sumTotal += $data->days_total;
                            }
                            $act_sum_total += $data->days_total;
                        }
                    }

                    $upMaster['approved_total'] =  @$sumTotal;
                    $upMaster['claimed_total'] =  @$act_sum_total;
                    ExpenseMaster::where('id', @$chk_ecp_deta->expense_master_id)->where('user_id', @$chk_ecp_deta->user_id)->update($upMaster);
                }
            }

            $calu_all_23 = ExpenseItem::where('expense_detail_id', $expense_detail_id)->where('type', $type)->get();
            $misc_item_ids = array();
            if ($calu_all_23->isNotEmpty()) {
                foreach ($calu_all_23 as $calu) {
                    array_push($misc_item_ids, $calu->id);
                }
            }

            $last_id = ExpenseItem::where('expense_detail_id', $expense_detail_id)->where('type', $type)->orderBy('item_false_id', 'desc')->first();
            $response['result']['all_prev_ids'] = $misc_item_ids;
            $response['result']['last_id'] = $last_id->item_false_id;
            if ($result) {
                $response['result']['approv_amt'] = @$total_approved_amt;
                $response['result']['error'] = 'No';
                return response()->json($response);
            } else {
                $response['result']['error'] = 'yes';
                return response()->json($response);
            }
        } else {
            $response['result']['error'] = 'yes';
            return response()->json($response);
        }
    }
}
