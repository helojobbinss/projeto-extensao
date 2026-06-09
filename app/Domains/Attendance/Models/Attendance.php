<?php

namespace App\Domains\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domains\Images\Models\Image;
use App\Domains\Event\Models\Event;
use App\Domains\ClassroomEvent\Models\ClassroomEvent;
use App\Domains\AttendancePresence\Models\AttendancePresence;
use App\Domains\AttendanceReport\Models\AttendanceReport;

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

    /*
    |-----------------------------------------
    | RELACIONAMENTOS
    |-----------------------------------------
    */

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function classroomEvent()
    {
        return $this->belongsTo(ClassroomEvent::class);
    }

    public function project()
    {
        return $this->belongsTo(
            \App\Domains\Project\Models\Project::class
        );
    }

    public function presences()
    {
        return $this->hasMany(
            AttendancePresence::class,
            'attendance_id',
            'id'
        );
    }

    public function report()
    {
        return $this->hasOne(
            AttendanceReport::class,
            'attendance_id'
        );
    }

    /*
    |-----------------------------------------
    | CASCADE DELETE (CRÍTICO)
    |-----------------------------------------
    */
    protected static function booted()
    {
        static::deleting(function (Attendance $attendance) {

            
            $attendance->presences()->delete();

            // opcional: relatório
            if ($attendance->report) {
                $attendance->report->images()->delete();
                $attendance->report->delete();
            }

            // imagens da attendance
            $attendance->images()->delete();
        });
    }

    /*
    |-----------------------------------------
    | ACCESSORS (contagem)
    |-----------------------------------------
    */

    public function getPresentCountAttribute()
    {
        return $this->presences
            ->where('present', true)
            ->count();
    }

    public function getAbsentCountAttribute()
    {
        return $this->presences
            ->where('present', false)
            ->count();
    }
}