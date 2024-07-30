<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseMaster extends Model
{
    use HasFactory; 
    protected $table = "expense_master";
    protected $guarded=[];

    public function getUser(){
        return $this->hasOne('App\User','id','user_id'); 
    }

    public function getExpenseDetail(){
        return $this->hasOne('App\Models\ExpenseDetail','expense_master_id','id');
    }

    public function getExpenseDetailMany(){
        return $this->hasMany('App\Models\ExpenseDetail','expense_master_id','id');
    }
    
    public function getMemo(){
        return $this->hasOne('App\Models\Memo','expense_master_id','id');
    }

    public function getCommentExpDetail(){
        return $this->hasOne('App\Models\ExpenseDetail','expense_master_id','id')->where('is_admin_commented','Y');
    }
  

    
}
