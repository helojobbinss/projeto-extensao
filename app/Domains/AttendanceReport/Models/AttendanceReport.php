<?php

namespace App\Domains\AttendanceReport\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Images\Models\Image;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendancePresences\Models\AttendancePresence;

class AttendanceReport extends Model
{
    protected $fillable = [
        'attendance_id',
        'title',
        'description',
        'activities',
        'observations',
        'present_count',
        'absent_count',
    ];

    /**
     * Imagens polimórficas do relatório
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Chamada à qual este relatório pertence
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    public function presences()
    {
        return $this->hasMany(\App\Domains\AttendancePresence\Models\AttendancePresence::class, 'attendance_id');
    }
}
