@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h2>Relatório da Chamada</h2>
        <div class="subtitle">
            {{ $attendance->classroomEvent->classroom->name ?? 'Classe' }}
            —
            {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y H:i') }}
        </div>
    </div>
    <div>
        <a href="{{ route('attendances') }}" class="btn btn-secondary btn-sm">
            ← Voltar
        </a>
    </div>
</div>

{{-- Mensagem de sucesso --}}
@if(session('success'))
    <div style="
        background: #d1fae5;
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    ">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Resumo da chamada --}}
<div class="card-box" style="margin-bottom: 24px;">
    <h3 style="margin-bottom: 16px; font-size: 1rem; color: #374151;">
        Resumo da Chamada
    </h3>

    @php
        $presentCount = $attendance->presences->where('present', true)->count();
        $absentCount = $attendance->presences->where('present', false)->count();
    @endphp

    <div style="display: flex; gap: 24px; flex-wrap: wrap;">

        <div style="
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 16px 24px;
            text-align: center;
            min-width: 120px;
        ">
            <div style="font-size: 2rem; font-weight: 700; color: #16a34a;">
                {{ $presentCount }}
            </div>
            <div style="font-size: 0.85rem; color: #6b7280;">Presentes</div>
        </div>

        <div style="
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 16px 24px;
            text-align: center;
            min-width: 120px;
        ">
            <div style="font-size: 2rem; font-weight: 700; color: #dc2626;">
                {{ $absentCount }}
            </div>
            <div style="font-size: 0.85rem; color: #6b7280;">Ausentes</div>
        </div>

        <div style="
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px 24px;
            text-align: center;
            min-width: 120px;
        ">
            <div style="font-size: 2rem; font-weight: 700; color: #374151;">
                {{ $presentCount + $absentCount }}
            </div>
            <div style="font-size: 0.85rem; color: #6b7280;">Total</div>
        </div>

        <div style="flex: 1; min-width: 200px;">
            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 4px;">
                Projeto
            </div>
            <div style="font-weight: 600; color: #374151;">
                {{ $attendance->classroomEvent->classroom->project->name ?? '—' }}
            </div>

            <div style="font-size: 0.85rem; color: #6b7280; margin-top: 10px; margin-bottom: 4px;">
                Evento
            </div>
            <div style="font-weight: 600; color: #374151;">
                {{ $attendance->classroomEvent->name ?? $attendance->name ?? '—' }}
            </div>
        </div>

    </div>
</div>

{{-- Formulário do relatório --}}
<div class="card-box">
    <h3 style="margin-bottom: 20px; font-size: 1rem; color: #374151;">
        Preencher Relatório
    </h3>

    <form action="{{ route('attendances.report.update', $attendance->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600;">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $report?->title) }}">
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600;">Descrição Geral</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $report?->description) }}</textarea>
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600;">Atividades</label>
            <textarea name="activities" rows="4" class="form-control">{{ old('activities', $report?->activities) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600;">Observações</label>
            <textarea name="observations" rows="3" class="form-control">{{ old('observations', $report?->observations) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label>Adicionar Fotos</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                Salvar Relatório
            </button>
        </div>

    </form>
</div>

{{-- Galeria --}}
@if($report?->images->isNotEmpty())
<div class="card-box" style="margin-top: 24px;">
    <h3>Fotos ({{ $report->images->count() }})</h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
        @foreach($report->images as $image)
            <div>
                <img src="{{ Storage::url($image->path) }}" style="width:100%; height:160px; object-fit:cover;">
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- Lista de presença --}}
@if($attendance->presences->isNotEmpty())
<div class="card-box" style="margin-top: 24px;">
    <h3>Lista de Presença</h3>

    <table style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Participante</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance->presences as $index => $presence)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $presence->participant->user->name ?? '—' }}</td>
                    <td>
                        @if($presence->present)
                            Presente
                        @else
                            Ausente
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection