<?php
namespace App\Domains\Volunteer\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Project\Models\Project;
use App\Domains\User\Models\User;

class Volunteer extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'status',
        'applied_at',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}