<?php

namespace App\Domains\AttendancePresence\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domains\Attendance\Models\Attendance;

use App\Domains\Participant\Models\Participant;

class AttendancePresence extends Model
{
    protected $fillable = [
        'attendance_id',
        'participant_id',
        'present',
        'observation',
    ];

    protected $casts = [

        'present' => 'boolean',
    ];

    public function attendance()
    {
        return $this->belongsTo(
            Attendance::class
        );
    }

    public function participant()
    {
        return $this->belongsTo(
            Participant::class
        );
    }
}