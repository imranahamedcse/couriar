<?php

namespace App\Http\Controllers\Backend;

use App\Enums\ParcelStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Imports\ParcelImport;
use App\Models\Backend\DeliveryCharge;
use App\Models\Backend\Hub;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantDeliveryCharge;
use App\Models\MerchantShops;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\MerchantPanel\Shops\ShopsInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Parcel\StoreRequest;
use App\Http\Requests\Parcel\UpdateRequest;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Parcel;
use App\Models\Backend\ParcelEvent;
use App\Models\User;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use App\Repositories\Hub\HubInterface;
use App\Repositories\Parcel\ParcelInterface;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $merchant;
    protected $repo;
    protected $shop;
    public function __construct(
        ParcelInterface $repo,
        MerchantInterface $merchant,
        ShopsInterface $shop,
        DeliveryManInterface $deliveryman,
        HubInterface $hub
        )
    {
        $this->merchant     = $merchant;
        $this->repo         = $repo;
        $this->shop         = $shop;
        $this->deliveryman  = $deliveryman;
        $this->hub          = $hub;
    }
    public function index(Request $request)
    {

        $parcels        = $this->repo->all();
        $deliverymans   = $this->deliveryman->all();
        $hubs           = $this->hub->all();
        return view('backend.parcel.index',compact('parcels','deliverymans','hubs','request'));
    }

    public function filter(Request $request)
    {

        if($this->repo->filter($request)){
            $parcels      = $this->repo->filter($request);
            $deliverymans = $this->deliveryman->all();
            $hubs         = $this->hub->all();
            return view('backend.parcel.index',compact('parcels','deliverymans','hubs','request'));
        }else{
            return redirect()->back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $merchants          = $this->merchant->all();
        $deliveryCategories = $this->repo->deliveryCategories();
        $deliveryCharges    = $this->repo->deliveryCharges();
        $packagings         = $this->repo->packaging();
        $deliveryTypes      = $this->repo->deliveryTypes();

        return view('backend.parcel.create',compact('merchants','deliveryCategories','deliveryCharges','deliveryTypes','packagings'));
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
            toast(__('parcel.added_msg'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function duplicateStore(StoreRequest $request)
    {

        if($this->repo->duplicateStore($request)){
            toast(__('parcel.added_msg'),'success');
            return redirect()->route('parcel.index');
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
        $parcel         = $this->repo->get($id);
        $parcelevents   = $this->repo->parcelEvents($id);
        return view('backend.parcel.logs', compact('parcel','parcelevents'));
    }

    // Parcel duplicate
    public function duplicate($id)
    {
        $parcel                  = $this->repo->get($id);
        $merchant                = $this->merchant->get($parcel->merchant_id);
        $shops                   = $this->shop->all($parcel->merchant_id);

        $deliveryCharges         = DeliveryCharge::where('category_id',$parcel->category_id)->get();
        $deliveryCategories      = $this->repo->deliveryCategories();
        $deliveryCategoryCharges = $this->repo->deliveryCharges();

        $packagings              = $this->repo->packaging();
        $deliveryTypes      = $this->repo->deliveryTypes();
        return view('backend.parcel.duplicate',compact('parcel','merchant','shops','deliveryCategories','deliveryTypes','deliveryCategoryCharges','deliveryCharges','packagings'));
    }

    // Parcel details
    public function details($id)
    {
        // return $this->repo->details($id);
        $parcel         = $this->repo->details($id);
        $parcelevents   = ParcelEvent::where('parcel_id',$id)->orderBy('created_at','desc')->get();
        return view('backend.parcel.details',compact('parcel','parcelevents'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $parcel          = $this->repo->get($id);
        $merchant        = $this->merchant->get($parcel->merchant_id);
        $shops           = $this->shop->all($parcel->merchant_id);
        $deliveryCharges = DeliveryCharge::where('category_id',$parcel->category_id)->get();

        $deliveryCategories      = $this->repo->deliveryCategories();
        $deliveryCategoryCharges = $this->repo->deliveryCharges();

        $packagings              = $this->repo->packaging();
        $deliveryTypes      = $this->repo->deliveryTypes();
        return view('backend.parcel.edit',compact('parcel','merchant','shops','deliveryCategories','deliveryTypes','deliveryCategoryCharges','deliveryCharges','packagings'));
    }

    // Parcel update
    public function statusUpdate($id, $status_id)
    {
        $this->repo->statusUpdate($id, $status_id);
        toast(__('parcel.update_msg'),'success');
        return redirect()->route('parcel.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        if($this->repo->update($id, $request)){
            toast(__('parcel.update_msg'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
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
        toast(__('parcel.delete_msg'),'success');
        return back();
    }

    public function parcelImportExport()
    {
        $deliveryCategories = $this->repo->deliveryCategories();

        return view('backend.parcel.import',compact('deliveryCategories'));
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
            $failures     = $e->failures();
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
        return redirect()->route('parcel.index');
    }

    public function getImportMerchant(Request $request){
        $search   = $request->search;
        $response = array();
        if($request->searchQuery == 'true'){
            if($search == ''){
                $merchants = Merchant::where('status',Status::ACTIVE)->orderby('business_name','asc')->select('id','business_name','vat')->where('business_name', 'like', '%' .$search . '%')->limit(10)->get();
            }else{
                $merchants = Merchant::where('status',Status::ACTIVE)->orderby('business_name','asc')->select('id','business_name','vat')->where('business_name', 'like', '%' .$search . '%')->limit(10)->get();
            }

            foreach($merchants as $merchant){
                $response[] = array(
                    "id"=>$merchant->id,
                    "text"=>$merchant->id.' = '.$merchant->business_name,
                );
            }
            return response()->json($response);
        }

    }

    public function getMerchant(Request $request){
        $search   = $request->search;
        $response = array();
        if($request->searchQuery == 'true'){
            if($search == ''){
                $merchants = [];
            }else{
                $merchants = Merchant::where('status',Status::ACTIVE)->orderby('business_name','asc')->select('id','business_name','vat')->where('business_name', 'like', '%' .$search . '%')->limit(10)->get();
            }

            foreach($merchants as $merchant){
                $response[] = array(
                    "id"=>$merchant->id,
                    "text"=>$merchant->business_name,
                );
            }
            return response()->json($response);
        }else {
            $merchant = Merchant::find($search);

            $response[] = array(
                "vat"         =>$merchant->vat?? 0,
                "cod_charges" =>$merchant->cod_charges,
            );
            return response()->json($response);
        }

    }


    // Hub search
    public function getHub(Request $request){
        $search   = $request->search;
        $response = array();
        if($request->searchQuery == 'true'){
            if($search == ''){
                $hubs = [];
            }
            else{
                $hubs = Hub::where('status',Status::ACTIVE)->orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(10)->get();
            }
            foreach($hubs as $hub){
                $response[] = array(
                    "id"=>$hub->id,
                    "text"=>$hub->name,
                );
            }
            return response()->json($response);
        }
    }


    public function getMerchantCod(Request $request){


        if(request()->ajax()):
            $merchant = [];

            $merchant = Merchant::find($request->merchant_id);

            $merchant = [
                    'inside_city'  => $merchant->cod_charges['inside_city'],
                    'sub_city' => $merchant->cod_charges['sub_city'],
                    'outside_city' => $merchant->cod_charges['outside_city']
            ];
            return response()->json($merchant);
        endif;
        return '';


    }



    public function merchantShops(Request $request)
    {
        if (request()->ajax()) {
            if ($request->id && $request->shop == 'true') {
                $merchantShops          = [];
                $merchantShop           = MerchantShops::where(['merchant_id'=>$request->id,'default_shop'=>Status::ACTIVE])->first();
                $merchantShops[]        = $merchantShop;
                $merchantShopArray      = MerchantShops::where(['merchant_id'=>$request->id,'default_shop'=>Status::INACTIVE])->get();
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
                $charges = MerchantDeliveryCharge::where([
                        'merchant_id'=>$request->merchant_id,
                        'category_id'=>$request->category_id,
                        'weight'=>$request->weight
                    ])->first();

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
                    return view('backend.parcel.deliveryWeight', compact('deliveryCharges'));
                }
                return '';
            }
        }
        return '';
    }




    //delivery man search

    public function transferHub(Request $request){


        $parcelEvent = ParcelEvent::where(['parcel_id'=>$request->parcel_id,'parcel_status'=>ParcelStatus::RECEIVED_WAREHOUSE])->first();
        $hubs        = Hub::orderByDesc('id')->whereNotIn('id',[$parcelEvent->hub_id])->get();
             $response = '';
        foreach ($hubs as $hub){
            $response .= '<option value="'.$hub->id.'" selected> '.$hub->name.'</option>';
        }
        return $response;
    }


    public function deliverymanSearch(Request $request){

        $search = $request->search;
        if($request->single){
            $deliveryMan  = ParcelEvent::where([
                    'parcel_id'=>$request->parcel_id,
                    'parcel_status'=>$request->status
                ])->first();

            if(isset($deliveryMan->deliveryMan) && !blank($deliveryMan->deliveryMan)){
                $response = '<option value="'.$deliveryMan->delivery_man_id.'" selected> '.$deliveryMan->deliveryMan->user->name.'</option>';

            }else {
                $response = '<option value="'.$deliveryMan->pickup_man_id.'" selected> '.$deliveryMan->pickupman->user->name.'</option>';

            }
            return $response;
        }else{
            if($search == ''){
                $deliverymans = [];
            }else{
                $deliverymans = User::where('status',Status::ACTIVE)
                                      ->orderby('name','asc')
                                      ->select('id','name')
                                      ->where('name', 'like', '%' .$search . '%')
                                      ->where('user_type',UserType::DELIVERYMAN)->limit(10)->get();
            }
            $response=[];

            foreach($deliverymans as $deliveryman){
                $response[] = array(
                    "id"  => $deliveryman->deliveryman->id,
                    "text"=> $deliveryman->name,
                );
            }
            return response()->json($response);
        }


    }

    //parcel search in recived by hub
    public function parcelRecivedByHubSearch(Request $request){

        if($request->ajax()){
            $hub      = $request->hub_id;
            $track_id = $request->track_id;

            if($track_id && $hub){
                        $parcel      = Parcel::with(['merchant','merchant.user'])->where([
                                                    'tracking_id'     => $request->track_id,
                                                    'transfer_hub_id' => $hub,
                                                    'status'          => ParcelStatus::TRANSFER_TO_HUB
                                                ])->first();
                    if($parcel){
                        return response()->json($parcel);
                    }else{
                        return 0;
                    }
            }
        }

    }

    public function transfertohubSelectedHub(Request $request){
        // $transfertohub   = ParcelEvent::where(['parcel_id'=>$request->parcel_id,'parcel_status'=>ParcelStatus::TRANSFER_TO_HUB])->orderBy('id','desc')->first();
        // $hub             = ParcelEvent::where(['parcel_id'=>$request->parcel_id,'parcel_status'=>ParcelStatus::RECEIVED_WAREHOUSE])->first();
        $parcel          = Parcel::find($request->parcel_id);
        if($parcel){
            if($parcel->hub_id){
                return '<option selected disabled>'.$parcel->hub->name.'</option>';
            }else{
                return '<option selected disabled>Hub not found</option>';
            }
        }else{
                return '<option selected disabled>Hub not found</option>';

        }
    }

    public function PickupManAssigned(Request $request){
        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required'
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;
        if($this->repo->pickupdatemanAssigned($request->parcel_id, $request)){
            toast(__('parcel.pickup_man_assigned'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function PickupManAssignedCancel(Request $request){

        if($this->repo->pickupdatemanAssignedCancel($request->parcel_id, $request)){
            toast(__('parcel.pickup_man_assigned'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function PickupReSchedule(Request $request){

        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required',
            'date'=>'required',
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->PickupReSchedule($request->parcel_id, $request)){
            toast(__('parcel.pickup_scheduled'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function PickupReScheduleCancel(Request $request){

        if($this->repo->PickupReScheduleCancel($request->parcel_id, $request)){
            toast(__('parcel.pickup_reschedule_canceled'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function receivedBypickupman(Request $request){

        if($this->repo->receivedBypickupman($request->parcel_id, $request)){
            toast(__('parcel.received_by_pickup_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function receivedByHub(Request $request){

        if($this->repo->receivedByHub($request->parcel_id, $request)){
            toast(__('parcel.received_by_hub'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function receivedByHubCancel(Request $request){

        if($this->repo->receivedByHubCancel($request->parcel_id, $request)){
            toast(__('parcel.received_by_hub_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }




    public function receivedBypickupmanCancel(Request $request){

        if($this->repo->receivedBypickupmanCancel($request->parcel_id, $request)){
            toast(__('parcel.received_by_pickup_cancel_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function search(Request $data)
    {
        return $this->repo->search($data);
    }

    public function searchDeliveryManAssingMultipleParcel(Request $data)
    {
        return $this->repo->searchDeliveryManAssingMultipleParcel($data);
    }

    public function searchExpense(Request $data)
    {
        return $this->repo->searchExpense($data);
    }

    public function searchIncome(Request $data)
    {
        return $this->repo->searchIncome($data);
    }



    public function transferToHubMultipleParcel(Request $request){


        $validator=Validator::make($request->all(),[
            'hub_id'     => 'required',
            'parcel_ids' => 'required',
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->transferToHubMultipleParcel($request)){
            toast(__('parcel.transfer_to_hub_success'),'success');

            $deliveryman    = $this->deliveryman->get($request->delivery_man_id);
            $parcels        = $this->repo->bulkParcels($request->parcel_ids);
            $bulk_type      = ParcelStatus::TRANSFER_TO_HUB;
            $transfered_hub = Hub::find($request->hub_id);
            return view('backend.parcel.bulk_print',compact('parcels','deliveryman','bulk_type','transfered_hub'));
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }

    }


    public function deliveryManAssignMultipleParcel(Request $request){
        $validator=Validator::make($request->all(),[
            'delivery_man_id' => 'required',
            'parcel_ids_'     => 'required',
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->deliveryManAssignMultipleParcel($request)){
            toast(__('parcel.delivery_man_assign_success'),'success');
            $deliveryman= $this->deliveryman->get($request->delivery_man_id);
            $parcels    = $this->repo->bulkParcels($request->parcel_ids_);
            $bulk_type  = ParcelStatus::DELIVERY_MAN_ASSIGN;
            return view('backend.parcel.bulk_print',compact('parcels','deliveryman','bulk_type'));

        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }




    public function transfertohub(Request $request){

        $validator=Validator::make($request->all(),[
            'hub_id'=>'required'
        ]);
        if($validator->fails()):
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        endif;

        if($this->repo->transfertohub($request->parcel_id, $request)){
            toast(__('parcel.transfer_to_hub_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function transfertoHubCancel(Request $request){

        if($this->repo->transfertoHubCancel($request->parcel_id, $request)){
            toast(__('parcel.transfer_to_hub_canceled'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }





    public function deliverymanAssign(Request $request){


        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required'
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->deliverymanAssign($request->parcel_id, $request)){
            toast(__('parcel.delivery_man_assign_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function deliverymanAssignCancel(Request $request){

        if($this->repo->deliverymanAssignCancel($request->parcel_id, $request)){
            toast(__('parcel.deliveryman_assign_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function deliveryReschedule(Request $request){

        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required',
            'date'           => 'required'
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->deliveryReschedule($request->parcel_id, $request)){
            toast(__('parcel.delivery_reschedule_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function deliveryReScheduleCancel(Request $request){

        if($this->repo->deliveryReScheduleCancel($request->parcel_id, $request)){
            toast(__('parcel.delivery_re_schedule_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function receivedWarehouse(Request $request){
        $validator=Validator::make($request->all(),[
            'hub_id'=>'required'
        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->receivedWarehouse($request->parcel_id, $request)){
            toast(__('parcel.received_warehouse_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function receivedWarehouseCancel(Request $request){

        if($this->repo->receivedWarehouseCancel($request->parcel_id, $request)){
            toast(__('parcel.received_warehouse_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function returntoQourier(Request $request){
        if($this->repo->returntoQourier($request->parcel_id, $request)){
            toast(__('parcel.return_to_qourier_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function returntoQourierCancel(Request $request){

        if($this->repo->returntoQourierCancel($request->parcel_id, $request)){
            toast(__('parcel.received_warehouse_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }





    public function returnAssignToMerchant(Request $request){
        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required',
            'date'           =>'required'

        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;
        if($this->repo->returnAssignToMerchant($request->parcel_id, $request)){
            toast(__('parcel.return_assign_to_merchant_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function returnAssignToMerchantCancel(Request $request){

        if($this->repo->returnAssignToMerchantCancel($request->parcel_id, $request)){
            toast(__('parcel.return_assign_to_merchant_cancel_success'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }
    public function returnAssignToMerchantReschedule(Request $request){

        $validator=Validator::make($request->all(),[
            'delivery_man_id'=>'required',
            'date'           =>'required'

        ]);
        if($validator->fails()):
            toast(__('parcel.required'),'error');
            return redirect()->back();
        endif;

        if($this->repo->returnAssignToMerchantReschedule($request->parcel_id, $request)){
            toast(__('parcel.return_assign_to_merchant_reschedule_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function returnAssignToMerchantRescheduleCancel(Request $request){

        if($this->repo->returnAssignToMerchantRescheduleCancel($request->parcel_id, $request)){
            toast(__('parcel.return_assign_to_merchant_reschedule_cancel_success'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }



    public function returnReceivedByMerchant(Request $request){
        if($this->repo->returnReceivedByMerchant($request->parcel_id, $request)){
            toast(__('parcel.return_received_by_merchant'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function returnReceivedByMerchantCancel(Request $request){

        if($this->repo->returnReceivedByMerchantCancel($request->parcel_id, $request)){
            toast(__('parcel.return_received_by_merchant_cancel_success'),'success');
            return redirect()->route('parcel.index');
        }else{

            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }






    public function parcelDelivered(Request $request){
        if($this->repo->parcelDelivered($request->parcel_id, $request)){
            toast(__('parcel.delivered_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function parcelDeliveredCancel(Request $request){

        if($this->repo->parcelDeliveredCancel($request->parcel_id, $request)){
            toast(__('parcel.delivered_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }




    public function parcelPartialDelivered(Request $request){

        $validator = Validator::make($request->all(),[
            'cash_collection'       => 'required',
        ]);

        if($validator->fails()){
            toast(__('parcel.required'),'error');
            return redirect()->back();
        }

        if($this->repo->parcelPartialDelivered($request->parcel_id, $request)){
            toast(__('parcel.partial_delivered_success'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function parcelPartialDeliveredCancel(Request $request){
        if($this->repo->parcelPartialDeliveredCancel($request->parcel_id, $request)){
            toast(__('parcel.partial_delivered_cancel'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function parcelPrint($id)
    {
        $parcel = $this->repo->get($id);
        $merchant = $this->merchant->get($parcel->merchant_id);
        $shops = $this->shop->all($parcel->merchant_id);
        return view('backend.parcel.print',compact('parcel','merchant','shops'));
    }

    public function parcelPrintLabel($id)
    {
        $parcel = $this->repo->get($id);
        $merchant = $this->merchant->get($parcel->merchant_id);
        $shops = $this->shop->all($parcel->merchant_id);
        return view('backend.parcel.print-label',compact('parcel','merchant','shops'));
    }

    public function parcelReceivedByMultipleHub(Request $request){
            if($this->repo->parcelReceivedByMultipleHub($request->parcel_id,$request)){
                toast(__('parcel.received_by_multiple_hub'),'success');
                return redirect()->route('parcel.index');
            }else{
                toast(__('parcel.error_msg'),'error');
                return redirect()->back();
            }
    }


    //Assign pickup bulk

    public function AssignPickupParcelSearch(Request $request){
        if($request->ajax()){
            $merchant_id      = $request->merchant_id;
            $tracking_id      = $request->tracking_id;

            if($merchant_id !== null && $tracking_id !== null){

                        $parcel      = Parcel::with(['merchant','merchant.user'])->where([
                                                    'merchant_id'     => $merchant_id,
                                                    'tracking_id'     => $tracking_id,
                                                    'status'          => ParcelStatus::PENDING
                                                ])->first();

                    if($parcel){
                        return response()->json($parcel);
                    }else{
                        return 0;
                    }
            }else{

               return 0;
            }
        }

        return 0;
    }




    //assign pickup bulk store
    public function AssignPickupBulk(Request $request){
        $validator = Validator::make($request->all(),[
            'merchant_id'       => 'required',
            'delivery_man_id'   => 'required'
        ]);

        if($validator->fails()){
            toast(__('parcel.feild_required'),'error');
            return redirect()->back();
        }

        if($this->repo->pickupdatemanAssignedBulk($request)){
            toast(__('parcel.pickup_man_assigned'),'success');
            return redirect()->route('parcel.index');
        }else{
            toast(__('parcel.error_msg'),'error');
            return redirect()->back();
        }

    }


    //assign return to merchant

    //return to courier percel will be show
    public function AssignReturnToMerchantParcelSearch(Request $request){
        if($request->ajax()){
            $merchant_id      = $request->merchant_id;
            $tracking_id      = $request->tracking_id;

            if($merchant_id !== null && $tracking_id !== null){

                        $parcel      = Parcel::with(['merchant','merchant.user'])->where([
                                                    'merchant_id'     => $merchant_id,
                                                    'tracking_id'     => $tracking_id,
                                                    'status'          => ParcelStatus::RETURN_TO_COURIER
                                                ])->first();

                    if($parcel){
                        return response()->json($parcel);
                    }else{
                        return 0;
                    }
            }else{

               return 0;
            }
        }

        return 0;
    }


    //assign return to merchant bulk store
    public function AssignReturnToMerchantBulk(Request $request){

            $validator = Validator::make($request->all(),[
                'merchant_id'       => 'required',
                'delivery_man_id'   => 'required',
                'date'              => 'required'
            ]);

            if($validator->fails()){
                toast(__('parcel.feild_required'),'error');
                return redirect()->back();
            }


            if($this->repo->AssignReturnToMerchantBulk($request)){
                toast(__('parcel.return_assign_to_merchant_success'),'success');

                $deliveryman    = $this->deliveryman->get($request->delivery_man_id);
                $parcels        = $this->repo->bulkParcels($request->parcel_ids);
                $bulk_type      = ParcelStatus::RETURN_ASSIGN_TO_MERCHANT;
                return view('backend.parcel.bulk_print',compact('parcels','deliveryman','bulk_type'));

            }else{
                toast(__('parcel.error_msg'),'error');
                return redirect()->back();
            }

    }


    //received warehouse hub auto selected
    public function warehouseHubSelected(Request $request){
        $hubs_list  = "";
        $hubs_list .= "<option>".__("menus.select")." ". __("hub.title") ."</option>";

        if($request->hub_id):
            $hubs=Hub::all();
            foreach ($hubs as $hub) {

                if($hub->id == $request->hub_id){
                    $hubs_list .= "<option selected value=".$hub->id." >".$hub->name."</option>";
                }else{
                    $hubs_list .= "<option   value='".$hub->id."' >".$hub->name."</option>";
                }
            }
          else:
            $hubs=Hub::all();
            foreach ($hubs as $key => $hub) {

                $hubs_list .= "<option   value='".$hub->id."' >".$hub->name."</option>";

            }
          endif;

          return $hubs_list;
    }




}

