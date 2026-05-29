<?php

namespace App\Domains\AttendancePresence\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendancePresenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [


            'attendance_id' => [

                'required',

                'exists:attendances,id',
            ],

            'participant_id' => [

                'required',

                'exists:participants,id',
            ],

            'present' => [

                'nullable',

                'boolean',
            ],

            'observation' => [

                'nullable',

                'string',

                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'attendance_id.required' =>

                'A chamada é obrigatória.',

            'attendance_id.exists' =>

                'A chamada selecionada não existe.',

            'participant_id.required' =>

                'O participante é obrigatório.',

            'participant_id.exists' =>

                'O participante selecionado não existe.',

            'present.boolean' =>

                'O campo presença deve ser verdadeiro ou falso.',

            'observation.max' =>

                'A observação pode ter no máximo 1000 caracteres.',
        ];
    }
}