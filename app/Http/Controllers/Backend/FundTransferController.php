<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FundTransfer\StoreRequest;
use App\Http\Requests\FundTransfer\UpdateRequest;
use App\Repositories\FundTransfer\FundTransferInterface;
use App\Repositories\Account\AccountInterface;

class FundTransferController extends Controller
{
    protected $repo;
    public function __construct(FundTransferInterface $repo, AccountInterface $account)
    {
        $this->repo    = $repo;
        $this->account = $account;
    }

    public function index()
    {
        $fund_transfers = $this->repo->all();
        // return $fund_transfers;
        return view('backend.fund_transfer.index',compact('fund_transfers'));
    }

    public function create()
    {
        $accounts = $this->repo->accounts();
        return view('backend.fund_transfer.create',compact('accounts'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result == 2){
            toast(__('fund_transfer.not_enough_balance'),'warning');
            return redirect()->back()->withInput();
        }
        elseif($result == 3){
            toast(__('fund_transfer.more_than_0tk'),'warning');
            return redirect()->back()->withInput();
        }
        elseif($result == 1){
            toast(__('fund_transfer.added_msg'),'success');
            return redirect()->route('fund-transfer.index');
        }
        else{
            toast(__('fund_transfer.error_msg'),'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $accounts = $this->repo->accounts();
        $fund_transfer = $this->repo->get($id);
        $account = $this->account->get($fund_transfer->from_account);
        $current_balance = $account->balance + $fund_transfer->amount;
        return view('backend.fund_transfer.edit',compact('fund_transfer','accounts','current_balance'));
    }

    public function update($id, UpdateRequest $request)
    {
        $result = $this->repo->update($id, $request);
        if($result == 2){
            toast(__('fund_transfer.not_enough_balance'),'warning');
            return redirect()->back()->withInput();
        }
        elseif($result == 3){
            toast(__('fund_transfer.more_than_0tk'),'warning');
            return redirect()->back()->withInput();
        }
        elseif($result == 1){
            toast(__('fund_transfer.update_msg'),'success');
            return redirect()->route('fund-transfer.index');
        }else{
            toast(__('fund_transfer.error_msg'),'error');
            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        if($this->repo->delete($id)){
            toast(__('fund_transfer.delete_msg'),'success');
            return back();
        }else{
            toast(__('fund_transfer.error_msg'),'error');
            return redirect()->back();
        }
    }
}
