<?php

namespace App\Domains\Attendance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
        'participant_id' => 'required|exists:users,id',
        'event_id'       => 'required|exists:events,id',
        'date'           => 'required|date',
        'status'         => 'required|string|in:presente,falta,justificado',
        ];
    }
}