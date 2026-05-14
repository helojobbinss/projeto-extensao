@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Sala de Aula</h2>

    <form method="POST" action="{{ route('classrooms.update', $classroom->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nome da Sala</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $classroom->name }}" required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" rows="4">{{ $classroom->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Dia da Semana</label>
            <input type="text" name="weekday" class="form-control"
                   value="{{ $classroom->weekday }}" required>
        </div>

        <div class="row">
            <div class="col">
                <label>Início</label>
                <input type="datetime-local" name="start_at" class="form-control"
                       value="{{ optional($classroom->start_at) ? date('Y-m-d\TH:i', strtotime($classroom->start_at)) : '' }}" required>
            </div>

            <div class="col">
                <label>Fim</label>
                <input type="datetime-local" name="end_at" class="form-control"
                       value="{{ optional($classroom->end_at) ? date('Y-m-d\TH:i', strtotime($classroom->end_at)) : '' }}" required>
            </div>
        </div>

        <br>

        <button class="btn btn-primary">
            Atualizar Sala de Aula
        </button>

    </form>

</div>

@endsection
