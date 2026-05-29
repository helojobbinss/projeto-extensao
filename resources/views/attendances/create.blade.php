@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Chamada</h2>
        <div class="subtitle">Registro de Presença de participantes</div>
    </div>
</div>

<div class="card-box">
    <form method="POST" action="{{ route('attendances.store') }}">
        @csrf

        {{-- Campos básicos da chamada --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px;">Descrição:</label>
            <input type="text" name="description" class="form-control" placeholder="Ex: Aula de Reforço" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px;">Data:</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px;">
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
                        <label style="margin-right: 15px; cursor: pointer;">
                            <input type="radio" name="attendances[{{ $participant->id }}][status]" value="presente" required>
                            Presente
                        </label>
                        
                        <label style="cursor: pointer;">
                            <input type="radio" name="attendances[{{ $participant->id }}][status]" value="falta" required>
                            Falta
                        </label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-actions" style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('attendances') }}" class="btn btn-ghost">CANCELAR</a>
            <button type="submit" class="btn btn-primary">SALVAR</button>
        </div>
    </form>
</div>
@endsection
