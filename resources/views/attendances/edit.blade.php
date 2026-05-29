@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Editar Chamada</h2>
        <div class="subtitle">Atualize as presenças e faltas dos participantes</div>
    </div>
</div>

<div class="card-box">
    <form method="POST" action="{{ route('attendances.update', $attendance->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label><strong>Data da Chamada:</strong></label>
            <input type="date" name="date" class="form-control" value="{{ $attendance->date }}" required style="max-width: 200px;">
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #f3f4f6; border-bottom: 2px solid #ddd;">
                    <th style="padding: 12px 8px;">#</th>
                    <th style="padding: 12px 8px;">Nome do participante</th>
                    <th style="padding: 12px 8px; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $participant)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px 8px;">{{ $index + 1 }}</td>
                        <td style="padding: 12px 8px;">{{ $participant->name }}</td>
                        <td style="padding: 12px 8px; text-align: center;">
                            
                            @php
                                $currentStatus = $attendance->records->where('participant_id', $participant->id)->first()->status ?? '';
                            @endphp

                            <input type="hidden" name="attendances[{{ $participant->id }}][participant_id]" value="{{ $participant->id }}">

                            <label style="margin-right: 15px; cursor: pointer;">
                                <input type="radio" name="attendances[{{ $participant->id }}][status]" value="presente" required
                                    {{ $currentStatus === 'presente' ? 'checked' : '' }}>
                                Presente
                            </label>

                            <label style="cursor: pointer;">
                                <input type="radio" name="attendances[{{ $participant->id }}][status]" value="falta" required
                                    {{ $currentStatus === 'falta' ? 'checked' : '' }}>
                                Falta
                            </label>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Atualizar Chamada</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection