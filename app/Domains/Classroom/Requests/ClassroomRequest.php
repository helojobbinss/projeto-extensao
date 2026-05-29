<?php

namespace App\Domains\Classroom\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([

            'start_time' => $this->start_time
                ? substr($this->start_time, 0, 5)
                : null,

            'end_time' => $this->end_time
                ? substr($this->end_time, 0, 5)
                : null,
        ]);
    }

    public function rules(): array
    {
        return [

            'name' => ['required','string','max:255',],

            'description' => ['nullable','string',],

            'weekdays' => [
                'required',
                'array',
                'min:1',
            ],

            'weekdays.*' => [
                'string',
                'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ],

            'starts_on' => [
                'required',
                'date',
            ],

            'ends_on' => [
                'required',
                'date',
                'after_or_equal:starts_on',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'project_id' => [
                'required',
                'exists:projects,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'weekdays.required' =>
                'Selecione ao menos um dia da semana.',

            'weekdays.min' =>
                'Selecione ao menos um dia da semana.',

            'ends_on.after_or_equal' =>
                'A data final deve ser maior ou igual à inicial.',

            'end_time.after' =>
                'O horário final deve ser maior que o horário inicial.',

            'start_time.date_format' =>
                'O horário inicial é inválido.',

            'end_time.date_format' =>
                'O horário final é inválido.',
        ];
    }
}