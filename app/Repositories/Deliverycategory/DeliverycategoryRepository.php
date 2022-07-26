<?php
namespace App\Repositories\Deliverycategory;
use App\Models\Backend\Deliverycategory;
use App\Repositories\Deliverycategory\DeliverycategoryInterface;
use App\Enums\Status;
use App\Enums\UserType;

class DeliverycategoryRepository implements DeliverycategoryInterface{
    public function all(){
        return Deliverycategory::orderBy('position','asc')->paginate(10);
    }

    public function get($id){
        return Deliverycategory::find($id);
    }

    public function store($request){
        try {
            $Deliverycategory               = new Deliverycategory();
            $Deliverycategory->title        = $request->title;
            $Deliverycategory->status       = $request->status;
            $Deliverycategory->position     = $request->position;
            $Deliverycategory->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function update($request)
    {
        $request->validate([
            'title' => 'required|unique:deliverycategories,title,'.$request->id,
        ]);

        try {
            $Deliverycategory                   = Deliverycategory::find($request->id);
            $Deliverycategory->title            = $request->title;
            $Deliverycategory->status           = $request->status;
            $Deliverycategory->position         = $request->position;
            $Deliverycategory->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function delete($id){
        return Deliverycategory::destroy($id);
    }
}
