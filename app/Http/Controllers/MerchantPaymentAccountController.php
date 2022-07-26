<?php

namespace App\Http\Controllers;

use App\Http\Requests\Merchantpayment\StoreBankRequest;
use App\Http\Requests\Merchantpayment\StoreMobileRequest;
use Illuminate\Http\Request;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\MerchantPayment\PaymentInterface;
use Illuminate\Support\Facades\Redirect;

class MerchantPaymentAccountController extends Controller
{
    protected $repo;
    protected $payRepo;
    public function __construct(MerchantInterface $repo,PaymentInterface $payRepo)
    {
        $this->repo    = $repo;
        $this->payRepo = $payRepo;
    }
    public function index($id){
        $singleMerchant = $this->repo->get($id);
        $payments       = $this->payRepo->get($id);

        return view('backend.merchant.payment.index',compact('singleMerchant','payments'));
    }

    public function paymentAdd($id){
        $singleMerchant = $this->repo->get($id);
        $merchant_id    = $id;
        return view('backend.merchant.payment.add_payment',compact('singleMerchant','merchant_id' ));
    }
    public function paymentEdit($mid,$id){
        $singleMerchant = $this->repo->get($mid);
        $paymentInfo    = $this->payRepo->edit($id);
        $merchant_id    = $mid;
        return view('backend.merchant.payment.edit_payment',compact('singleMerchant','merchant_id','paymentInfo'));
    }

    public function paymentChange(Request $request){

        $payment_method = $request->payment_method;
        $merchant_id    = $this->repo->get($request->merchant_id)->id;
        $editid         = $request->editid;
        if($request->payment_method == 'bank'){
            return view('backend.merchant.payment.bank',compact('payment_method','merchant_id' ,'editid'));
        }elseif($request->payment_method == 'mobile'){
            return view('backend.merchant.payment.mobile',compact('payment_method','merchant_id','editid'));
        }
    }

    // bank payment information store
    public function bankStore(StoreBankRequest $request){


        if($this->payRepo->bankstore($request)){
            if($request->editid !==null){
                toast(__('merchant.payment_update_msg'),'success');
            }else{
                toast(__('merchant.payment_added_msg'),'success');
            }
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            toast(__('merchant.payment_error_msg'),'error');
            return Redirect::back()->withInput();
        }

    }



    //mobile payment information store
    public function mobileStore(StoreMobileRequest $request){

        if($this->payRepo->mobilestore($request)){
            if($request->editid !==null){
                toast(__('merchant.payment_update_msg'),'success');
            }else{
                toast(__('merchant.payment_added_msg'),'success');
            }
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            toast(__('merchant.payment_error_msg'),'error');
            return Redirect::back()->withInput();
        }

    }


    //update

    public function bankUpdate(StoreBankRequest $request){

        if($this->payRepo->bankupdate($request)){
            toast(__('merchant.payment_update_msg'),'success');
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            toast(__('merchant.payment_error_msg'),'error');
            return Redirect::back()->withInput();
        }
    }
    public function mobileUpdate(StoreMobileRequest $request){

        if($this->payRepo->mobileupdate($request)){
            toast(__('merchant.payment_update_msg'),'success');
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            toast(__('merchant.payment_error_msg'),'error');
            return Redirect::back()->withInput();
        }
    }


    public function destroy($id){
        $this->payRepo->delete($id);
        toast(__('merchant.payment_account_delete_msg'),'success');
        return back();
    }
}
