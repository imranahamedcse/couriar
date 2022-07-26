<?php
namespace App\Repositories\MerchantPanel\MerchantParcel;

use App\Enums\ApprovalStatus;
use App\Enums\ParcelStatus;
use App\Enums\DeliveryType;
use App\Enums\DeliveryTime;
use App\Enums\Status;
use App\Models\Backend\Deliverycategory;
use App\Models\Backend\DeliveryCharge;

use App\Models\Backend\ParcelLogs;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantDeliveryCharge;
use App\Models\Backend\Packaging;
use App\Models\Backend\Parcel;
use App\Models\MerchantShops;
use Carbon\Carbon;
use App\Models\Backend\ParcelEvent;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;


class MerchantParcelRepository implements MerchantParcelInterface {

    public function all($merchant_id){
        return Parcel::where('merchant_id',$merchant_id)->orderByDesc('id')->paginate(10);
    }

    public function deliveryTypes(){
        $types=[
            'same_day',
            'next_day',
            'sub_city',
            'outside_City',
        ];
        return Config::whereIn('key',$types)->where('value',1)->get();
    }

    public function parcelBank($merchant_id){
        return Parcel::where('parcel_bank', "on")->where('merchant_id',$merchant_id)->orderByDesc('id')->paginate(10);
    }

