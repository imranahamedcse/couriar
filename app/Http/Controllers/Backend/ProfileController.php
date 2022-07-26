<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Repositories\Profile\ProfileInterface;

class ProfileController extends Controller
{
    protected $repo;
    public function __construct(ProfileInterface $repo)
    {
        $this->repo = $repo;
    }

    public function view($id)
    {
        $user = $this->repo->get($id);
        return view('backend.profile.index',compact('user'));
    }
    
    public function create($id)
    {
        $user = $this->repo->get($id);
        return view('backend.profile.update',compact('user'));
    }
  
    public function changePassword($id)
    {
        $user = $this->repo->get($id);
        return view('backend.profile.change_password',compact('user'));
    }

    public function update($id, UpdateRequest $request)
    {
        if($this->repo->update($id, $request)){
            toast('Profile updated successfully.','success');
            return redirect()->route('profile.index', $id);
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
            return redirect()->route('profile.index', $id);
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
