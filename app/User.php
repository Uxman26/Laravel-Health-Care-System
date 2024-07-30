<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $guarded = [];

  

    public function getCountry(){
        return $this->hasOne('App\Models\Country','id','country');
    }

 

    public function getState(){
        return $this->hasOne('App\Models\State','id','state');
    }

  
    
    // public function getSubAdmin(){

    //     return $this->hasOne('App\Admin','id','subadmin_id');
    // }

 

 
}