    public function filter($merchant_id,$request){

        return Parcel::where('merchant_id',$merchant_id)->orderByDesc('id')->where(function( $query ) use ( $request ) {

            if($request->parcel_date) {
                $date = explode('To', $request->parcel_date);
                if(is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$from, $to]);
                }
            }

            if($request->parcel_status) {
                $query->where('status',$request->parcel_status);
            }

            if($request->pickup_date) {
                $query->where(['pickup_date' => date('Y-m-d', strtotime($request->pickup_date))]);
            }

            if($request->delivery_date) {
                $query->where(['delivery_date' => date('Y-m-d', strtotime($request->delivery_date))]);
            }

            if($request->parcel_customer) {
                $query->where('customer_name', 'like', '%' . $request->parcel_customer . '%');
            }
            if($request->parcel_customer_phone) {
                $query->where('customer_phone', 'like', '%' . $request->parcel_customer_phone . '%');
            }

        })->paginate(10);



    }

    public function parcelEvents($id){
        return ParcelEvent::where('parcel_id',$id)->orderBy('created_at','desc')->get();
    }

    public function get($id) {
        return Parcel::find($id);
    }

    public function details($id) {
        return Parcel::where('id', $id)->with('merchant', 'merchant.user','merchantShop','deliveryCategory','packaging')->first();
    }

    public function statusUpdate($id, $status_id) {
        $parcel         = Parcel::find($id);
        $parcel->status = $status_id;
        $parcel->save();

        return true;
    }

    public function getMerchant($id){
        return Merchant::where('user_id',$id)->first();
    }

    public function getShop($id){
        return MerchantShops::where('merchant_id',$id)->first();
    }
    public function getShops($id){
        $merchantShops      = [];
        $merchantShop       = MerchantShops::where(['merchant_id'=>$id,'default_shop'=>Status::ACTIVE])->first();
        $merchantShops[]    = $merchantShop;
        $merchantShopArray  = MerchantShops::where(['merchant_id'=>$id,'default_shop'=>Status::INACTIVE])->get();
        if(!blank($merchantShopArray)){
            foreach ($merchantShopArray as $shop){
                $merchantShops[] = $shop;
            }
        }
        return $merchantShops;
    }

    public function deliveryCharges(){
        return DeliveryCharge::distinct('category_id')->pluck('category_id');
    }

    public function deliveryCategories(){
        return pluck(Deliverycategory::all(), 'obj', 'id');
    }




    public function packaging(){
        return Packaging::where('status',Status::ACTIVE)->get();
    }

    public function store($request,$merchant_id) {

        try {
            $chargeDetails = json_decode($request->chargeDetails);

            $parcel                         = new Parcel();
            $parcel->merchant_id            = $request->merchant_id ?? $merchant_id;
            $parcel->first_hub_id           = auth()->user()->hub_id;
            $parcel->hub_id                 = auth()->user()->hub_id;
            $parcel->category_id            = $request->category_id;
            if($request->weight){
                $parcel->weight                 = $request->weight;
            }
            $parcel->invoice_no             = $request->invoice_no;
            $parcel->cash_collection        = $request->cash_collection;
            if($request->selling_price){
                $parcel->selling_price          = $request->selling_price;
            }

            $parcel->merchant_shop_id       = $request->shop_id;
            $parcel->pickup_phone           = $request->pickup_phone;
            $parcel->pickup_address         = $request->pickup_address;

            $parcel->customer_name          = $request->customer_name;
            $parcel->customer_phone         = $request->customer_phone;
            $parcel->customer_address       = $request->customer_address;


            $parcel->delivery_type_id       = $request->delivery_type_id;

            // Pickup & Delivery Time
            if($request->delivery_type_id == DeliveryType::SAMEDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d');
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::NEXTDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +2 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::SUBCITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY + 1 .' day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::OUTSIDECITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY + 1 .' day'));
                }
            }
            // End Pickup & Delivery Time

            $parcel->vat                    = $chargeDetails->vatTex;
            $parcel->vat_amount             = $chargeDetails->VatAmount;
            $parcel->delivery_charge        = $chargeDetails->deliveryChargeAmount;



            //merchant cod charge
            $Codmerchant  = Auth::user()->merchant;
            $merchantCODCharge   = 0;
            if($request->delivery_type_id == 1 || $request->delivery_type_id == 2):
                $merchantCODCharge   = $Codmerchant->cod_charges['inside_city'];
            elseif($request->delivery_type_id == 3):
                $merchantCODCharge   = $Codmerchant->cod_charges['sub_city'];
            elseif($request->delivery_type_id == 4):
                $merchantCODCharge   = $Codmerchant->cod_charges['outside_city'];
            endif;
            // dd($merchantCODCharge);
            //end merchant cod charge

            $parcel->cod_charge             =  $merchantCODCharge;

            // $parcel->cod_charge             = $chargeDetails->merchantCodCharge;


            $parcel->cod_amount             = $chargeDetails->codChargeAmount;
            $parcel->total_delivery_amount  = $chargeDetails->totalDeliveryChargeAmount;
            $parcel->current_payable        = $chargeDetails->currentPayable;
            $parcel->note                   = $request->note;
            $parcel->parcel_bank            = $request->parcel_bank;
            $parcel->status                 = ParcelStatus::PENDING;
            if($request->packaging_id){
                $parcel->packaging_id               = $request->packaging_id;
                $parcel->packaging_amount           = $chargeDetails->packagingAmount;
            }
            if(isset($request->fragileLiquid) && $request->fragileLiquid=='on'){
                $parcel->liquid_fragile_amount  = $chargeDetails->liquidFragileAmount;
            }

            // $parcel->save();
            $trakingID                           = 'RX'.substr(strtotime(date('H:i:s')),1).'C'.$parcel->merchant_id.$parcel->id;
            if(strlen($trakingID) <=14){
                $parcel->tracking_id             = $trakingID;
            }else {
                $parcel->tracking_id             = 'RX'.substr(strtotime(date('H:i:s')),strlen($trakingID) - 14).'C'.$parcel->merchant_id.$parcel->id;
            }
            $parcel->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function duplicateStore($request,$merchant_id) {
        // try {
            $chargeDetails = json_decode($request->chargeDetails);
            $duplicate_parcel = $this->get($request->parcel_id);

            $parcel                         = new Parcel();
            $parcel->merchant_id            = $request->merchant_id ?? $merchant_id;
            $parcel->first_hub_id           = auth()->user()->hub_id;
            $parcel->hub_id                 = auth()->user()->hub_id;
            $parcel->category_id            = $request->category_id;
            if($request->weight !=="" ){
                $parcel->weight                 = $request->weight;
            }
            $parcel->invoice_no             = $request->invoice_no;
            $parcel->cash_collection        = $request->cash_collection;
            if($request->selling_price){
                $parcel->selling_price          = $request->selling_price;
            }

            $parcel->merchant_shop_id       = $request->shop_id;
            $parcel->pickup_phone           = $request->pickup_phone;
            $parcel->pickup_address         = $request->pickup_address;

            $parcel->customer_name          = $request->customer_name;
            $parcel->customer_phone         = $request->customer_phone;
            $parcel->customer_address       = $request->customer_address;


            $parcel->delivery_type_id       = $request->delivery_type_id;
            $parcel->note                   = $request->note;
            $parcel->parcel_bank            = $request->parcel_bank;
            $parcel->status                 = ParcelStatus::PENDING;

            // Pickup & Delivery Time
            if($request->delivery_type_id == DeliveryType::SAMEDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d');
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::NEXTDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +2 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::SUBCITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY + 1 .' day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::OUTSIDECITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY + 1 .' day'));
                }
            }
            // End Pickup & Delivery Time

            if(!blank($chargeDetails)){
                $parcel->vat                    = $chargeDetails->vatTex;
                $parcel->vat_amount             = $chargeDetails->VatAmount;
                $parcel->delivery_charge        = $chargeDetails->deliveryChargeAmount;


                //merchant cod charge
                $Codmerchant  = Auth::user()->merchant;
                $merchantCODCharge   = 0;
                if($request->delivery_type_id == 1 || $request->delivery_type_id == 2):
                    $merchantCODCharge   = $Codmerchant->cod_charges['inside_city'];
                elseif($request->delivery_type_id == 3):
                    $merchantCODCharge   = $Codmerchant->cod_charges['sub_city'];
                elseif($request->delivery_type_id == 4):
                    $merchantCODCharge   = $Codmerchant->cod_charges['outside_city'];
                endif;
                // dd($merchantCODCharge);
                //end merchant cod charge

                // $parcel->cod_charge             = $chargeDetails->merchantCodCharge;
                $parcel->cod_charge             =  $merchantCODCharge;

                // $parcel->cod_charge             = $chargeDetails->merchantCodCharge;


                $parcel->cod_amount             = $chargeDetails->codChargeAmount;
                $parcel->total_delivery_amount  = $chargeDetails->totalDeliveryChargeAmount;
                $parcel->current_payable        = $chargeDetails->currentPayable;
                if($request->packaging_id){
                    $parcel->packaging_id           = $request->packaging_id;
                    $parcel->packaging_amount       = $chargeDetails->packagingAmount;
                }
                if(isset($request->fragileLiquid) && $request->fragileLiquid=='on'){
                    $parcel->liquid_fragile_amount      = $chargeDetails->liquidFragileAmount;
                }else {
                    $parcel->liquid_fragile_amount      = null;
                }
            }
            else{
                $parcel->vat                    = $duplicate_parcel->vat;
                $parcel->vat_amount             = $duplicate_parcel->vat_amount;
                $parcel->delivery_charge        = $duplicate_parcel->delivery_charge;
                $parcel->cod_charge             = $duplicate_parcel->cod_charge;
                $parcel->cod_amount             = $duplicate_parcel->cod_amount;
                $parcel->total_delivery_amount  = $duplicate_parcel->total_delivery_amount;
                $parcel->current_payable        = $duplicate_parcel->current_payable;
                if($request->packaging_id){
                    $parcel->packaging_id           = $request->packaging_id;
                    $parcel->packaging_amount       = $duplicate_parcel->packaging_amount;

                }
                $parcel->liquid_fragile_amount  = $duplicate_parcel->liquid_fragile_amount;
            }

            $trakingID                           = 'RX'.substr(strtotime(date('H:i:s')),1).'C'.$parcel->merchant_id.$parcel->id;
            if(strlen($trakingID) <=14){
                $parcel->tracking_id             = $trakingID;
            }else {
                $parcel->tracking_id             = 'RX'.substr(strtotime(date('H:i:s')),strlen($trakingID) - 14).'C'.$parcel->merchant_id.$parcel->id;
            }
            $parcel->save();

            // Parcel logs
            $log                         = new ParcelLogs;
            $log->merchant_id            = $request->merchant_id;

            $merchant = Merchant::find($request->merchant_id);
            $log->hub_id                  = $merchant->user->hub_id;
            // $log->delivery_man_id        = $request->merchant_id;

            $log->parcel_id              = $parcel->id;
            $log->pickup_address         = $request->pickup_address;
            $log->pickup_phone           = $request->pickup_phone;
            $log->customer_name          = $request->customer_name;
            $log->customer_phone         = $request->customer_phone;
            $log->customer_address       = $request->customer_address;
            $log->invoice_no             = $request->invoice_no;
            $log->cash_collection        = $request->cash_collection;
            if($request->selling_price){
                $log->selling_price          = $request->selling_price;
            }
            if(!blank($chargeDetails)){
                $log->total_delivery_amount  = $chargeDetails->totalDeliveryChargeAmount;
                $log->current_payable        = $chargeDetails->currentPayable;
            }
            else{
                $log->total_delivery_amount  = $duplicate_parcel->total_delivery_amount;
                $log->current_payable        = $duplicate_parcel->current_payable;
            }
            $log->note                   = $request->note;
            $log->parcel_bank            = $request->parcel_bank;
            $log->save();

            // DB::commit();
            return true;
        // }
        // catch (\Exception $e) {
        //     return false;
        // }
    }

    public function update($id, $request,$merchant_id) {

        try {
            $chargeDetails = json_decode($request->chargeDetails);

            $parcel                         = Parcel::find($id);
            $parcel->merchant_id            = $request->merchant_id;
            $parcel->category_id            = $request->category_id;
            if($request->weight !==""){
                $parcel->weight                 = $request->weight;
            }
            $parcel->invoice_no             = $request->invoice_no;
            $parcel->cash_collection        = $request->cash_collection;
            if($request->selling_price){
                $parcel->selling_price          = $request->selling_price;
            }

            $parcel->merchant_shop_id       = $request->shop_id;
            $parcel->pickup_phone           = $request->pickup_phone;
            $parcel->pickup_address         = $request->pickup_address;

            $parcel->customer_name          = $request->customer_name;
            $parcel->customer_phone         = $request->customer_phone;
            $parcel->customer_address       = $request->customer_address;


            $parcel->delivery_type_id       = $request->delivery_type_id;

            // Pickup & Delivery Time
            if($request->delivery_type_id == DeliveryType::SAMEDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d');
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::NEXTDAY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +2 day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::SUBCITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::SUBCITY + 1 .' day'));
                }
            }
            elseif($request->delivery_type_id == DeliveryType::OUTSIDECITY){
                if(date('H') < DeliveryTime::LAST_TIME){
                    $parcel->pickup_date      = date('Y-m-d');
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY .' day'));
                }
                else{
                    $parcel->pickup_date      = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
                    $parcel->delivery_date    = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. DeliveryTime::OUTSIDECITY + 1 .' day'));
                }
            }
            // End Pickup & Delivery Time

                $parcel->note                   = $request->note;
                $parcel->parcel_bank            = $request->parcel_bank;

            if(!blank($chargeDetails)){
                    $parcel->vat                    = $chargeDetails->vatTex;
                    $parcel->vat_amount             = $chargeDetails->VatAmount;
                    $parcel->delivery_charge        = $chargeDetails->deliveryChargeAmount;

                //merchant cod charge
                $Codmerchant         = Auth::user()->merchant;
                $merchantCODCharge   = 0;
                if($request->delivery_type_id == 1 || $request->delivery_type_id == 2):
                    $merchantCODCharge   = $Codmerchant->cod_charges['inside_city'];
                elseif($request->delivery_type_id == 3):
                    $merchantCODCharge   = $Codmerchant->cod_charges['sub_city'];
                elseif($request->delivery_type_id == 4):
                    $merchantCODCharge   = $Codmerchant->cod_charges['outside_city'];
                endif;
                // dd($merchantCODCharge);
                //end merchant cod charge

                // $parcel->cod_charge             = $chargeDetails->merchantCodCharge;
                $parcel->cod_charge             =  $merchantCODCharge;

                // $parcel->cod_charge             = $chargeDetails->merchantCodCharge;

                $parcel->cod_amount             = $chargeDetails->codChargeAmount;
                $parcel->total_delivery_amount  = $chargeDetails->totalDeliveryChargeAmount;
                $parcel->current_payable        = $chargeDetails->currentPayable;

                if(isset($request->fragileLiquid) && $request->fragileLiquid=='on'){
                    $parcel->liquid_fragile_amount      = $chargeDetails->liquidFragileAmount;
                }else{
                    $parcel->liquid_fragile_amount      = null;
                }
                if($request->packaging_id){
                    $parcel->packaging_id               = $request->packaging_id;
                    $parcel->packaging_amount           = $chargeDetails->packagingAmount;

                }
            }

            $parcel->save();

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function delete($id,$merchant_id) {
        return Parcel::destroy($id);
    }



}
