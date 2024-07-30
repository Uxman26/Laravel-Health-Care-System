<?php

namespace App\Http\Controllers\Modules\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
        // $this->middleware('guest')->except(['handleProviderCallback','logout']);
    }
    


}
