<?php
namespace App\Repositories\GeneralSettings;
use App\Models\Backend\GeneralSettings;
use App\Models\Backend\Upload;
use App\Repositories\GeneralSettings\GeneralSettingsInterface;

class GeneralSettingsRepository implements GeneralSettingsInterface{

    public function all(){ 

        $row = GeneralSettings::find(1);
        return $row;
    }

    public function update($request){

        $row               = GeneralSettings::find(1);
        $row->name         = $request->name;
        $row->phone        = $request->phone;
        $row->email        = $request->email;
        $row->currency     = $request->currency;
        $row->copyright    = $request->copyright;

        if(isset($request->logo) && $request->logo != null)
        {
            $row->logo = $this->file($row->logo, $request->logo);
        }
        if(isset($request->favicon) && $request->favicon != null)
        {
            $row->favicon = $this->file($row->favicon, $request->favicon);
        }

        $row->save();
        return $row;

    }

    public function file($image_id = '', $image)
    {
        try {

            $image_name = '';
            if(!blank($image)){
                $destinationPath       = public_path('uploads/settings');
                $profileImage          = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $image_name            = 'uploads/settings/'.$profileImage;
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

}
