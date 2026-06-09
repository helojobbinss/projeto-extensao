<?php

namespace App\Domains\AttendancePresence\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\Participant\Models\Participant;

class AttendancePresence extends Model
{
    protected $fillable = [
        'attendance_id',
        'participant_id',
        'present',
        'observation',
    ];

    protected $casts = [
        'present' => 'boolean',
    ];

    /*
    |-----------------------------------------
    | RELACIONAMENTOS
    |-----------------------------------------
    */

    public function attendance()
    {
        return $this->belongsTo(
            Attendance::class,
            'attendance_id',
            'id'
        );
    }

    public function participant()
    {
        return $this->belongsTo(
            Participant::class,
            'participant_id',
            'id'
        );
    }

    /*
    |-----------------------------------------
    | BOA PRÁTICA (opcional mas recomendada)
    |-----------------------------------------
    */

    protected static function booted()
    {
        // garante limpeza lógica caso delete manual ocorra
        static::deleting(function (AttendancePresence $presence) {
            // aqui não precisa fazer nada normalmente,
            // mas deixa pronto para regras futuras
        });
    }
}