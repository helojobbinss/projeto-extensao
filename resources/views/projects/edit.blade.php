@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Projeto</h2>

    <form method="POST" action="{{ route('projects.update', $project->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $project->name }}">
        </div>

        <div class="form-group">
            <label>Coordenador</label>
            <select name="coordinator_id" class="form-control">

                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}"
                        {{ $project->coordinator_id == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control">
                {{ $project->description }}
            </textarea>
        </div>

        <div class="form-group">
            <label>Local</label>
            <input type="text" name="location" class="form-control"
                   value="{{ $project->location }}">
        </div>

        <div class="form-group">
            <label>Público</label>
            <input type="text" name="target_audience" class="form-control"
                   value="{{ $project->target_audience }}">
        </div>

        <div class="row">

            <div class="col">
                <label>Início</label>
                <input type="date" name="start_date" class="form-control"
                       value="{{ $project->start_date }}">
            </div>

            <div class="col">
                <label>Fim</label>
                <input type="date" name="end_date" class="form-control"
                       value="{{ $project->end_date }}">
            </div>

        </div>

        <div class="form-group">
            <label>Vagas</label>
            <input type="number" name="vacancies" class="form-control"
                   value="{{ $project->vacancies }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">

                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>
                    Ativo
                </option>

                <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>
                    Inativo
                </option>

                <option value="finished" {{ $project->status == 'finished' ? 'selected' : '' }}>
                    Finalizado
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