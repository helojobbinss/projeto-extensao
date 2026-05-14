<?php
namespace App\Domains\Attendance\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Image\Image;
use App\Domains\Event\Models\Event;
use App\Domains\User\Models\User;

class Attendance extends Model
{
    protected $fillable = [
        'participant_id',
        'event_id',
        'date',
        'status',
    ];

    public function participant()
    {
        return $this->belongsTo(\App\Domains\User\Models\User::class, 'participant_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}