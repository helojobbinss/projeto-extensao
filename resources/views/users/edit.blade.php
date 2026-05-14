@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Usuário</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label>Nova Senha (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Tipo de Usuário</label>
            <select name="role" class="form-control">
                <option value="participant" {{ $user->role == 'participant' ? 'selected' : '' }}>Participante</option>
                <option value="volunteer" {{ $user->role == 'volunteer' ? 'selected' : '' }}>Voluntário</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <br>

        <button class="btn btn-primary">Atualizar</button>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Voltar
        </a>

    </form>

</div>

@endsection