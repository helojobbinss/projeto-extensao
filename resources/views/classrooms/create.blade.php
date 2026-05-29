@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Criar Sala de Aula</h2>

    <form
        method="POST"
        action="{{ route('classrooms.store') }}"
    >

        @csrf

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

                        {{ old('project_id') == $project->id
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

            <label>Nome</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >

        </div>

        {{-- Descrição --}}
        <div class="form-group mb-3">

            <label>Descrição</label>

            <textarea
                name="description"
                class="form-control"
                rows="4"
            >{{ old('description') }}</textarea>

        </div>

        {{-- Dias da semana --}}
        <div class="form-group mb-4">

            <label class="mb-2">
                Dias da Semana
            </label>

            <div class="weekday-buttons">

                <input
                    type="checkbox"
                    id="mon"
                    name="weekdays[]"
                    value="monday"

                    {{
                        in_array(
                            'monday',
                            old('weekdays', [])
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="mon">S</label>

                <input
                    type="checkbox"
                    id="tue"
                    name="weekdays[]"
                    value="tuesday"

                    {{
                        in_array(
                            'tuesday',
                            old('weekdays', [])
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="tue">T</label>

                <input
                    type="checkbox"
                    id="wed"
                    name="weekdays[]"
                    value="wednesday"

                    {{
                        in_array(
                            'wednesday',
                            old('weekdays', [])
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="wed">Q</label>

                <input
                    type="checkbox"
                    id="thu"
                    name="weekdays[]"
                    value="thursday"

                    {{
                        in_array(
                            'thursday',
                            old('weekdays', [])
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="thu">Q</label>

                <input
                    type="checkbox"
                    id="fri"
                    name="weekdays[]"
                    value="friday"

                    {{
                        in_array(
                            'friday',
                            old('weekdays', [])
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <label for="fri">S</label>

            </div>

        </div>

        {{-- Período --}}
        <div class="row mb-4">

            <div class="col">

                <label>
                    Data Inicial
                </label>

                <input
                    type="date"
                    name="starts_on"
                    class="form-control"
                    value="{{ old('starts_on') }}"
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
                    value="{{ old('ends_on') }}"
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
                    value="{{ old('start_time') }}"
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
                    value="{{ old('end_time') }}"
                    required
                >

            </div>

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >

            Salvar Sala de Aula

        </button>

    </form>

</div>

@endsection