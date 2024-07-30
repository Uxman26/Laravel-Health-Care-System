<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Country;
use App\Models\Phonecode;
use App\User;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Validation\Rule;
// use Socialite;
use DB;
use Session;
use Mail;
use App\Mail\RegisterMail; 
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Redirect;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    
     protected $redirectTo = '/';

    public function __construct() 
    {
        $this->middleware(function ($request, $next) {
            if ( \request()->get( 'ref' )) {
               session()->put( 'redirect_link', \request()->get( 'ref' ));
               $this->data = Session::get('redirect_link');
            }
        return $next($request);
        }); 
        
        $this->middleware('guest')->except(['logout']);
    }


    protected function guard()
    {
        return Auth::guard();
    }

    public function showUserLoginForm(Request $request)
    { 
       
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);


       
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $fields = array(
            "userName"=> @$request->empID,
            "password"=> @$request->password,
            "application"=>"login",
        );

        //dd($fields);
        
        $headers = array(
            'Content-Type: application/json'
        );

        # Initializing Curl
        $ch = curl_init();

        # Posting data to the following URL
        $url = 'https://sso.heterohcl.com/heteroiconnect/loginaction/login';
        curl_setopt($ch, CURLOPT_URL, $url);

        # Post Data = True, Defining Headers and SSL Verifier = false
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # Posting fields array in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        # Executing Curl
        $response = curl_exec($ch);
        # Closing Curl
        $err = curl_error($ch);
        curl_close($ch);

        $arrayResult= json_decode($response);
        // dd($arrayResult);

        // if(!$arrayResult->status){
        //     return redirect()->back()->with('error',"Credentials do not match!");
        //  }
      
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();

        if(!$user){ 
            $ins['name']        =   @$arrayResult->user->name;
            $ins['empID']       =   $request->empID;
            $ins['mobile']      =   @$arrayResult->user->personal_PHONE;
            $ins['designation'] =   @$arrayResult->user->designation;
            $ins['department']  =   @$arrayResult->user->department;
            $ins['division']    =   @$arrayResult->user->division;
            $ins['password']    =   Hash::make($request->password);
            
            $ins['pro_email']    =   @$arrayResult->user->proemail;

            if(@$arrayResult->user->empID == '50202')
            {
                $ins['user_type']    = 'AA';
            }elseif(@$arrayResult->user->empID == '20113')
            {
                $ins['user_type']    = 'A';
            }elseif(@$arrayResult->user->empID == '10183')
            {
                $ins['user_type']    = 'HR';
            }elseif(@$arrayResult->user->empID == '50184' || @$arrayResult->user->empID == '50136')
            {
                $ins['user_type']    = 'ACA';
            }elseif(@$arrayResult->user->empID == '10327')
            {
                $ins['user_type']    = 'ACH';
            }elseif(@$arrayResult->user->empID == '50251')
            {
                $ins['user_type']    = 'AHY';
            }else{
                $ins['user_type']    = 'E';
            }
            $ins['status']      =   "A";

            $result=User::create($ins);
        }else{
            
            $update['mobile']      =   @$arrayResult->user->personal_PHONE;
            $update['designation'] =   @$arrayResult->user->designation;
            $update['department']  =   @$arrayResult->user->department;
            $update['division']    =   @$arrayResult->user->division;

            $update['pro_email']    =   @$arrayResult->user->proemail;

            if(@$arrayResult->user->empID == '50202')
            {
                $update['user_type']    = 'AA';
            }elseif(@$arrayResult->user->empID == '20113')
            {
                $update['user_type']    = 'A';
            }elseif(@$arrayResult->user->empID == '10183')
            {
                $update['user_type']    = 'HR';
            }elseif(@$arrayResult->user->empID == '50184' || @$arrayResult->user->empID == '50136')
            {
                $update['user_type']    = 'ACA';
            }elseif(@$arrayResult->user->empID == '10327')
            {
                $update['user_type']    = 'ACH';
            }elseif(@$arrayResult->user->empID == '50251')
            {
                $update['user_type']    = 'AHY';
            }else{
                $update['user_type']    = 'E';
            }
            $update['password']    =   Hash::make($request->password);

            $result=User::where('id',@$user->id)->update($update);
        }
        
        // if($user && \Hash::check($request->password, $user->password))
        // {
			
        //     if($user->status == 'I')
        //     {
        //         return redirect()->back()->with('error','Your account is blocked by admin. Please contact with the admin for further information.');
        //     }
        // }
       
        if ($this->attemptLogin($request)) {
            //dd($request->all());
            
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
       
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        
      
        return $this->guard()->attempt(
            
            $this->credentials($request)
        );
      
    }

    /**
     * Get the needed authorization credentials from the request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        
        
        $credentials = $request->only($this->username(), 'password');
        return  $credentials;
    }
  

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'empID' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
       
        $errors =  [$this->username() => trans('auth.failed')];

        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();
        // dd(\Hash::check($request->password, $user->password));
        // dd(\Hash::make($request->password));
      
        $flag=1;
        // if ($user && \Hash::check($request->password, $user->password)) {
        //     $flag=1;
        //     $errors = [$this->username() => 'Account deactivated or Invalid Credentials'];
            
           
        // }
        // if($flag==0){
        //     if ($user && \Hash::check($request->password, $user->password) && $user->status == 'I') {
        //         $errors = [$this->username() => 'Your account is not active.'];
        //     }
        //     if ($user && \Hash::check($request->password, $user->password) && $user->status == 'D') {
        //         $errors = [$this->username() => 'Your account is deleted.'];
        //     }
        //     if ($user && \Hash::check($request->password, $user->password) && $user->status == 'U') {
        //         $errors = [$this->username() => 'Your account is not verified.'];
        //     }
        // }
            

        

        if($request->expectsJson()){
          return response()->json()($errors, 422);
        }

        
        
        if($flag==0){
            return redirect()->route('login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
        }else{

        }
       
        
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response 
     */
    protected function sendLoginResponse(Request $request)
    {
       
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        // $user=\App\Models\User::where($this->username(), $request->{$this->username()})->first();
        
       
        // $user->update([
        // 'email_otp' => Null, 

        // ]);
        Session::flash('success',"You are successfully logged in now.");
        if(session()->has('redirect_link'))
        {
            return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended(session()->get('redirect_link'));
          
        }else{
            return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
        }
       
    }

    public function username()
    {
        return 'empID';
    }
     
    

    public function logout(Request $request)
    {

        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    // public function logout(Request $request)
    // {
    //     $lastUserID = Auth::user() ? auth()->user()->id : '';   
    //     $this->guard()->logout();
    //     $request->session()->invalidate();
    //     Session::put('authID', $lastUserID);
    //     return $this->loggedOut($request) ?: redirect('/login');
    // }


}