<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Imports\ParcelImport;
use App\Models\Backend\DeliveryCharge;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantDeliveryCharge;
use App\Models\MerchantShops;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\MerchantPanel\MerchantParcel\MerchantParcelInterface;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use Illuminate\Http\Request;
use App\Http\Requests\MerchantPanel\Parcel\StoreRequest;
use App\Http\Requests\MerchantPanel\Parcel\UpdateRequest;
use App\Models\Backend\DeliveryMan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Enums\ParcelStatus;
use App\Models\Backend\ParcelEvent;


class MerchantParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $merchant;
    protected $repo;
    protected $shop;
    public function __construct(MerchantParcelInterface $repo, MerchantInterface $merchant, ShopsInterface $shop)
    {
        $this->merchant = $merchant;
        $this->repo = $repo;
        $this->shop = $shop;
    }
    public function index(Request $request)
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        $parcels = $this->repo->all($merchant->id);
        return view('backend.merchant_panel.parcel.index',compact('parcels','request' ));
    }
    public function parcelBank(Request $request)
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        $parcels = $this->repo->parcelBank($merchant->id);
        return view('backend.merchant_panel.parcel.parcel_bank',compact('parcels','request' ));
    }

    public function filter(Request $request)
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        if($this->repo->filter($merchant->id,$request)){
            $parcels      = $this->repo->filter($merchant->id,$request);
            return view('backend.merchant_panel.parcel.index',compact('parcels','request' ));
        }else{
            return redirect()->back();
        }
    }



    public function create()
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        $shops = $this->repo->getShops($merchant->id);
        $merchantShop = $shops[0];
        $deliveryCategories = $this->repo->deliveryCategories();
        $deliveryCharges = $this->repo->deliveryCharges();
        $packagings = $this->repo->packaging();
        $deliveryTypes      = $this->repo->deliveryTypes();
        return view('backend.merchant_panel.parcel.create',compact('merchant','merchantShop','deliveryTypes','shops','deliveryCategories','deliveryCharges','packagings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        if($this->repo->store($request,$merchant->id)){
            toast(__('parcel.added_msg'),'success');
            return redirect()->route('merchant-panel.parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function duplicateStore(StoreRequest $request)
    {
        $userID = Auth::user()->id;
        $merchant = $this->repo->getMerchant($userID);
        if($this->repo->duplicateStore($request,$merchant->id)){
            toast(__('parcel.added_msg'),'success');
            return redirect()->route('merchant-panel.parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
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

    // Parcel logs
    public function logs($id)
    {
        $parcel       = $this->repo->get($id);
        $parcelevents = $this->repo->parcelEvents($id);
        return view('backend.merchant_panel.parcel.logs', compact('parcel','parcelevents'));
    }

    // Parcel duplicate
    public function duplicate($id)
    {
        $parcel          = $this->repo->get($id);
        $merchant        = $this->merchant->get($parcel->merchant_id);
        $shops           = $this->shop->all($parcel->merchant_id);
        $deliveryCharges = DeliveryCharge::where('category_id',$parcel->category_id)->get();

        $deliveryCategories      = $this->repo->deliveryCategories();
        $deliveryCategoryCharges = $this->repo->deliveryCharges();

        $packagings    = $this->repo->packaging();
        $deliveryTypes = $this->repo->deliveryTypes();
        return view('backend.merchant_panel.parcel.duplicate',compact('parcel','merchant','deliveryTypes','shops','deliveryCategories','deliveryCategoryCharges','deliveryCharges','packagings'));
    }

    // Parcel details
    public function details($id)
    {
        // return $this->repo->details($id);
        $parcel       = $this->repo->details($id);
        $parcelevents = $this->repo->parcelEvents($id);
        return view('backend.merchant_panel.parcel.details',compact('parcel','parcelevents'));
    }


    public function edit($id)
    {
        $userID = Auth::user()->id;
        $parcel = $this->repo->get($id);
        if($parcel->status == ParcelStatus::PENDING){

            $merchant = $this->repo->getMerchant($userID);
            $shops = $this->repo->getShops($merchant->id);
            $deliveryCharges = DeliveryCharge::where('category_id',$parcel->category_id)->get();
            $deliveryCategories = $this->repo->deliveryCategories();
            $deliveryCategoryCharges = $this->repo->deliveryCharges();
            $packagings = $this->repo->packaging();
            $deliveryTypes      = $this->repo->deliveryTypes();
            return view('backend.merchant_panel.parcel.edit',compact('parcel','merchant','deliveryTypes','shops','deliveryCategories','deliveryCategoryCharges','deliveryCharges','packagings'));
        }
        else{
            toast(__('parcel.edit_error_message'),'error');
            return redirect()->route('merchant-panel.parcel.index');
        }

    }


    // Parcel update
    public function statusUpdate($id, $status_id)
    {
        $this->repo->statusUpdate($id, $status_id);
        toast(__('parcel.update_msg'),'success');
        return redirect()->route('merchant-panel.parcel.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $userID
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request,$id)
    {
        $userID = Auth::user()->id;
        if($this->repo->update($id, $request,$userID)){
            toast(__('parcel.update_msg'),'success');
            return redirect()->route('merchant-panel.parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $userID
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userID = Auth::user()->id;
        $parcel = $this->repo->get($id);
        if($parcel->status == ParcelStatus::PENDING){
            $this->repo->delete($id,$userID);
            toast(__('parcel.delete_msg'),'success');
            return back();
        }
        else{
            toast(__('parcel.delete_error_message'),'error');
            return redirect()->route('merchant-panel.parcel.index');
        }
    }



    public function parcelImportExport()
    {
        $deliveryCategories = $this->repo->deliveryCategories();

        return view('backend.merchant_panel.parcel.import',compact('deliveryCategories'));
    }

    public function parcelImport(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        try {
            $import = new ParcelImport();
            $import->import($request->file('file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $importErrors = [];
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
                $importErrors[$failure->row()][] = $failure->errors()[0];
            }
            return back()->with('importErrors', $importErrors);
        }
        toast(__('parcel.added_msg'),'success');
        return redirect()->route('merchant-panel.parcel.index');
    }



    public function merchantShops(Request $request)
    {
        if (request()->ajax()) {
            if ($request->id && $request->shop == 'true') {
                $merchantShops = [];
                $merchantShop = MerchantShops::where(['merchant_id'=>$request->id,'default_shop'=>Status::ACTIVE])->first();
                $merchantShops[]= $merchantShop;
                $merchantShopArray = MerchantShops::where(['merchant_id'=>$request->id,'default_shop'=>Status::INACTIVE])->get();
                if(!blank($merchantShopArray)){
                    foreach ($merchantShopArray as $shop){
                        $merchantShops[] = $shop;
                    }
                }

                if (!blank($merchantShops)) {
                    return view('backend.parcel.shops', compact('merchantShops'));
                }
                return '';
            }else {
                $merchantShop = MerchantShops::find($request->id);
                if (!blank($merchantShop)) {
                    return $merchantShop;
                }
                return '';
            }
        }
        return '';
    }




    public function deliveryCharge(Request $request)
    {
        if (request()->ajax()) {
            if ($request->merchant_id && $request->category_id && $request->weight !='0' && $request->delivery_type_id) {
                $charges = MerchantDeliveryCharge::where(['merchant_id'=>$request->merchant_id,'category_id'=>$request->category_id,'weight'=>$request->weight])->first();
                if (blank($charges)) {
                    $charges = DeliveryCharge::where(['category_id'=>$request->category_id])->first();
                }
            } else {
                $charges = MerchantDeliveryCharge::where(['merchant_id'=>$request->merchant_id,'category_id'=>$request->category_id,'weight'=>$request->weight])->first();
                if (blank($charges)) {
                    $charges = DeliveryCharge::where(['category_id'=>$request->category_id])->first();
                }
            }

            if (!blank($charges)) {
                if($request->delivery_type_id == '1'){
                    $chargeAmount = $charges->same_day;
                }elseif ($request->delivery_type_id == '2') {
                    $chargeAmount = $charges->next_day;
                }elseif ($request->delivery_type_id == '3') {
                    $chargeAmount = $charges->sub_city;
                }elseif ($request->delivery_type_id == '4') {
                    $chargeAmount = $charges->outside_city;
                }else {
                    $chargeAmount = 0;
                }
                return $chargeAmount;
            }
            return 0;
        }
        return 0;
    }


    public function deliveryWeight(Request $request)
    {
        if (request()->ajax()) {
            if ($request->category_id) {
                $deliveryCharges = DeliveryCharge::where('category_id',$request->category_id)->get();

                if (!blank($deliveryCharges)) {
                    return view('backend.merchant_panel.parcel.deliveryWeight', compact('deliveryCharges'));
                }
                return '';
            }
        }
        return '';
    }
}
