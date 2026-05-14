@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Criar Usuário</h2>

        {{-- ALERTA DE ERRO --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            {{-- NOME --}}
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            {{-- SENHA --}}
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- ROLE --}}
            <div class="form-group">
                <label>Tipo de Usuário</label>
                <select name="role" class="form-control" required>
                    <option value="participant">Participante</option>
                    <option value="volunteer">Voluntário</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <br>

            <button type="submit" class="btn btn-primary">
                Criar Usuário
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Voltar
            </a>

        </form>

    </div>

@endsection