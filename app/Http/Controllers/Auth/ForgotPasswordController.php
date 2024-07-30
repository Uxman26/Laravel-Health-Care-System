<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Mail;
use App\Mail\RegisterMail;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function forget_password()
    {
        return view('auth.forget_password');
    }

    public function do_forget_password(Request $request)
    {
        $check=User::where('email',$request->email)->where('status','!=','D')->first();
        if($check)
        {

            $data['email'] = $request->email;
            $user = User::where('email',$request->email)->first();
            if(!@$user){
                return redirect()->back()->with('error',\Lang::get('static.nofoundmsg'));
            }
            $vcode = mt_rand(100000, 999999);
            User::where('email',$request->email)->update(['email_code'=>$vcode]);
            $data['link'] = route('reset.password',['vcode'=>$vcode,'id'=>$check->id]);
            $data['name'] = $user->first_name.' '.$user->last_name;;
            $data['msg1'] ='For change your Password. Please click below link';
            $data['mailBody'] = 'Forgot-Password';
            Mail::send(new RegisterMail($data));
            return redirect()->back()->with('success','Forgot Password change link is successfully sent to your email');
        }else{
            return redirect()->back()->with('error','User not Found');
        }
    }

 


}
