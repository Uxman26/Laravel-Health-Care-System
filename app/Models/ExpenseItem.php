<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;
    protected $table = "expense_items";
    protected $guarded=[];

    public function getExpenseItemDoc(){
        return $this->hasMany('App\Models\ExpenseItemDoc','expense_item_id','id');
    }
}
