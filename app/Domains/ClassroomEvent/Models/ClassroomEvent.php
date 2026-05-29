<?php

namespace App\Domains\ClassroomEvent\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\Classroom\Models\Classroom;

class ClassroomEvent extends Model
{
    protected $fillable = [

        'classroom_id',

        'starts_at',
        'ends_at',

        'status',
    ];

    protected $casts = [

        'starts_at' => 'datetime',

        'ends_at' => 'datetime',
    ];

    public function attendance()
    {
        return $this->hasOne(
            Attendance::class
        );
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}