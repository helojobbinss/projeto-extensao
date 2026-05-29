<?php

namespace App\Domains\Classroom\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Domains\ClassroomEvent\Models\ClassroomEvent;
use App\Domains\Project\Models\Project;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'description',
        'weekdays',
        'starts_on',
        'ends_on',
        'start_time',
        'end_time',
        'project_id',
    ];

    protected $casts = [

        'weekdays' => 'array',

        'starts_on' => 'date',

        'ends_on' => 'date',
    ];

    public function events()
    {
        return $this->hasMany(ClassroomEvent::class);
    }

    protected function serializeDate(
        DateTimeInterface $date
    ): string {
        return $date->format('d/m/Y H:i');
    }

    public function project()
    {
        return $this->belongsTo(
            Project::class
        );
    }
}