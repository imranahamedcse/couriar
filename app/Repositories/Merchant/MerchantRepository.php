<?php
namespace App\Repositories\Merchant;

use App\Http\Services\SmsService;
use App\Models\Backend\DeliveryCharge;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantDeliveryCharge;
use App\Models\Backend\Upload;
use App\Models\Backend\Hub;
use App\Enums\Status;
use App\Enums\UserType;
use App\Mail\MerchantSignup;
use App\Models\MerchantShops;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Merchant\MerchantInterface;
use Illuminate\Support\Facades\Mail;

class MerchantRepository implements MerchantInterface{
    public function all(){
        return Merchant::with('user','user.upload')->orderByDesc('id')->paginate(10);
    }

    public function all_hubs()
    {
        return Hub::all();
    }

    public function get($id) {
        return Merchant::with('user','licensefile','nidfile')->find($id);
    }


    //merchan shop get
    public function merchant_shops_get($id){
        return MerchantShops::where('merchant_id',$id)->get();
    }
    //Store merchant data
    public function store($request) {

        try {

            DB::beginTransaction();
            $cod_charges = [];
            foreach($request->area as $key => $area){
                $cod_charges[$area] = $request->charge[$area];
            }

            $merchantUser                       = new User();
            $merchantUser->name                 = $request->name;
            $merchantUser->mobile               = $request->mobile;
            $merchantUser->email                = $request->email;
            $merchantUser->password             = Hash::make($request->password);
            $merchantUser->address              = $request->address;
            $merchantUser->hub_id               = $request->hub;
            $merchantUser->status               = $request->status;
            $merchantUser->user_type            = UserType::MERCHANT;

            if(isset($request->image_id) && $request->image_id != null) {
                $merchantUser->image_id = $this->merchant_image($merchantUser->image_id, $request->image_id);
            }

            $merchantUser->save();

            $merchant                       = new Merchant();
            $merchant->user_id              = $merchantUser->id;
            $merchant->business_name        = $request->business_name;
            $merchant->merchant_unique_id   = $this->generateUniqueID();

            if($request->opening_balance !==""){
                $merchant->current_balance      = $request->opening_balance;
                $merchant->opening_balance      = $request->opening_balance;
            }

            if($request->vat !==""){
                $merchant->vat                  = $request->vat;
            }
            $merchant->cod_charges          = $cod_charges;
            $merchant->address              = $request->address;

            if(isset($request->nid) && $request->nid != null) {
                $merchant->nid_id = $this->merchaant_nid($merchant->nid_id, $request->nid);
            }

            if(isset($request->trade_license) &&$request->trade_license != null) {
                $merchant->trade_license = $this->trade_license($merchant->trade_license, $request->trade_license);
            }

            $merchant->save();


            $shop               = new MerchantShops();
            $shop->merchant_id  = $merchant->id;
            $shop->name         = $merchant->business_name;
            $shop->contact_no   = $request->mobile;
            $shop->address      = $request->address;
            $shop->status       = $request->status;
            $shop->default_shop = Status::ACTIVE;
            $shop->save();

            $deliveryCharges =  DeliveryCharge::with('category')->orderBy('position')->get();

            if(!blank($deliveryCharges)){
                foreach ($deliveryCharges as $delivery){
                    $deliveryCharge                      = new MerchantDeliveryCharge();
                    $deliveryCharge->merchant_id         = $merchant->id;
                    $deliveryCharge->delivery_charge_id  = $delivery->id;
                    $deliveryCharge->weight              = $delivery->weight;
                    $deliveryCharge->category_id         = $delivery->category_id;
                    $deliveryCharge->same_day            = $delivery->same_day;
                    $deliveryCharge->next_day            = $delivery->next_day;
                    $deliveryCharge->sub_city            = $delivery->sub_city;
                    $deliveryCharge->outside_city        = $delivery->outside_city;
                    $deliveryCharge->status              = Status::ACTIVE;
                    $deliveryCharge->save();
                }
            }



            DB::commit();

            if( $merchantUser && $merchant):
                $data=[
                    'merchant'      => $merchant,
                    'merchant_user' => $merchantUser
                ];
                Mail::to($merchantUser->email)->send(new MerchantSignup($data));
            endif;
            return true;
        }
        catch (\Exception $e) {

            DB::rollBack();
            return false;
        }
    }
    //Sign up store merchant data
    public function signUpStore($request) {
        try {
            DB::beginTransaction();
            $otp                                = random_int(10000, 99999);

            $merchantUser                       = new User();
            $merchantUser->name                 = $request->first_name .' '.$request->last_name;
            $merchantUser->mobile               = $request->mobile;
            $merchantUser->email                = $request->email;
            $merchantUser->password             = Hash::make($request->password);
            $merchantUser->user_type            = UserType::MERCHANT;
            $merchantUser->verification_status  = Status::INACTIVE;
            $merchantUser->otp                  = $otp;
            $hub                                = Hub::find(1);
            $merchantUser->hub_id               = $hub->id;
            $merchantUser->save();

            $merchant                           = new Merchant();
            $merchant->user_id                  = $merchantUser->id;
            $merchant->business_name            = $request->business_name;
            $merchant->merchant_unique_id       = $this->generateUniqueID();
            $merchant->cod_charges              = array(
                'inside_city'    => "1",
                'sub_city'       => "2",
                'outside_city'   => "3",
            );
            $merchant->address                  = $request->address;
            $merchant->opening_balance          = 0;
            $merchant->vat                      = 0;
            $merchant->save();

            $shop               = new MerchantShops();
            $shop->merchant_id  = $merchant->id;
            $shop->name         = $merchant->business_name;
            $shop->contact_no   = $request->mobile;
            $shop->address      = $request->address;
            if($request->status):
                $shop->status       = $request->status;
            else:
                $shop->status       = Status::ACTIVE;
            endif;
            $shop->default_shop = Status::ACTIVE;

            $shop->save();

            $deliveryCharges =  DeliveryCharge::with('category')->orderBy('position')->get();

            if(!blank($deliveryCharges)){
                foreach ($deliveryCharges as $delivery){
                    $deliveryCharge                      = new MerchantDeliveryCharge();
                    $deliveryCharge->merchant_id         = $merchant->id;
                    $deliveryCharge->delivery_charge_id  = $delivery->id;
                    $deliveryCharge->weight              = $delivery->weight;
                    $deliveryCharge->category_id         = $delivery->category_id;
                    $deliveryCharge->same_day            = $delivery->same_day;
                    $deliveryCharge->next_day            = $delivery->next_day;
                    $deliveryCharge->sub_city            = $delivery->sub_city;
                    $deliveryCharge->outside_city        = $delivery->outside_city;
                    $deliveryCharge->status              = Status::ACTIVE;
                    $deliveryCharge->save();
                }
            }

            session([
                'otp'     => $otp,
                'mobile'  => $request->mobile,
                'password'=> $request->password
            ]);
            $response =  app(SmsService::class)->sendOtp($merchantUser->mobile,$merchantUser->otp);
            DB::commit();
            return true;
       }
        catch (\Exception $e) {

            DB::rollBack();
            return false;
        }
    }
    // Resend OTP
    public function resendOTP($request) {
        try {
            $otp                                = random_int(10000, 99999);

            $merchantUser = User::where('mobile', $request->mobile)->first();
            $merchantUser->otp                  = $otp;
            $merchantUser->save();

            session([
                'otp'     => $otp,
                'mobile'  => $request->mobile,
            ]);

            $response =  app(SmsService::class)->sendOtp($merchantUser->mobile,$merchantUser->otp);

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    // OTP verification
    public function otpVerification($request) {
        try {

            $merchantUser     = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
            if($merchantUser != null){
                $merchantUser->verification_status = Status::ACTIVE;
                $merchantUser->save();
                return $merchantUser;
            }
            else
                return 0;

        }
        catch (\Exception $e) {
            return false;
        }
    }

    //update merchant data
    public function update($id,$request) {

        $merchant = Merchant::find($id);

        try {
            DB::beginTransaction();
            $cod_charges = [];
            foreach($request->area as $key => $area){
                $cod_charges[$area] = $request->charge[$area];
            }

            $merchantUser                       = User::find($merchant->user_id);
            $merchantUser->name                 = $request->name;
            $merchantUser->mobile               = $request->mobile;
            $merchantUser->email                = $request->email;
            if($request->password != null)
                $merchantUser->password         = Hash::make($request->password);
            $merchantUser->address              = $request->address;
            $merchantUser->user_type            = UserType::MERCHANT;
            $merchantUser->hub_id               = $request->hub;
            $merchantUser->status               = $request->status;

            if($request->image_id != null) {
                $merchantUser->image_id = $this->merchant_image($merchantUser->image_id, $request->image_id);
            }

            $merchantUser->save();

            // Merchant row
            $merchant->business_name        = $request->business_name;
            if($request->opening_balance !==""){
                $merchant->current_balance      = $request->opening_balance;
                $merchant->opening_balance      = $request->opening_balance;
            }
            ;
            if($request->vat !==""){
            $merchant->vat                  = $request->vat;
            }
            $merchant->cod_charges          = $cod_charges;
            $merchant->address              = $request->address;

            if(isset($request->nid) && $request->nid != null) {
                $merchant->nid_id = $this->merchaant_nid($merchant->nid_id, $request->nid);
            }

            if(isset($request->trade_license) &&$request->trade_license != null) {
                $merchant->trade_license = $this->trade_license($merchant->trade_license, $request->trade_license);
            }

            $merchant->save();
            DB::commit();
            return true;
        }
        catch (\Exception $e) {

            DB::rollBack();
            return false;
        }
    }

    // for merchant image upload
    public function merchant_image($image_id = '', $image) {
        try {

            $image_name = '';
            if(!blank($image)){
                $destinationPath       = public_path('uploads/merchant/image');
                $merchantImage         = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $merchantImage);
                $image_name            = 'uploads/merchant/image/'.$merchantImage;
            }

            if(blank($image_id)){
                $upload           = new Upload();
            }else{
                $upload           = Upload::find($image_id);
                if(file_exists($upload->original))
                {
                    unlink($upload->original);
                }
            }

            $upload->original     = $image_name;
            $upload->save();
            return $upload->id;

        }
        catch (\Exception $e) {
            return false;
        }
    }
    // for trade_license upload
    public function trade_license ($trade_license  = '', $image) {
        try {

            $image_name = '';
            if(!blank($image)){
                $destinationPath       = public_path('uploads/merchant/trade_license');
                $tradeLicense          = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $tradeLicense);
                $image_name            = 'uploads/merchant/trade_license/'.$tradeLicense;
            }

            if(blank($trade_license)){
                $upload           = new Upload();
            }else{
                $upload           = Upload::find($trade_license);
                if(file_exists($upload->original))
                {
                    unlink($upload->original);
                }
            }

            $upload->original     = $image_name;
            $upload->save();
            return $upload->id;

        }
        catch (\Exception $e) {
            return false;
        }
    }
    // for merchant nid upload
    public function merchaant_nid ($nid_id  = '', $image) {
        try {

            $image_name = '';
            if(!blank($image)){
                $destinationPath = public_path('uploads/merchant/nid');
                $nid             = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $nid);
                $image_name      = 'uploads/merchant/nid/'.$nid;
            }
            if(blank($nid_id)){
                $upload           = new Upload();
            }else{
                $upload           = Upload::find($nid_id);
                if(file_exists($upload->original))
                {
                    unlink($upload->original);
                }
            }

            $upload->original     = $image_name;
            $upload->save();
            return $upload->id;

        }
        catch (\Exception $e) {
            return false;
        }
    }
    // for unique id ganarate
    public function generateUniqueID() {
        do {
            $merchant_unique_id = random_int(100000, 999999);
        } while (Merchant::where("merchant_unique_id", "=", $merchant_unique_id)->first());

        return $merchant_unique_id;
    }

    public function delete($id) {
        // try {
            // Find merchant row
            $merchant = Merchant::find($id);
            // Find user row
            $user     = User::find($merchant->user_id);


            $upload     = Upload::find($user->image_id);
            if($upload != null && file_exists($upload->original))
            {
                unlink($upload->original);
                $upload->delete();
            }
            $user->delete();


            $nid     = Upload::find($merchant->nid_id);
            if($nid != null && file_exists($nid->original))
            {
                unlink($nid->original);
                $nid->delete();
            }


            $trade_license     = Upload::find($merchant->trade_license);
            if($trade_license != null && file_exists($trade_license->original))
            {
                unlink($trade_license->original);
                $trade_license->delete();
            }

            // Delete merchant row
            $merchant->delete();

            return true;
        // }
        // catch (\Exception $e) {
        //     return false;
        // }
    }
}
