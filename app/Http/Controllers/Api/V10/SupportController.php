<?php

namespace App\Http\Controllers\Api\V10;


use App\Http\Controllers\Controller;
use App\Http\Resources\v10\SupportResource;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use App\Repositories\MerchantPanel\Support\SupportInterface;
use App\Http\Requests\Support\StoreRequest;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    use ApiReturnFormatTrait;
    protected $repo;
    public function __construct(SupportInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        try {
            $supports = SupportResource::collection($this->repo->all());
            return $this->responseWithSuccess(__('support.supprot_list'), ['supports'=>$supports], 200);
        }catch (\Exception $exception){
            return $this->responseWithError(__('support.supprot_list'), [], 500);

        }
    }


    public function create()
    {
        try {
            $departments = $this->repo->departments();
            return $this->responseWithSuccess(__('support.supprot_add'), ['departments'=>$departments], 200);
        }catch (\Exception $exception){
            return $this->responseWithError(__('support.supprot_add'), [], 500);

        }
    }


    public function store(StoreRequest $request)
    {
        if($this->repo->store($request)){
            toast(__('support.added_msg'),'success');
            return redirect()->route('merchant-panel.support.index');
        }
        else{
            toast(__('support.error_msg'),'error');
            return redirect()->back()->withInput($request->all());
        }
    }


    public function edit($id)
    {
        $departments   = $this->repo->departments();
        $singleSupport = $this->repo->get($id);
        return view('backend.merchant_panel.support.edit',compact('departments','singleSupport'));
    }


    public function update(StoreRequest $request)
    {
        if($this->repo->update($request->id,$request)){
            toast(__('support.update_msg'),'success');
            return redirect()->route('merchant-panel.support.index');
        }
        else{
            toast(__('support.error_msg'),'error');
            return redirect()->back()->withInput($request->all());
        }
    }


    public function destroy($id)
    {
        if($this->repo->delete($id)){
            toast(__('support.delete_msg'),'success');
            return redirect()->route('merchant-panel.support.index');
        }
        else{
            toast(__('support.error_msg'),'error');
            return redirect()->back();
        }
    }


    public function view($id){
        $singleSupport = $this->repo->get($id);
        $chats         = $this->repo->chats($id);

        return view('backend.merchant_panel.support.view',compact('singleSupport','chats'));
    }

    public function supportReply(Request $request){
        $validator  = Validator::make($request->all(),[
            'message'   => 'required'
        ]);
        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        if($this->repo->reply($request)){
            toast(__('support.reply_msg'),'success');
            return redirect()->route('merchant-panel.support.view',$request->support_id);
        }else{
            toast(__('support.error_msg'),'error');
            return redirect()->back()->withInput($request->all());
        }
    }
}
