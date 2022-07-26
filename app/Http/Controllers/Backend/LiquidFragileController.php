<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class LiquidFragileController extends Controller
{
    public function index(){

       return view('backend.liquid_fragile.index');
    }
    public function edit(){

       $editliquid='edit';
       return view('backend.liquid_fragile.index',compact('editliquid'));
    }

    public function update(Request $request){
        $liquid         = Config::where('key','fragile_liquid_charge')->first();
        $liquid->value  = $request->charge;
        $liquid->save();
        if($liquid){
            toast('Liquid/Fragile updated successfully.','success');
            return redirect()->route('liquid-fragile.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function status(Request $request){

        $liquid            =  Config::where('key','fragile_liquid_status')->first();
        if($liquid->value  == Status::ACTIVE){
            $liquid->value =  Status::INACTIVE;
        }else{
            $liquid->value =  Status::ACTIVE;
        }
        $liquid->save();
        return $liquid;

    }
}
