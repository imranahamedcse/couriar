<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ParcelEvent extends Model
{
    use HasFactory;
    // use HasFactory,LogsActivity;

    // protected  $fillable = [
    //     'parcel_id',
    //     'delivery_man_id',
    //     'pickup_man_id',
    //     'hub_id',
    //     'transfer_delivery_man_id',
    //     'note',
    //     'parcel_status',
    // ];

    // public function getActivitylogOptions(): LogOptions
    // {

    //     $logAttributes = [
    //         'parcel_id',
    //         'delivery_man_id',
    //         'pickup_man_id',
    //         'hub_id',
    //         'transfer_delivery_man_id',
    //         'note',
    //         'parcel_status',
    //     ];
    //     return LogOptions::defaults()
    //     ->useLogName('ParcelEvent')
    //     ->logOnly($logAttributes)
    //         ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    // }




    public function deliveryMan(){
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id','id');
    }
    public function pickupman(){
        return $this->belongsTo(DeliveryMan::class,'pickup_man_id','id');
    }
    public function transferDeliveryman(){
        return $this->belongsTo(DeliveryMan::class,'transfer_delivery_man_id','id');
    }
    public function hub(){
        return $this->belongsTo(Hub::class,'hub_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
