<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Backend\HubInCharge;
use App\Repositories\HubInCharge\HubInChargeInterface;
use Illuminate\Http\Request;
use App\Http\Requests\HubInCharge\HubInChargeRequest;


class HubInChargeController extends Controller
{
    protected $repo;
    public function __construct(HubInChargeInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index($hubID)
    {
        $hubInCharges = $this->repo->all($hubID);
        $hub          = $this->repo->hub($hubID);
        return view('backend.hubincharge.index',compact('hubInCharges','hub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($hubID)
    {
        $hub    = $this->repo->hub($hubID);
        $users  = $this->repo->users();
      return view('backend.hubincharge.create',compact('hub','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HubInChargeRequest $request
     * @param $hubID
     * @return \Illuminate\Http\Response
     */
    public function store(HubInChargeRequest $request, $hubID)
    {

        if($this->repo->store($hubID,$request)){
            toast(__('incharge.added_msg'),'success');
            return redirect()->route('hub-incharge.index',$hubID);
        }else{
            toast(__('incharge.error_msg'),'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($hubID,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($hubID,$id)
    {
        $hub        = $this->repo->hub($hubID);
        $users      = $this->repo->users();
        $inCharge   = $this->repo->get($hubID,$id);
        return view('backend.hubincharge.edit',compact('inCharge','hub','users'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param $hubID
     * @param int $id
     * @param HubInChargeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($hubID, $id, HubInChargeRequest $request)
    {
        if($this->repo->update($hubID, $id, $request)){
            toast(__('incharge.update_msg'),'success');
            return redirect()->route('hub-incharge.index',$hubID);
        }else{
            toast(__('incharge.error_msg'),'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hubID,$id)
    {


        $this->repo->delete($id);

        toast(__('incharge.delete_msg'),'success');
        return back();
    }

    public function assigned($hubID,$id)
    {
        $inCharge                   = $this->repo->get($hubID,$id);

        $queryArray['user_id']      = $inCharge->user_id;
        $queryArray['status']       = Status::ACTIVE;

        $hubInCharge = HubInCharge::where($queryArray)->where('id', '!=', $id)->first();

        if(!blank($hubInCharge)){
            toast(__('validation.attributes.user_assigned'),'error');
            return redirect()->back();
        }

        $queryHubArray['user_id']      = $inCharge->user_id;
        $queryHubArray['hub_id']       = $hubID;
        $userHubUnique = HubInCharge::where($queryHubArray)->where('id', '!=', $id)->first();

        if(!blank($userHubUnique)){
            toast(__('validation.attributes.user_exists'),'error');
            return redirect()->back();
        }

        if($this->repo->assignedHub($hubID,$inCharge)){
            toast(__('incharge.assigned_msg'),'success');
            return redirect()->route('hub-incharge.index',$hubID);
        }else{
            toast(__('incharge.error_msg'),'error');
            return redirect()->back();
        }
    }
}
