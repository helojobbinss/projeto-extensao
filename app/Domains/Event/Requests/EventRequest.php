<?php

namespace App\Domains\Event\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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

            'start_datetime' => 'required|date',

            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',

            'project_id' => 'required|exists:projects,id',

            'classroom_id' => 'nullable|exists:classrooms,id',

            'status' => 'nullable|in:scheduled,active,finished,cancelled',
        ];
    }
}