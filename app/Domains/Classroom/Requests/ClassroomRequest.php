<?php

namespace App\Domains\Classroom\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weekday' => 'required|string|max:255',
            'created_at' => 'nullable|date|',
            'updated_at' => 'nullable|date',
            'deleted_at' => 'nullable|date|after:created_at',
            'start_at' => 'required|date|',
            'end_at' => 'required|date|after:start_at',
        ];
    }
}