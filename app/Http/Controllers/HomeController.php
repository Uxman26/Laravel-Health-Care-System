<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Mail;
use App\Mail\HomeEmail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        if(Auth::user()->user_type != 'E'){
            return redirect()->route('all.reports');
        }

        return view('modules.report.report');
    }

}
