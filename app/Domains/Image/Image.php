<?php
namespace App\Domains\Image;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'original_name',
        'mime',
        'size',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}