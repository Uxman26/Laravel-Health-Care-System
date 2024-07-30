<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    use HasFactory;
    protected $table = "exepense_details";
    protected $guarded=[];


    

    public function getExpenseMaster(){
        return $this->hasOne('App\Models\ExpenseMaster','id','expense_master_id');
    }

    public function getExpenseItemRail(){
        return $this->hasMany('App\Models\ExpenseItem','expense_detail_id','id')->where('type','R');
    }

    public function getExpenseItemTaxi(){
        return $this->hasMany('App\Models\ExpenseItem','expense_detail_id','id')->where('type','T');
    }
    public function getExpenseItemHotel(){
        return $this->hasMany('App\Models\ExpenseItem','expense_detail_id','id')->where('type','H');
    }

    public function getExpenseItemLaundry(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','L');
    }

    public function getExpenseItemBreakfast(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','B');
    }

    public function getExpenseItemLunch(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','LU');
    }
    public function getExpenseItemDinner(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','D');
    }
    public function getExpenseItemPhone(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','P');
    }
    public function getExpenseItemLocal(){
        return $this->hasOne('App\Models\ExpenseItem','expense_detail_id','id')->where('type','LC');
    }

    public function getExpenseItemMisce(){
        return $this->hasMany('App\Models\ExpenseItem','expense_detail_id','id')->where('type','M');
    }
    
    

}
