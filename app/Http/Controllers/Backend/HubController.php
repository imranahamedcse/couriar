<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Hub\StoreHubRequest;
use App\Http\Requests\Hub\UpdateHubRequest;
use App\Repositories\Hub\HubInterface;

class HubController extends Controller
{
    protected $repo;
    public function __construct(HubInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $hubs = $this->repo->all();
        return view('backend.hub.index',compact('hubs','request'));
    }
    public function filter(Request $request)
    {
        $hubs = $this->repo->filter($request);
        return view('backend.hub.index',compact('hubs','request'));
    }

    public function create()
    {
        return view('backend.hub.create');
    }

    public function store(StoreHubRequest $request)
    {
        if($this->repo->store($request)){
            toast(__('hub.added_msg'),'success');
            return redirect()->route('hubs.index');
        }else{
            toast(__('hub.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $hub = $this->repo->get($id);
        return view('backend.hub.edit',compact('hub'));
    }

    public function update(UpdateHubRequest $request)
    {
        if($this->repo->update($request->id, $request)){
            toast(__('hub.update_msg'),'success');
            return redirect()->route('hubs.index');
        }else{
            toast(__('hub.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        toast(__('hub.delete_msg'),'success');
        return back();
    }
}
