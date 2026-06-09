<?php

namespace App\Domains\PendingVolunteer\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\User\Models\User;
use App\Domains\Project\Models\Project;

class PendingVolunteer extends Model
{
    protected $table = 'pending_volunteers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthdate',
        'description',
        'project_id',
        'status',
        'applied_at',
        'approved_at',
    ];
  

    /**
     * PROJECT
     */
    public function project()
    {
        return $this->belongsTo(
            Project::class,
            'project_id'
        );
    }
}