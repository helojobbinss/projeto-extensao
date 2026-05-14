@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="header">
            <h3>Chamada</h3>

        </div>

        <form method="GET" action="{{ route('attendances') }}" class="mb-3">

            <div class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control search-input"
                    placeholder="Buscar...">

                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

        </form>


        {{-- TABELA --}}
        <div class="card shadow-sm">

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Projetos</th>
                            <th>Data Nascimento</th>
                            <th>Idade</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($attendances as $p)

                            <tr>
                                <td>{{ $p->user->name }}</td>
                                <td>{{ $p->project->name }}</td>
                                <td>{{ optional($p->user->birthday)->format('d/m/Y') }}</td>
                                <td>{{ $p->user->age ?? '-' }}</td>
                                <td>{{ $p->user->phone }}</td>
                                <td>{{ $p->user->email }}</td>

                                <td>
                                    @if($p->status === 'approved')
                                        <span class="status approved">✔</span>
                                    @elseif($p->status === 'pending')
                                        <span class="status pending">⏳</span>
                                    @else
                                        <span class="status rejected">✖</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="actions">
                                        <a href="{{ route('attendances.edit', $p->id) }}" class="btn btn-primary">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('attendances.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-3">
                                    Nenhum chamada encontrado
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

        {{-- FOOTER --}}
        <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
            <span>Mostrando {{ $attendances->count() }} chamadas</span>

            <div>
                {{ $attendances->links() }}
            </div>
        </div>
    </div>

@endsection