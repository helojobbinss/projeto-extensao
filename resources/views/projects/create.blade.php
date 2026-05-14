@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Criar Projeto</h2>

    <form method="POST" action="{{ route('projects.store') }}">
        @csrf

        {{-- Nome --}}
        <div class="form-group">
            <label>Nome do Projeto</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Coordenador (admin) --}}
        <div class="form-group">
            <label>Coordenador do Projeto</label>
            <select name="coordinator_id" class="form-control" required>
                <option value="">Selecione um administrador</option>

                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">
                        {{ $admin->name }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- Descrição --}}
        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        {{-- Local --}}
        <div class="form-group">
            <label>Local</label>
            <input type="text" name="location" class="form-control">
        </div>

        {{-- Público alvo --}}
        <div class="form-group">
            <label>Público Alvo</label>
            <input type="text" name="target_audience" class="form-control">
        </div>

        <div class="row">

            {{-- Início --}}
            <div class="col">
                <label>Início</label>
                <input type="date" name="start_date" class="form-control">
            </div>

            {{-- Fim --}}
            <div class="col">
                <label>Fim</label>
                <input type="date" name="end_date" class="form-control">
            </div>

        </div>

        {{-- Vagas --}}
        <div class="form-group">
            <label>Vagas Disponíveis</label>
            <input type="number" name="vacancies" class="form-control">
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">Ativo</option>
                <option value="inactive">Inativo</option>
                <option value="finished">Finalizado</option>
            </select>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Salvar Projeto
        </button>

    </form>

</div>

@endsection