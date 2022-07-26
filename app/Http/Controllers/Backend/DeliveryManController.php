<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryMan\DeliveryManRequest;


class DeliveryManController extends Controller
{
    protected $repo;
    public function __construct(DeliveryManInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $deliveryMans = $this->repo->all();
        return view('backend.deliveryman.index',compact('deliveryMans','request'));
    }
    public function filter(Request $request)
    {
        $deliveryMans = $this->repo->filter($request);
        return view('backend.deliveryman.index',compact('deliveryMans','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $hubs         = $this->repo->hubs();
      return view('backend.deliveryman.create',compact('hubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryManRequest $request)
    {

        if($this->repo->store($request)){
            toast(__('deliveryman.added_msg'),'success');
            return redirect()->route('deliveryman.index');
        }else{
            toast(__('deliveryman.error_msg'),'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hubs         = $this->repo->hubs();
        $deliveryman = $this->repo->get($id);
        return view('backend.deliveryman.edit',compact('deliveryman','hubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryManRequest $request)
    {
        if($this->repo->update($request->id, $request)){
            toast(__('deliveryman.update_msg'),'success');
            return redirect()->route('deliveryman.index');
        }else{
            toast(__('deliveryman.error_msg'),'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repo->delete($id);
        toast(__('deliveryman.delete_msg'),'success');
        return back();
    }
}
