@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Criar Sala de Aula</h2>

    <form method="POST" action="{{ route('classrooms.store') }}">
        @csrf

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Dia da Semana</label>
            <input type="text" name="weekday" class="form-control" required>
        </div>

        <div class="row">
            <div class="col">
                <label>Início</label>
                <input type="datetime-local" name="start_at" class="form-control" required>
            </div>

            <div class="col">
                <label>Fim</label>
                <input type="datetime-local" name="end_at" class="form-control" required>
            </div>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Salvar Sala de Aula
        </button>

    </form>

</div>

@endsection
