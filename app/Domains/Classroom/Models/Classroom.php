<?php
namespace App\Domains\Classroom\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Image\Image;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'description',
        'weekday',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d/m/Y H:i');
    }
}