<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Designation\StoreRequest;
use App\Http\Requests\Designation\UpdateRequest;
use App\Repositories\Designation\DesignationInterface;

class DesignationController extends Controller
{
    protected $repo;
    public function __construct(DesignationInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $designations = $this->repo->all();
        return view('backend.designation.index',compact('designations'));
    }

    public function create()
    {
        return view('backend.designation.create');
    }

    public function store(StoreRequest $request)
    {
        if($this->repo->store($request)){
            toast('Designation successfully added.','success');
            return redirect()->route('designations.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $designation = $this->repo->get($id);
        return view('backend.designation.edit',compact('designation'));
    }

    public function update(UpdateRequest $request)
    {
        if($this->repo->update($request->id, $request)){
            toast('Designation successfully updated.','success');
            return redirect()->route('designations.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        toast('Designation successfully deleted.','success');
        return back();
    }
}
