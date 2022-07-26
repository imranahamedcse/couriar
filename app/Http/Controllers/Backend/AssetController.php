<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreRequest;
use App\Repositories\Asset\AssetInterface;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repo;

    public function __construct(AssetInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $assets = $this->repo->all();
        return view('backend.asset.index',compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetcategorys = $this->repo->assetcategorys();
        $hubs           = $this->repo->hubs();
        return view('backend.asset.create',compact('assetcategorys','hubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if($this->repo->store($request)){
            toast('Asset successfully added.','success');
            return redirect()->route('asset.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back()->withInput();
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
        $assets             = $this->repo->get($id);
        $assetcategorys     = $this->repo->assetcategorys();
        $hubs               = $this->repo->hubs();
        return view('backend.asset.edit',compact('assetcategorys','hubs','assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request)
    {
        if($this->repo->update($request)){
            toast('Asset successfully Update.','success');
            return redirect()->route('asset.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back()->withInput();
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
        toast('Asset successfully deleted.','success');
        return back();
    }
}
