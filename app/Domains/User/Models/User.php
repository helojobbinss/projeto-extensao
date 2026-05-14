<?php

namespace App\Domains\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Domains\Image\Image;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_VOLUNTEER = 'volunteer';
    const ROLE_PARTICIPANT = 'participant';

    protected $fillable = [
        'name',
        'email',
        'password',
        'document',
        'phone',
        'birthday',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];


    public function setPasswordAttribute($value)
    {
        if (!$value) {
            return;
        }

        // evita rehash se já estiver em bcrypt
        if (preg_match('/^\$2y\$/', $value)) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = Hash::make($value);
    }
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isVolunteer()
    {
        return $this->role === self::ROLE_VOLUNTEER;
    }

    public function isParticipant()
    {
        return $this->role === self::ROLE_PARTICIPANT;
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function projects()
    {
        return $this->belongsToMany(
            \App\Domains\Project\Models\Project::class,
            'participants'
        );
    }
}