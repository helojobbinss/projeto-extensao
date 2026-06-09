@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <h2>Possíveis Voluntários</h2>

        <div class="subtitle">
            Solicitações recebidas através do formulário do site
        </div>

    </div>

</div>

<div class="card-box">

    <div style="margin-bottom: 20px;">

        <input
            type="text"
            class="form-control"
            placeholder="Buscar por nome ou e-mail..."
            style="width: 100%; max-width: 400px;"
            id="searchInput"
        >

    </div>

    @if(session('success'))

        <div
            style="
                background: #d1fae5;
                color: #065f46;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 20px;
            "
        >
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div
            style="
                background: #fee2e2;
                color: #991b1b;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 20px;
            "
        >
            {{ session('error') }}
        </div>

    @endif

    <table
        id="volunteersTable"
        style="
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        "
    >

        <thead>

            <tr
                style="
                    background-color: #f3f4f6;
                    border-bottom: 2px solid #ddd;
                "
            >

                <th style="padding: 12px 8px;">#</th>

                <th style="padding: 12px 8px;">
                    Nome
                </th>

                <th style="padding: 12px 8px;">
                    E-mail
                </th>

                <th style="padding: 12px 8px;">
                    Data Nascimento
                </th>

                <th style="padding: 12px 8px;">
                    Telefone
                </th>

                <th style="padding: 12px 8px;">
                    Projeto
                </th>

                <th style="padding: 12px 8px;">
                    Data da Solicitação
                </th>

                <th
                    style="
                        padding: 12px 8px;
                        text-align: center;
                    "
                >
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($volunteers as $index => $volunteer)

                <tr
                    style="
                        border-bottom: 1px solid #eee;
                    "
                >

                    <td style="padding: 12px 8px;">
                        {{ $index + 1 }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{ $volunteer->name }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{ $volunteer->email }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            \Carbon\Carbon::parse(
                                $volunteer->birthdate
                            )->format('d/m/Y')
                        }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{ $volunteer->phone ?? '-' }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $volunteer->project->name
                            ?? 'Não informado'
                        }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $volunteer->created_at
                                ->format('d/m/Y H:i')
                        }}
                    </td>

                    <td
                        style="
                            padding: 12px 8px;
                            text-align: center;
                            display: flex;
                            gap: 8px;
                            justify-content: center;
                        "
                    >

                        <form
                            method="POST"
                            action="{{
                                route(
                                    'pending-volunteers.approve',
                                    $volunteer->id
                                )
                            }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success btn-sm"
                                onclick="return confirm(
                                    'Deseja aprovar este voluntário?'
                                )"
                            >
                                Aprovar
                            </button>

                        </form>

                        <form
                            method="POST"
                            action="{{
                                route(
                                    'pending-volunteers.reject',
                                    $volunteer->id
                                )
                            }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm(
                                    'Deseja rejeitar esta solicitação?'
                                )"
                            >
                                Rejeitar
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="8"
                        style="
                            padding: 20px;
                            text-align: center;
                            color: #888;
                        "
                    >

                        Nenhuma solicitação pendente encontrada.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<script>

document
    .getElementById('searchInput')
    .addEventListener('keyup', function() {

        let value = this.value.toLowerCase();

        let rows = document.querySelectorAll(
            '#volunteersTable tbody tr'
        );

        rows.forEach(row => {

            row.style.display =
                row.innerText
                    .toLowerCase()
                    .includes(value)
                    ? ''
                    : 'none';

        });

    });

</script>

@endsection