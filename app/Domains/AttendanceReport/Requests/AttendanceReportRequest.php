<?php

namespace App\Domains\AttendanceReport\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'         => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'activities'    => 'nullable|string',
            'observations'  => 'nullable|string',
            'images'        => 'nullable|array',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB por imagem
        ];
    }

    public function messages(): array
    {
        return [
            'images.*.image'    => 'O arquivo enviado não é uma imagem válida.',
            'images.*.mimes'    => 'Imagens devem ser jpg, jpeg, png ou webp.',
            'images.*.max'      => 'Cada imagem deve ter no máximo 5MB.',
        ];
    }
}
