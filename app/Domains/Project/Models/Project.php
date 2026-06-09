<?php

namespace App\Domains\Project\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\User\Models\User;
use App\Domains\Volunteer\Models\Volunteer;
use App\Domains\Participant\Models\Participant;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'coordinator_id',
    ];

    /**
     * COORDENADOR
     */
    public function coordinator()
    {
        return $this->belongsTo(
            User::class,
            'coordinator_id'
        );
    }

    /**
     * VOLUNTÁRIOS
     */
    public function volunteers()
    {
        return $this->hasMany(
            Volunteer::class,
            'project_id'
        );
    }

    public function participants()
    {
        return $this->hasMany(
            Participant::class,
            'project_id'
        );
    }
}