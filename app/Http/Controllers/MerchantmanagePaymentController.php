<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\Merchantmanage\Payment\ProcessRequest;
use App\Http\Requests\Merchantmanage\Payment\StoreRequest;
use App\Http\Requests\Merchantmanage\Payment\UpdateRequest;
use App\Models\Backend\Account;
use App\Models\Backend\Merchant;
use App\Models\Backend\Payment;
use App\Models\MerchantPayment;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\Merchantmanage\Payment\PaymentInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Type\Decimal;

class MerchantmanagePaymentController extends Controller
{

   protected $merchant;
   protected $account;
   protected $payment;

    public function __construct(
        MerchantInterface $merchant,
        AccountInterface $account,
        PaymentInterface $payment
        )
    {
            $this->merchant = $merchant;
            $this->account  = $account;
            $this->payment  = $payment;
    }
    public function index(){
        $payments = $this->payment->all();
        return view('backend.merchantmanage.payment.index',compact('payments'));
    }

    public function create(){
        $merchants = $this->merchant->all();
        $accounts  = $this->account->all();
        return view('backend.merchantmanage.payment.create',compact('merchants','accounts'));
    }

    public function merchantAccount(Request $request){
        $merchantaccounts = MerchantPayment::where('merchant_id',$request->merchant_id)->get();
        $accounts         = "";
        $accounts        .= "<option selected disabled>". __('menus.select').' '.__('merchant.title').' '. __('account.title')."</option>";
        foreach ($merchantaccounts as $account) {
            if($account->payment_method == 'bank'){
                $accounts.="<option value='".$account->id."'>".$account->holder_name.' | '.$account->bank_name.' | '.$account->account_no.' | '.$account->branch_name."</option>";
            }elseif($account->payment_method == 'mobile'){
                $accounts.="<option value='".$account->id."'>".$account->mobile_company.' | '.$account->mobile_no.'|'.$account->account_type."</option>";
            }
        }
        return  $accounts;
    }

    public function merchantSearch(Request $request){
        $search         = $request->search;
        if($search == ''){
            $merchants  = [];
        }else{
            $merchants  = Merchant::where('status',Status::ACTIVE)->orderby('business_name','asc')->select('id','business_name')->where('business_name', 'like', '%' .$search . '%')->limit(10)->get();
        }
        $response=[];
        foreach($merchants as $merchant){
            $response[] = array(
                "id"    => $merchant->id,
                "text"  => $merchant->business_name,
            );
        }
        return response()->json($response);
    }


    //payment store
    public function paymentStore(StoreRequest $request){


        $account  = Merchant::where('id',$request->merchant)->first();
        $balance = (double) $account->current_balance;
        if((double) $request->amount > $balance){
            toast(__('merchantmanage.not_enough_merchant_balance'),'warning');
            return back()->withInput();
        }

        if($request->isprocess):
            $courier_account = Account::find($request->from_account);
            if((double) $request->amount > $courier_account->balance){
                toast(__('merchantmanage.not_enough_courier_balance'),'warning');
                return back()->withInput();
            }
        endif;

        if($this->payment->store($request)){
            toast(__('merchantmanage.added_msg'),'success');
            return redirect()->route('merchant.manage.payment.index');
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return Redirect::back()->withInput();
        }

    }

    //edit
    public function edit($id){
        $singlePayment    = $this->payment->get($id);
        $merchants        = $this->merchant->all();
        $accounts         = $this->account->all();
        $merchantaccounts = MerchantPayment::where('merchant_id',$singlePayment->merchant_id)->get();
        return view('backend.merchantmanage.payment.edit',compact('singlePayment','merchants','accounts','merchantaccounts'));
    }

    public function update(UpdateRequest $request){

        //merchant balance check
        $account  = Merchant::where('id',$request->merchant)->first();
        $balance = (double) $account->current_balance;
        if((double) $request->amount > $balance){
            toast(__('merchantmanage.not_enough_merchant_balance'),'warning');
            return back()->withInput();
        }

        //courier account balance check
        if($request->isprocess):
            $courier_account = Account::find($request->from_account);
            if((double) $request->amount > $courier_account->balance){
                toast(__('merchantmanage.not_enough_courier_balance'),'warning');
                return back()->withInput();
            }
        endif;

        if($this->payment->update($request)){
            toast(__('merchantmanage.update_msg'),'success');
            return redirect()->route('merchant.manage.payment.index');
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return Redirect::back()->withInput();
        }
    }

    public function destroy($id){
        $this->payment->delete($id);
        toast(__('merchantmanage.delete_msg'),'success');
        return back();
    }


    //process section
    public function reject($id){
        if($this->payment->reject($id)){
            toast(__('merchantmanage.rejected_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function cancelReject($id){
        if($this->payment->cancelReject($id)){
            toast(__('merchantmanage.cancel_rejected_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function process($id){
        $payment  = Payment::where('id',$id)->first();
        $accounts = $this->account->all();
        return view('backend.merchantmanage.payment.process',compact('payment','accounts'));
    }

    public function cancelProcess($id){
        if($this->payment->cancelProcess($id)){
            toast(__('merchantmanage.cancel_processed_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function processed(ProcessRequest $request){

        $payment                    = Payment::where('id',$request->id)->first();
        $courier_account            = Account::find($request->from_account);
        if((double) $payment->amount > $courier_account->balance){
            toast(__('merchantmanage.not_enough_courier_balance'),'warning');
            return back()->withInput();
        }

        if($this->payment->processed($request)){
            toast(__('merchantmanage.processed_msg'),'success');
            return redirect()->route('merchant.manage.payment.index');
        }else{
            toast(__('merchantmanage.error_msg'),'error');
            return redirect()->back();
        }
    }
}
