<?php

namespace App\Domains\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domains\Image\Image;

use App\Domains\Event\Models\Event;

use App\Domains\ClassroomEvent\Models\ClassroomEvent;

use App\Domains\AttendancePresence\Models\AttendancePresence;

class Attendance extends Model
{
    protected $fillable = [

        'event_id',
        'classroom_event_id',
        'project_id',
        'name',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function classroomEvent()
    {
        return $this->belongsTo(ClassroomEvent::class);
    }

    public function presences()
    {
        return $this->hasMany(\App\Domains\AttendancePresence\Models\AttendancePresence::class);
    }
    public function project()
    {
        return $this->belongsTo(
            \App\Domains\Project\Models\Project::class
        );
    }
}