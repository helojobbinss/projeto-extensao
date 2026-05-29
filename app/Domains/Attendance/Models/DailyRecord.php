<?php

namespace App\Domains\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    protected $table = 'daily_records'; 

    protected $fillable = [
        'attendance_id',
        'participant_id',
        'status'
    ];
}