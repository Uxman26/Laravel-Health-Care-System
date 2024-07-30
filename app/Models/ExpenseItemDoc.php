<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItemDoc extends Model
{
    use HasFactory;
    protected $table = "expense_item_docs";
    protected $guarded=[];

    public function getExpenseItem(){
        return $this->hasOne('App\Models\ExpenseItem','id','expense_item_id');
    }
}
