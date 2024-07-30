<?php

namespace App\Http\Controllers\Modules\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Remark;
use App\Models\Contact;
use App\Models\UserGuide;
use Storage;


class ContentController extends Controller
{
    public function policy()
    {
        $data['emp_poli']=Policy::where('for_user','E')->get();
        $data['admin_asst_poli']=Policy::where('for_user','AA')->get();
        $data['hr_poli']=Policy::where('for_user','HR')->get();
        $data['acct_asst']=Policy::where('for_user','ACA')->get();
        $data['acct_head_poli']=Policy::where('for_user','ACH')->get();
        $data['acct_hyd_poli']=Policy::where('for_user','AHY')->get();
        return view('modules.content.policy',$data);
    }

    public function policy_manage()
    {
        return view('modules.content.policy_manage');
    }

    public function policy_delete($id = null)
    {
        if(!$id)
        {
            return redirect()->back()->with('error','Policy not found');
        }
        $chk=Policy::where('id',$id)->first();
        if(!$chk)
        {
            return redirect()->back()->with('error','Policy not found'); 
        }
        $image_path = 'storage/app/public/policy/'.@$chk->file_name;
        if (file_exists(@$image_path)){
            unlink(@$image_path);
        }
        $result=Policy::where('id',$id)->delete();
        if($result)
        {
            return redirect()->back()->with('success',' Policy deleted Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function policy_show() 
    {
        $data['emp_poli']=Policy::where('for_user','E')->get();
        $data['admin_asst_poli']=Policy::where('for_user','AA')->get();
        $data['hr_poli']=Policy::where('for_user','HR')->get();
        $data['acct_asst']=Policy::where('for_user','ACA')->get();
        $data['acct_head_poli']=Policy::where('for_user','ACH')->get();
        $data['acct_hyd_poli']=Policy::where('for_user','AHY')->get();
        return view('modules.content.policy_show',$data);
    }

    public function help()
    {
        return view('modules.content.help');
    }

    public function policy_submit(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'for_user' => 'required',
            'file_name' => 'required',
            'title' => 'required',
        ]);
        // foreach (@$request->file_name as $img_key=>$row) 
        // {
            $Image = @$request->file_name;
            $filename = @$request->title.'.'.$Image->getClientOriginalExtension();
            Storage::putFileAs('public/policy', $Image, $filename);
            $ins['file_name']=$filename;
            $ins['for_user']=@$request->for_user;
            $result=Policy::create($ins);
        // }
        
        if($result)
        {
            return redirect()->back()->with('success','New Policy Inserted Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }

    
    }


    public function remark()
    {
        return view('modules.content.remark');
    }

    public function remark_submit(Request $request)
    {
        $request->validate([
            'remark' => 'required',
        ]);
        $ins['user_id']=auth()->user()->id;
        $ins['remark']=@$request->remark;
        $result=Remark::create($ins);
        if($result)
        {
            return redirect()->back()->with('success','Remark has been sent Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }

    
    }

    public function contact_submit(Request $request)
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        $request->validate([
            'phone_1' => 'required',
            'email_1' => 'required',
            'phone_2' => 'required',
            'email_2' => 'required',
        ]);
        $chk=Contact::first();
        $upd['phone_1']=@$request->phone_1;
        $upd['email_1']=@$request->email_1;
        $upd['phone_2']=@$request->phone_2;
        $upd['email_2']=@$request->email_2;
        if($chk)
        {
            $result=Contact::where('id',@$chk->id)->update($upd);
        }else{
            $result=Contact::create($upd);
        }
       
        if($result)
        {
            return redirect()->back()->with('success','Contact has been updated Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }

    
    }

    public function contact_show()
    {
        $data['contact']=Contact::first();
        return view('modules.content.contact_show',$data);
    }

    public function contact_edit_show()
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        $data['contact']=Contact::first();
        return view('modules.content.contact_manage',$data);
    }


    public function user_guide()
    {
        // $data['user_guide']=UserGuide::get();
        $data['emp_guide']=UserGuide::where('for_user','E')->get();
        $data['admin_asst_guide']=UserGuide::where('for_user','AA')->get();
        $data['hr_guide']=UserGuide::where('for_user','HR')->get();
        $data['acct_asst_guide']=UserGuide::where('for_user','ACA')->get();
        $data['acct_head_guide']=UserGuide::where('for_user','ACH')->get();
        $data['acct_hyd_guide']=UserGuide::where('for_user','AHY')->get();
        return view('modules.content.user_manual',$data); 
    }

    public function user_guide_list()
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        $data['emp_guide']=UserGuide::where('for_user','E')->get();
        $data['admin_asst_guide']=UserGuide::where('for_user','AA')->get();
        $data['hr_guide']=UserGuide::where('for_user','HR')->get();
        $data['acct_asst_guide']=UserGuide::where('for_user','ACA')->get();
        $data['acct_head_guide']=UserGuide::where('for_user','ACH')->get();
        $data['acct_hyd_guide']=UserGuide::where('for_user','AHY')->get();
        return view('modules.content.user_manual_list',$data); 
    }

    public function manage_user_guide()
    { 
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        return view('modules.content.user_manual_edit');
    }

    public function user_guide_submit(Request $request) 
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        $request->validate([
            'for_user' => 'required',
            'file_name' => 'required',
        ]);
        foreach (@$request->file_name as $img_key=>$row) 
        {
            $Image = @$row;
            $filename = time().'-'.rand(1000,9999).'.'.$Image->getClientOriginalExtension();
            Storage::putFileAs('public/guide', $Image, $filename);
            $ins['file_name']=$filename;
            $ins['for_user']=@$request->for_user;
            $result=UserGuide::create($ins);
        }
        
        if($result)
        {
            return redirect()->back()->with('success','New Guide Inserted Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function delete_user_guide($id = null)
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        if(!$id)
        {
            return redirect()->back()->with('error','Guide not found');
        }
        $chk=UserGuide::where('id',$id)->first();
        if(!$chk)
        {
            return redirect()->back()->with('error','Guide not found'); 
        }
        $image_path = 'storage/app/public/guide/'.@$chk->file_name;
        if (file_exists(@$image_path)){
            unlink(@$image_path);
        }
        $result=UserGuide::where('id',$id)->delete();
        if($result)
        {
            return redirect()->back()->with('success',' Guide deleted Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function remark_list()
    {
        if(auth()->user()->user_type != 'A' && auth()->user()->user_type != 'AA')
        {
            return redirect()->back()->with('error','You are not authorised to access this page.');
        } 
        $data['remark']=Remark::with('getUser')->paginate(10);
        return view('modules.content.remark_list',$data);
    }

    

   
}
