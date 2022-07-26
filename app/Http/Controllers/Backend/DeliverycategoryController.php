<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Deliverycategory\StoreRequest;
use App\Http\Requests\Deliverycategory\UpdateRequest;
use App\Repositories\Deliverycategory\DeliverycategoryInterface;

class DeliverycategoryController extends Controller
{
    protected $repo;
    public $notDeleteArray = [1];
    public function __construct(DeliverycategoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $deliverycategorys = $this->repo->all();
        $notDeleteArray = $this->notDeleteArray;
        return view('backend.deliverycategory.index',compact('deliverycategorys','notDeleteArray'));
    }

    public function create()
    {
        return view('backend.deliverycategory.create');
    }

    public function store(StoreRequest $request)
    {
        if($this->repo->store($request)){
            toast('Deliverycategory successfully added.','success');
            return redirect()->route('delivery-category.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $deliverycategory = $this->repo->get($id);
        return view('backend.deliverycategory.edit',compact('deliverycategory'));
    }

    public function update(UpdateRequest $request)
    {

        if($this->repo->update($request)){
            toast('Deliverycategory successfully updated.','success');
            return redirect()->route('delivery-category.index');
        }else{
            toast('Something went wrong.','error');
            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        toast('Deliverycategory successfully deleted.','success');
        return back();
    }
}
