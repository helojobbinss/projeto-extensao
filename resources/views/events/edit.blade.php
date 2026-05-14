@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Evento</h2>

    <form method="POST" action="{{ route('events.update', $event->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nome</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $event->name) }}"
            >
        </div>

        <div class="form-group">
            <label>Projeto</label>

            <select name="project_id" class="form-control">

                @foreach($projects as $project)

                    <option
                        value="{{ $project->id }}"
                        {{ old('project_id', $event->project_id) == $project->id ? 'selected' : '' }}
                    >
                        {{ $project->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Sala de Aula</label>

            <select name="classroom_id" class="form-control">

                <option value="">
                    Sem sala
                </option>

                @foreach($classrooms as $classroom)

                    <option
                        value="{{ $classroom->id }}"
                        {{ old('classroom_id', $event->classroom_id) == $classroom->id ? 'selected' : '' }}
                    >
                        {{ $classroom->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Descrição</label>

            <textarea
                name="description"
                class="form-control"
                rows="4"
            >{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="row">

            <div class="col">
                <label>Data/Hora Início</label>

                <input
                    type="datetime-local"
                    name="start_datetime"
                    class="form-control"
                    value="{{ old(
                        'start_datetime',
                        optional($event->start_datetime)->format('Y-m-d\TH:i')
                    ) }}"
                >
            </div>

            <div class="col">
                <label>Data/Hora Fim</label>

                <input
                    type="datetime-local"
                    name="end_datetime"
                    class="form-control"
                    value="{{ old(
                        'end_datetime',
                        optional($event->end_datetime)->format('Y-m-d\TH:i')
                    ) }}"
                >
            </div>

        </div>

        <br>

        <div class="form-group">
            <label>Status</label>

            <select name="status" class="form-control">

                <option
                    value="scheduled"
                    {{ old('status', $event->status) == 'scheduled' ? 'selected' : '' }}
                >
                    Agendado
                </option>

                <option
                    value="active"
                    {{ old('status', $event->status) == 'active' ? 'selected' : '' }}
                >
                    Ativo
                </option>

                <option
                    value="finished"
                    {{ old('status', $event->status) == 'finished' ? 'selected' : '' }}
                >
                    Finalizado
                </option>

                <option
                    value="cancelled"
                    {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}
                >
                    Cancelado
                </option>

            </select>
        </div>

        <br>

        <button class="btn btn-primary">
            Atualizar
        </button>

    </form>

</div>

@endsection