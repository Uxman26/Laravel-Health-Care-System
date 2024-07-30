<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function view_reset(Request $request, $vcode = null ,$id=null)
    {
       
        if(!$vcode)
        {
            return redirect()->back()->with('error', 'Link is expired');
        }
        $chkTocken=User::where('id',$id)->where('email_code',@$vcode)->where('status','!=','D')->first();
        if($chkTocken && $vcode){
            $data['user']=$chkTocken;
            $data['vcode']=$vcode;
            return view('auth.passwords.reset',$data);
        }else{
            return redirect()->route('forget.password')->with('error', 'Link is expired');
        }
       
    }

    public function reset_password(Request $request)
    {
        if($request->password == $request->confirm_password && $request->password){
            $update['password'] = Hash::make($request->password);
                $update['email_code'] = null;
                $user = User::where('id',$request->user_id)->Where('email_code',@$request->vcode)->update($update);
            if($user) {
                return redirect()->route('login')->with('success','Password change successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong, Please try again. IF this happening many times then contact with admin');
            }
        } else {
            return redirect()->back()->with('error','Please Enter same password as confirm password ');
        }
    }

  
}
