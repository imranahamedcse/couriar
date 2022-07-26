<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MerchantProfile\UpdateRequest;
use App\Http\Requests\MerchantProfile\UpdatePasswordRequest;
use App\Repositories\MerchantProfile\MerchantProfileInterface;

class MerchantProfileController extends Controller
{
    protected $repo;
    public function __construct(MerchantProfileInterface $repo)
    {
        $this->repo = $repo;
    }

    public function view($id) // auth id
    {
        $merchat = $this->repo->get($id);
        return view('backend.merchant_profile.index',compact('merchat'));
    }
    
    public function create($id) // user id
    {
        $merchat = $this->repo->get($id);
        return view('backend.merchant_profile.update',compact('merchat'));
    }
  
    public function changePassword($id)
    {
        $merchat = $this->repo->get($id);
        return view('backend.merchant_profile.change_password',compact('merchat'));
    }

    public function update($id, UpdateRequest $request)
    {
        if($this->repo->update($id, $request)){
            toast('Merchant Profile updated successfully.','success');
            return redirect()->route('merchant-profile.index',$id);
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function updatePassword($id, UpdatePasswordRequest $request)
    {
        $result = $this->repo->updatePassword($id, $request);
        if($result == 1){
            toast('Password updated successfully','success');
            return redirect()->route('merchant-profile.index',$id);
        }
        elseif($result == 0){
            toast('Old password not match!','warning');
            return redirect()->back()->withInput();
        }
        else
        {
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }
}
