@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h2>Voluntários</h2>

            <div class="subtitle">
                Lista de Voluntários
            </div>
        </div>

        @if(auth()->user()?->isAdmin())

            <a href="{{ route('volunteers.create') }}"
               class="btn btn-primary">

                NOVO PARTICIPANTE

            </a>

        @endif

    </div>

    {{-- CARD --}}
    <div class="card-box">

        {{-- BUSCA --}}
        <form method="GET"
              action="{{ route('volunteers') }}"
              class="toolbar">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="input"
                   placeholder="Buscar ...">

            <select name="status"
                    class="select"
                    onchange="this.form.submit()">

                <option value="">▽</option>

                <option value="approved"
                    @selected(request('status') == 'approved')>

                    Aprovado

                </option>

                <option value="pending"
                    @selected(request('status') == 'pending')>

                    Pendente

                </option>

                <option value="rejected"
                    @selected(request('status') == 'rejected')>

                    Rejeitado

                </option>

            </select>

        </form>

        {{-- TABELA --}}
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

                @forelse($volunteers as $p)

                    <tr>

                        {{-- NOME --}}
                        <td class="cell-link">
                            {{ $p->user?->name ?? '-' }}
                        </td>

                        {{-- PROJETO --}}
                        <td class="cell-link">
                            {{ $p->project?->name ?? '-' }}
                        </td>

                        {{-- DATA NASCIMENTO --}}
                        <td>
                            {{ optional($p->user?->birthday)->format('d/m/Y') ?? '-' }}
                        </td>

                        {{-- IDADE --}}
                        <td>
                            {{ $p->user?->age ?? '-' }}
                        </td>

                        {{-- TELEFONE --}}
                        <td>
                            {{ $p->user?->phone ?? '-' }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="cell-link">
                            {{ $p->user?->email ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if($p->status === 'approved')

                                <span class="status-icon approved">
                                    ✔
                                </span>

                            @elseif($p->status === 'pending')

                                <span class="status-icon pending">
                                    ⏳
                                </span>

                            @else

                                <span class="status-icon rejected">
                                    ✖
                                </span>

                            @endif

                        </td>

                        {{-- AÇÕES --}}
                        <td>

                            <div class="row-actions">

                                {{-- EDITAR --}}
                                <a href="{{ route('volunteers.edit', $p->id) }}"
                                   class="btn btn-outline btn-icon">

                                    ✏

                                </a>

                                {{-- DELETE PAGE --}}
                                <a href="{{ route('volunteers.delete', $p->id) }}"
                                   class="btn btn-danger btn-icon">

                                    🗑

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8"
                            style="text-align:center; padding:24px; color:var(--muted)">

                            Nenhum voluntário.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- FOOTER --}}
        <div class="table-footer">

            <span>

                Mostrando
                {{ $volunteers->count() }}
                de
                {{ $volunteers->total() ?? $volunteers->count() }}
                registros

            </span>

            <div class="pager">

                {{ $volunteers->links() }}

            </div>

        </div>

    </div>

</div>

@endsection