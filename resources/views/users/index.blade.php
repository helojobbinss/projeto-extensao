@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Usuários</h2>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Novo Usuário
        </a>
    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <table class="table">

                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Permissão</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            {{-- ROLE --}}
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'volunteer')
                                    <span class="badge bg-primary">Voluntário</span>
                                @else
                                    <span class="badge bg-secondary">Participante</span>
                                @endif
                            </td>

                            {{-- DATA --}}
                            <td>
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            {{-- AÇÕES --}}
                            <td>

                                {{-- EDIT --}}
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                        Excluir
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Nenhum usuário encontrado
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection