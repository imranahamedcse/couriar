<?php
namespace App\Repositories\Hub;
use App\Models\Backend\Hub;
use App\Repositories\Hub\HubInterface;

class HubRepository implements HubInterface{
    public function all(){
        return Hub::orderByDesc('id')->paginate(10);
    }
    public function filter($request){
        return Hub::where(function($query)use($request){
            if($request->name){
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if($request->phone):
                $query->where('phone', 'like', '%' . $request->phone . '%');
            endif;

        })->orderByDesc('id')->paginate(10);
    }
    public function hubs(){
        return Hub::all();
    }

    public function get($id){
        return Hub::find($id);
    }

    public function store($request){
        try {
            $hub          = new Hub();
            $hub->name    = $request->name;
            $hub->phone   = $request->phone;
            $hub->address = $request->address;
            $hub->status  = $request->status;
            $hub->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function update($id, $request)
    {
        try {
            $hub          = Hub::find($id);
            $hub->name    = $request->name;
            $hub->phone   = $request->phone;
            $hub->address = $request->address;
            $hub->status  = $request->status;
            $hub->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function delete($id){
        return Hub::destroy($id);
    }
}
