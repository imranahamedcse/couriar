<?php

namespace App\Models\Backend;
use App\Models\User;
use App\Models\Backend\Upload;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Support extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable = [
        'user_id',
        'department_id',
        'service',
        'priority',
        'subject',
        'description',
        'date',

    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'user.name',
            'department.title',
            'service',
            'priority',
            'subject',
            'description',
            'date',

        ];
        return LogOptions::defaults()
        ->useLogName('Support')
        ->logOnly($logAttributes)
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }




    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function file ()
    {
        return $this->belongsTo(Upload::class, 'attached_file', 'id');
    }
    // Get single row in Upload table.
    public function attached_file ()
    {
        return $this->belongsTo(Upload::class, 'attached_file', 'id');
    }
    public function getAttachedAttribute()
    {
        if (!empty($this->attached_file->original['original']) && file_exists($this->attached_file->original['original'])) {
            return asset($this->attached_file->original['original']);
        }
        return asset('images/default/user.png');
    }
}
