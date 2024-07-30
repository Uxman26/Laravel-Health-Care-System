<?php

namespace App\Http\Controllers\Modules\PasswordRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordRequest;
use Hash;

class PasswordRequestController extends Controller
{
    public function password_view()
    {
        if(auth()->user()->user_type != 'E')
        {
            return redirect()->back();
        }
       
        return view('modules.password.password_view');
    }

    public function save_password(Request $request)
    {
        // dd($request->all());
        

        if(@$request->request_type == 'NP')
        {
            if($request->new_password && $request->old_password)
            {
                $request->validate([
                    'old_password' => 'required',
                    'confirm_password' => 'required',
                ]);
                if($request->new_password == $request->confirm_password){
                    $check=User::where('id',auth()->user()->id)->first();
                    if (Hash::check($request->old_password, $check->password)) {
                        $upd['password']=Hash::make($request->new_password);
                    }
                }else{
                    return redirect()->back()->with('error','Please enter same new password as confirm password');
                }
    
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
            $Chk_pass=PasswordRequest::where('user_id',auth()->user()->id)->where('status','N')->where('request_type','NP')->first();
            if($Chk_pass)
            {
                return redirect()->back()->with('error','You have already request for new password. Please wait until admin takes any action');
            }
            $ins['name']=auth()->user()->name;
            $ins['user_id']=auth()->user()->id;
            $ins['request_type']='NP';
        }else{
            $request->validate([ 
                'empID' => 'required',
            ]);
            
            $chk=User::where('empID',@$request->empID)->first();
            if(!$chk)
            {
                return redirect()->back()->with('error','User not found!!')->withInput();
            }
            $Chk_pass=PasswordRequest::where('user_id',@$chk->id)->where('status','N')->where('request_type','FP')->first();
            if($Chk_pass)
            {
                return redirect()->back()->with('error','You have already request for new password. Please wait until admin takes any action')->withInput();
            }
            $ins['name']=@$chk->name;
            $ins['user_id']=@$chk->id;
            $ins['request_type']='FP';
        }
        

        
        $result=PasswordRequest::create($ins);
        if($result)
        {
            if(@$request->request_type == 'NP')
            {
                return redirect()->back()->with('success','Your requested to the admin for a new password has been sent. You will receive an sms with your password shortly');
            }else{
                return view('auth.after_forget_show'); 
            }
                
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function check_password(Request $request)
    {
        $check=User::where('id',auth()->user()->id)->first();

        $fields = array(
            "userName"=> @$check->empID,
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
        $url = 'https://sso.heterohcl.com/stage/loginaction/login';
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

        if(!$arrayResult->status){
            echo 'false';
         }else{
            echo 'true';
         }
      
        // if (Hash::check($request->password, $check->password)) 
        // {
        //     echo 'true';
        // }else{
        //     echo 'false';
        // }
    }

    public function chnage_password_by_adminas(Request $request)
    {
        if(auth()->user()->user_type != 'AA')
        {
            return redirect()->back();
        }
        $data['password']=PasswordRequest::with('getUser')->where('status','N');
        // dd($request->all());
        if(@$request->all()){
            //dd(@$request->all());
            if(@$request->division){
                $data['password'] = $data['password']->whereHas('getUser',function($q) use($request){
                    $q->where('division',$request->division);
                });
            }

            if(@$request->srh_emp){
                $data['password'] = $data['password']->whereHas('getUser',function($q) use($request){
                    $q->where('empID','like','%'.$request->srh_emp.'%');
                    $q->orWhere('name','like','%'.$request->srh_emp.'%');
                });
            }
            
        }
        $data['password']=$data['password']->orderBy('id','desc')->paginate(10);
        $data['divisions'] = User::select('division')->whereNotNull('division')->distinct()->get();
        $data['key'] = @$request->all();
        return view('modules.password.admin_password_list',$data);
    }


    public function password_generate($id = null)
    {
        if(auth()->user()->user_type != 'AA')
        {
            return redirect()->back();
        }
        $pass_req=PasswordRequest::where('id',@$id)->first();
        if(!$pass_req)
        {
            return redirect()->back()->with('error','User not found');
        }
        $user=User::where('id',$pass_req->user_id)->first();
        if(!$user)
        {
            return redirect()->back()->with('error','User not found');
        }

        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string_unique= substr(str_shuffle($str_result),0, 8);

        $upd['password']=$string_unique;
        $upd['status']='A';
        // dd($upd);
        $result=PasswordRequest::where('id',@$pass_req->id)->update($upd);
        if($result)
        {
            return redirect()->back()->with('success','New password generated successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }

    }

    public function employee_change_pass(Request $request)
    {

        if($request->new_password && $request->old_password)
        {
            $request->validate([
                'old_password' => 'required',
                'confirm_password' => 'required',
            ]);
            if($request->new_password == $request->confirm_password){
                $check=User::where('id',auth()->user()->id)->first();
               
                    $fields = array(
                        "empID" => auth()->user()->empID,
                        "confrmPassword" => $request->new_password,
                        "application" => "changepassword"
                    
                    );
            
                    
                    
                    $headers = array(
                        'Content-Type: application/json'
                    );
            
                    # Initializing Curl
                    $ch = curl_init();
            
                    # Posting data to the following URL
                    $url = 'https://sso.heterohcl.com/stage/loginaction/changepassword';
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
                    if($arrayResult == '1')
                    {
                        return redirect()->back()->with('success','Your password is changed successfully');
                    }else{
                        return redirect()->back()->with('error','Password is not changed due to some reasons, Please try again later.');
                    }
               
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }

        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }
}
