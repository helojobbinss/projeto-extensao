<?php
namespace App\Domains\Project\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Image\Image;

class Project extends Model
{
    protected $fillable = [
        'name',
        'coordinator_id',
        'description',
        'location',
        'target_audience',
        'start_date',
        'end_date',
        'vacancies',
        'status',
    ];

    public function coordinator()
    {
        return $this->belongsTo(\App\Domains\User\Models\User::class, 'coordinator_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function participants()
    {
        return $this->belongsToMany(
            \App\Domains\User\Models\User::class,
            'participants'
        );
    }
}