<?php

namespace App\Domains\Project\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'coordinator_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'target_audience' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'vacancies' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,finished',
        ];
    }
}