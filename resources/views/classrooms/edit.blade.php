@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Sala de Aula</h2>

    <form
        method="POST"
        action="{{ route('classrooms.update', $classroom->id) }}"
    >

        @csrf
        @method('PUT')

        {{-- Projeto --}}
        <div class="form-group mb-3">

            <label>
                Projeto
            </label>

            <select
                name="project_id"
                class="form-control"
                required
            >

                <option value="">
                    Selecione um projeto
                </option>

                @foreach($projects as $project)

                    <option
                        value="{{ $project->id }}"

                        {{
                            old(
                                'project_id',
                                $classroom->project_id
                            ) == $project->id
                                ? 'selected'
                                : ''
                        }}
                    >

                        {{ $project->name }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Nome --}}
        <div class="form-group mb-3">

            <label>
                Nome da Sala
            </label>

            <input
                type="text"
                name="name"
                class="form-control"

                value="{{
                    old(
                        'name',
                        $classroom->name
                    )
                }}"

                required
            >

        </div>

        {{-- Descrição --}}
        <div class="form-group mb-4">

            <label>
                Descrição
            </label>

            <textarea
                name="description"
                class="form-control"
                rows="4"
            >{{
                old(
                    'description',
                    $classroom->description
                )
            }}</textarea>

        </div>

        {{-- Dias da semana --}}
        <div class="form-group mb-4">

            <label class="mb-2">
                Dias da Semana
            </label>

            @php

                $weekdays = old(
                    'weekdays',
                    $classroom->weekdays ?? []
                );

            @endphp

            <div class="weekday-buttons">

                {{-- Segunda --}}
                <input
                    type="checkbox"
                    id="mon"
                    name="weekdays[]"
                    value="monday"

                    {{
                        in_array(
                            'monday',
                            $weekdays
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="mon">S</label>

                {{-- Terça --}}
                <input
                    type="checkbox"
                    id="tue"
                    name="weekdays[]"
                    value="tuesday"

                    {{
                        in_array(
                            'tuesday',
                            $weekdays
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="tue">T</label>

                {{-- Quarta --}}
                <input
                    type="checkbox"
                    id="wed"
                    name="weekdays[]"
                    value="wednesday"

                    {{
                        in_array(
                            'wednesday',
                            $weekdays
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="wed">Q</label>

                {{-- Quinta --}}
                <input
                    type="checkbox"
                    id="thu"
                    name="weekdays[]"
                    value="thursday"

                    {{
                        in_array(
                            'thursday',
                            $weekdays
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="thu">Q</label>

                {{-- Sexta --}}
                <input
                    type="checkbox"
                    id="fri"
                    name="weekdays[]"
                    value="friday"

                    {{
                        in_array(
                            'friday',
                            $weekdays
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="fri">S</label>

            </div>

        </div>

        {{-- Datas --}}
        <div class="row mb-4">

            <div class="col">

                <label>
                    Data Inicial
                </label>

                <input
                    type="date"
                    name="starts_on"
                    class="form-control"

                    value="{{
                        old(
                            'starts_on',
                            optional(
                                $classroom->starts_on
                            )->format('Y-m-d')
                        )
                    }}"

                    required
                >

            </div>

            <div class="col">

                <label>
                    Data Final
                </label>

                <input
                    type="date"
                    name="ends_on"
                    class="form-control"

                    value="{{
                        old(
                            'ends_on',
                            optional(
                                $classroom->ends_on
                            )->format('Y-m-d')
                        )
                    }}"

                    required
                >

            </div>

        </div>

        {{-- Horários --}}
        <div class="row mb-4">

            <div class="col">

                <label>
                    Horário Inicial
                </label>

                <input
                    type="time"
                    name="start_time"
                    class="form-control"

                    value="{{
                        old(
                            'start_time',
                            $classroom->start_time
                        )
                    }}"

                    required
                >

            </div>

            <div class="col">

                <label>
                    Horário Final
                </label>

                <input
                    type="time"
                    name="end_time"
                    class="form-control"

                    value="{{
                        old(
                            'end_time',
                            $classroom->end_time
                        )
                    }}"

                    required
                >

            </div>

        </div>

        <button class="btn btn-primary">

            Atualizar Sala de Aula

        </button>

    </form>

</div>

@endsection