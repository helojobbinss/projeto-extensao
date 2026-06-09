<?php

namespace App\Domains\PendingVolunteer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendingVolunteerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pending_volunteers,email',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:active,inactive,finished',
        ];
    }
}