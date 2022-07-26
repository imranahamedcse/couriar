<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantShop\StoreRequest;
use App\Http\Requests\MerchantShop\UpdateRequest;
use App\Repositories\Merchantshops\ShopsInterface;
use App\Repositories\Merchant\MerchantInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MerchantShopsController extends Controller
{
    protected $repo;
    protected $repoMerchant;
    public function __construct(ShopsInterface $repo, MerchantInterface $repoMerchant )
    {

            $this->repo=$repo;
            $this->repoMerchant=$repoMerchant;
    }

    public function index($id){
        $singleMerchant = $this->repoMerchant->get($id);
        $merchant_shops = $this->repo->merchant_shops_get($id);
        if(blank($singleMerchant)){
            abort(404);
        }

        return view('backend.merchant.shops.index',compact('merchant_shops','singleMerchant'));
    }

    //merchant shops create page
    public function create($id){
        $merchant_id    = $id;
        $singleMerchant = $this->repoMerchant->get($id);
        if(blank($singleMerchant)){
            abort(404);
        }
        return view('backend.merchant.shops.create',compact('merchant_id','singleMerchant'));
    }

    //merchant shops store
    public function store(StoreRequest $request){

            if($this->repo->store($request)){
                toast(__('merchantshops.added_msg'),'success');
                return redirect()->route('merchant.shops.index',$request->merchant_id);
            }else{
                toast(__('merchantshops.error_msg'),'error');
                return Redirect::back()->withInput();
            }
    }

    public function edit($id){

        $edit_shop      = $this->repo->get($id);
        $merchant_id    = $edit_shop->merchant_id;
        $singleMerchant = $this->repoMerchant->get($merchant_id);
        if(blank($singleMerchant) || blank($edit_shop)){
            abort(404);
        }
        return view('backend.merchant.shops.edit', compact('edit_shop','merchant_id','singleMerchant'));
    }

    public function update(UpdateRequest $request){

        if($this->repo->update($request)){
            toast(__('merchantshops.update_msg'),'success');
            return redirect()->route('merchant.shops.index',$request->merchant_id);
        }else{
            toast(__('merchantshops.update_msg'),'error');
            return Redirect::back()->withInput();
        }
    }
    public function delete($id){
        $this->repo->delete($id);
        toast(__('merchantshops.delete_msg'),'success');
        return back();
    }

    public function defaultShop($merchant_id,$id)
    {
        $this->repo->defaultShop($merchant_id,$id);
        toast(__('merchantshops.update_msg'),'success');
        return back();
    }
}
