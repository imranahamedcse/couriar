<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleInterface;

class RoleController extends Controller
{
    protected $repo;

    public function __construct(RoleInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $roles = $this->repo->all();

        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions=$this->repo->permissions(null);
        return view('backend.role.create',compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {

        if($this->repo->store($request)){
            toast('Role successfully added.','success');
            return redirect()->route('roles.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $role = $this->repo->get($id);
        $permissions=$this->repo->permissions($role->slug);
        return view('backend.role.edit',compact('role','permissions'));
    }

    public function update(UpdateRoleRequest $request)
    {
        if($this->repo->update($request->id, $request)){
            toast('Role successfully updated.','success');
            return redirect()->route('roles.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        toast('Role successfully deleted.','success');
        return back();
    }

    public function changeStatus(Request $request)
    {
        $result = $this->repo->status($request->id);
        return response()->json(['success'=>$result]);
    }
}
