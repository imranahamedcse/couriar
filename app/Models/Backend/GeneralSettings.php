<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GeneralSettings extends Model
{
    use HasFactory,LogsActivity;


    protected $fillable = [
       
        'phone',
        'name',
        'tracking_id',
        'details',
    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [

            'phone',
            'name',
            'tracking_id',
            'details',
        ];
        return LogOptions::defaults()
        ->useLogName('General Settings')
        ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }



    // Get single row in Upload table.
    public function rxlogo()
    {
        return $this->belongsTo(Upload::class, 'logo', 'id');
    }
    public function rxfavicon()
    {
        return $this->belongsTo(Upload::class, 'favicon', 'id');
    }

    public function getLogoImageAttribute()
    {
        if (!empty($this->rxlogo->original['original']) && file_exists($this->rxlogo->original['original'])) {
            return asset($this->rxlogo->original['original']);
        }
        return asset('images/default/user.png');
    }

    public function getFaviconImageAttribute()
    {
        if (!empty($this->rxfavicon->original['original']) && file_exists($this->rxfavicon->original['original'])) {
            return asset($this->rxfavicon->original['original']);
        }
        return asset('images/default/user.png');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
