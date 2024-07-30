<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordRequest extends Model
{
    use HasFactory;
    protected $table = "password_request";
    protected $guarded=[];

    public function getUser(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
