<?php

namespace App\Domains\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Project\Models\Project;
use App\Domains\Classroom\Models\Classroom;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_datetime',
        'end_datetime',
        'project_id',
        'classroom_id',
        'status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}