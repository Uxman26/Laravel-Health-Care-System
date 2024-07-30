<?php

namespace App\Http\Controllers\Auth;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Mail;

use Illuminate\Validation\Rule;
use App\Mail\RegisterMail;
;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */



    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
      * Show Register Form
      *
      * @return void
      */

    protected function register()  
    {
        return view('auth.register');
    }


    public function do_regiratration(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=> 'required',
            'password'=>'required | min:6',
            'password2'=>'required | min:6',
        ]);

            $ins['first_name']=$request->first_name;
           $ins['last_name']=$request->last_name;
           $ins['email']=$request->email;
           $ins['ph_number']=$request->phone;
           $ins['password']=Hash::make($request->password);
           
           $ins['email_code'] = mt_rand(100000, 999999);
           $result=User::create($ins);
           $upd['slug']=$result->first_name.'-'.$result->last_name.'-'.$result->id;
           
           User::where('id',$result->id)->update($upd);

           $data['name'] = $result->first_name.' '.$result->last_name;
           $data['link'] = route('registration.verify',['vcode' => $ins['email_code'],'id'=>$result->id]);
            $data['email_code'] = $ins['email_code'];
            $data['email'] = $ins['email'];
            $data['msg1'] = 'Please verify your email by clicking on below button';
            $data['mailBody'] = 'Registration-Link';
            Mail::send(new RegisterMail($data));

            if($result){
                Session::flash('success',"Verification Link is sent to your email. Please verify and login in");
                return redirect()->back();
             // return view('modules.message.message');
            }else{
                return redirect()->back()->with('error','Something went wrong. Please contact with Admin');
            }
    }


    public function user_verify($vcode,$id)
    {
        $chk_id = User::where('id',@$id)->first();
            if($chk_id->status == 'U')
            {
                $chkTocken = User::where('id',@$id)->where('email_code',@$vcode)->first();
                if(!@$chkTocken){
                    
                    Session::flash('error',"Link is expired");
                    return view('modules.message.message');
                }else{
                    $update['email_code'] = null;
                    $update['status'] = 'A';
                    $update['is_email_verified'] = 'Y';
                    $user = User::Where('id',$chk_id->id)->update($update);
                    if($user) {
                      
                        Session::flash('success',"Your email is successfully verified. Now you can log in ");
                        return view('modules.message.message');
                    } else {
                       
                        Session::flash('error',"Something went wrong. Please contact Admin");
                        return view('modules.message.message');
                    }
                }
            }else{
             
                Session::flash('success','Your account is already verified. Please Login ');
                return view('modules.message.message');
            }
    }



    

    
    
     
    

    public function userEmailCheck(Request $request)
    {

     $user = User::where('email', trim($request->email))->where('status', '!=', 'D')->first();
      if(@$user) {
          return response('false');
      } else {
          return response('true');
      }
    }

     

    



    


}