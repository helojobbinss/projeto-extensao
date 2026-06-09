@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div
            class="card-header d-flex justify-content-between align-items-center"
        >

            <div>

                <h4 class="mb-0">
                    Lista de Presença
                </h4>

                <small class="text-muted">

                    {{ $attendance->name ?? 'Chamada' }}

                </small>

            </div>

            <div>

                <span class="badge bg-primary">

                    {{ $attendance->date?->format('d/m/Y H:i') }}

                </span>

            </div>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <form
                action="{{ route('attendance-presences.update', $attendance->id) }}"
                method="POST"
            >

                @csrf

                <div class="table-responsive">

                    <table
                        class="table table-bordered align-middle"
                    >

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    Participante
                                </th>

                                <th
                                    width="140"
                                    class="text-center"
                                >
                                    Presente
                                </th>

                                <th>
                                    Observação
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse(
                                $attendance->project?->participants ?? collect()
                                as $index => $participant
                            )

                                @php

                                    $presence = $attendance
                                        ->presences
                                        ->firstWhere(
                                            'participant_id',
                                            $participant->id
                                        );

                                @endphp

                                <tr>

                                    <td>

                                        {{ $index + 1 }}

                                    </td>

                                    <td>

                                        <strong>

                                            {{
                                                $participant->user?->name
                                                ?? 'Sem nome'
                                            }}

                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        <input
                                            type="checkbox"
                                            name="presences[{{ $participant->id }}][present]"
                                            value="1"

                                            {{
                                                $presence &&
                                                $presence->present
                                                    ? 'checked'
                                                    : ''
                                            }}
                                        >

                                    </td>

                                    <td>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="presences[{{ $participant->id }}][observation]"
                                            value="{{
                                                $presence->observation
                                                ?? ''
                                            }}"
                                            placeholder="Observação"
                                        >

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-4"
                                    >

                                        Nenhum participante encontrado para este projeto.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div
                    class="d-flex justify-content-end mt-3"
                >

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        Salvar Presenças

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection