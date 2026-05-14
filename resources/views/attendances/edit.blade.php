@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Chamadas</h2>
        <div class="subtitle">Lista de Chamadas</div>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('attendances.create') }}" class="btn btn-primary">NOVO PARTICIPANTE</a>
    @endif
</div>

<div class="card-box">

    <form method="GET" action="{{ route('attendances') }}" class="toolbar">
        <input type="text" name="search" value="{{ request('search') }}"
               class="input" placeholder="Buscar ...">
        <select name="status" class="select" onchange="this.form.submit()">
            <option value="">▽</option>
            <option value="approved" @selected(request('status')=='approved')>Aprovado</option>
            <option value="pending"  @selected(request('status')=='pending')>Pendente</option>
            <option value="rejected" @selected(request('status')=='rejected')>Rejeitado</option>
        </select>
    </form>

    <table class="data-table">
        <thead>
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
                <td class="cell-link">{{ $p->user->name }}</td>
                <td class="cell-link">{{ $p->project->name }}</td>
                <td>{{ optional($p->user->birthday)->format('d/m/Y') }}</td>
                <td>{{ $p->user->age ?? '-' }}</td>
                <td>{{ $p->user->phone }}</td>
                <td class="cell-link">{{ $p->user->email }}</td>
                <td>
                    @if($p->status === 'approved')
                        <span class="status-icon approved">✔</span>
                    @elseif($p->status === 'pending')
                        <span class="status-icon pending">⏳</span>
                    @else
                        <span class="status-icon rejected">✖</span>
                    @endif
                </td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('attendances.edit', $p->id) }}" class="btn btn-outline btn-icon">✏</a>
                        <form method="POST" action="{{ route('attendances.destroy', $p->id) }}"
                              onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-icon">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center; padding:24px; color:var(--muted)">Nenhum attendancee.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="table-footer">
        <span>Mostrando {{ $attendances->count() }} de {{ $attendances->total() ?? $attendances->count() }} registros</span>
        <div class="pager">{{ $attendances->links() }}</div>
    </div>
</div>
@endsection
