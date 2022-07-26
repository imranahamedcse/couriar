<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\HubManage\Payment\ProcessRequest;
use App\Http\Requests\HubManage\Payment\StoreRequest;
use App\Http\Requests\HubManage\Payment\UpdateRequest;
use App\Models\Backend\Account;
use App\Models\Backend\HubPayment;
use App\Models\Backend\Merchant;
use App\Models\Backend\Payment;
use App\Models\MerchantPayment;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Hub\HubInterface;
use App\Repositories\HubManage\HubPayment\HubPaymentInterface;
use App\Repositories\Merchant\MerchantInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Type\Decimal;

class HubPaymentController extends Controller
{

   protected $hub;
   protected $account;
   protected $payment;

    public function __construct(
        AccountInterface $account,
        HubInterface $hub,
        HubPaymentInterface $payment
        )
    {
            $this->account  = $account;
            $this->payment  = $payment;
            $this->hub     = $hub;
    }
    public function index(){
        $payments = $this->payment->all();
        return view('backend.hub_payment.index',compact('payments'));
    }

    public function create(){
        $hubs        = $this->hub->all();
        $accounts   = $this->account->all();
        return view('backend.hub_payment.create',compact('hubs','accounts'));
    }


    //payment store
    public function paymentStore(StoreRequest $request){

        if($request->isprocess):
            $courier_account = Account::find($request->from_account);
            if((double) $request->amount > $courier_account->balance){
                toast(__('hub_payment.not_enough_courier_balance'),'warning');
                return back()->withInput();
            }
        endif;

        if($this->payment->store($request)){
            toast(__('hub_payment.added_msg'),'success');
            return redirect()->route('hub.hub-payment.index');
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return Redirect::back()->withInput();
        }

    }

    //edit
    public function edit($id){
        $singlePayment    = $this->payment->get($id);
        $hubs             = $this->hub->all();
        $accounts         = $this->account->all();
        return view('backend.hub_payment.edit',compact('singlePayment','hubs','accounts'));
    }

    public function update(UpdateRequest $request,$id){

        //courier account balance check
        if($request->isprocess):
            $courier_account = Account::find($request->from_account);
            if((double) $request->amount > $courier_account->balance){
                toast(__('hub_payment.not_enough_courier_balance'),'warning');
                return back()->withInput();
            }
        endif;

        if($this->payment->update($id,$request)){
            toast(__('hub_payment.update_msg'),'success');
            return redirect()->route('hub.hub-payment.index');
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return Redirect::back()->withInput();
        }
    }

    public function destroy($id){
        $this->payment->delete($id);
        toast(__('hub_payment.delete_msg'),'success');
        return back();
    }


    //process section
    public function reject($id){
        if($this->payment->reject($id)){
            toast(__('hub_payment.rejected_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function cancelReject($id){
        if($this->payment->cancelReject($id)){
            toast(__('hub_payment.cancel_rejected_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function process($id){

        try {
            $payment  = HubPayment::findOrFail($id);
            $accounts = $this->account->all();
            return view('backend.hub_payment.process',compact('payment','accounts'));
        } catch (\Exception $exception){
            return redirect()->back();
        }

    }

    public function cancelProcess($id){
        if($this->payment->cancelProcess($id)){
            toast(__('hub_payment.cancel_processed_msg'),'success');
            return redirect()->back();
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function processed(ProcessRequest $request){
        $payment                    = HubPayment::where('id',$request->id)->first();
        $courier_account            = Account::find($request->from_account);
        if((double) $payment->amount > $courier_account->balance){
            toast(__('hub_payment.not_enough_courier_balance'),'warning');
            return back()->withInput();
        }

        if($this->payment->processed($request)){
            toast(__('hub_payment.processed_msg'),'success');
            return redirect()->route('hub.hub-payment.index');
        }else{
            toast(__('hub_payment.error_msg'),'error');
            return redirect()->back();
        }
    }
}
