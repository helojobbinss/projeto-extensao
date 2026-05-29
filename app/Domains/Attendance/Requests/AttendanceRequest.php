<?php

namespace App\Domains\Attendance\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
public function rules(): array
{
    return [
        'description' => 'nullable|string',
        'date'        => 'nullable|date',
        'attendances' => 'nullable|array',
        'attendances.*.status' => 'required|string', 
    ];
}
}