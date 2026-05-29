@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h2>Chamadas</h2>

        <div class="subtitle">
            Chamadas das classes agendadas para hoje
        </div>
    </div>
</div>

<div class="card-box">

    <div style="margin-bottom: 20px;">
        <input
            type="text"
            class="form-control"
            placeholder="Buscar projeto, evento ou classe..."
            style="width: 100%; max-width: 400px;"
        >
    </div>

    <table
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
                    Horário
                </th>

                <th style="padding: 12px 8px;">
                    Projeto
                </th>

                <th style="padding: 12px 8px;">
                    Evento
                </th>

                <th style="padding: 12px 8px;">
                    Classe
                </th>

                <th style="padding: 12px 8px;">
                    Responsável
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

            @forelse($attendances as $index => $attendance)

                <tr
                    style="
                        border-bottom: 1px solid #eee;
                    "
                >

                    <td style="padding: 12px 8px;">
                        {{ $index + 1 }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{ \Carbon\Carbon::parse($attendance->date)->format('H:i') }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $attendance->project
                                ->name
                                ?? 'Sem projeto'
                        }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $attendance->class
                                ->event
                                ->name
                                ?? 'Sem evento'
                        }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $attendance->class
                                ->name
                                ?? 'Sem classe'
                        }}
                    </td>

                    <td style="padding: 12px 8px;">
                        {{
                            $attendance->project->coordinator
                                ->name
                            ?? 'Não informado'
                        }}
                    </td>

                    <td
                        style="
                            padding: 12px 8px;
                            text-align: center;
                        "
                    >

                        <a
                                href="{{route('attendance-presences.edit',$attendance->id)}}"
                            class="btn btn-sm btn-primary"
                        >
                            Abrir
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        style="
                            padding: 20px;
                            text-align: center;
                            color: #888;
                        "
                    >

                        Nenhuma chamada encontrada.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection