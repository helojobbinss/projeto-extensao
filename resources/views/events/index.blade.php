@extends('layouts.app')

@section('content')

<div class="container">

    <div class="header">

        <h3>Conheça nossos Eventos</h3>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('events.create') }}" class="btn-new">
                + Novo Evento
            </a>
        @endif

    </div>

    <div class="events-list">

        @foreach($events as $event)

            <div
                class="event-pill {{ $loop->first ? 'active' : '' }}"
                onclick="selectEvent({{ $event->id }}, this)"
            >

                <div class="pill-title">
                    {{ $event->name }}
                </div>

                <div class="pill-description">
                    {{ \Illuminate\Support\Str::limit($event->description, 80) }}
                </div>

            </div>

        @endforeach

    </div>

    <div
        class="event-details"
        id="event-details"
    ></div>

</div>

@endsection

@section('scripts')

@php

    $eventsJson = $events->map(function ($event) {

        return [

            'id' => $event->id,

            'name' => $event->name,

            'description' => $event->description,

            'status' => $event->status,

            'start_datetime' => optional($event->start_datetime)
                ->format('Y-m-d H:i:s'),

            'end_datetime' => optional($event->end_datetime)
                ->format('Y-m-d H:i:s'),

            'project' => $event->project ? [

                'id' => $event->project->id,

                'name' => $event->project->name,

            ] : null,

            'classroom' => $event->classroom ? [

                'id' => $event->classroom->id,

                'name' => $event->classroom->name,

            ] : null,
        ];
    })->values();

@endphp

<script>

const events = @json($eventsJson);


// ===== EVENT SELECT =====

window.selectEvent = function (id, el) {

    const event = events.find(e => e.id == id);

    if (!event) {
        console.error('Evento não encontrado');
        return;
    }

    document.querySelectorAll('.event-pill').forEach(item => {
        item.classList.remove('active');
    });

    el.classList.add('active');

    const container = document.getElementById('event-details');

    container.classList.remove('show');

    setTimeout(() => {

        container.innerHTML = `

            <div class="header">

                <div class="header-left">

                    <div class="icon">
                        📅
                    </div>

                    <div>

                        <h5>
                            ${event.name}
                        </h5>

                        <small>
                            ${event.description ?? 'Sem descrição'}
                        </small>

                    </div>

                </div>

                ${renderAdminActions(event)}

            </div>

            <div class="event-grid">

                <div>

                    <span>
                        📁 Projeto
                    </span>

                    <strong>
                        ${event.project?.name ?? '-'}
                    </strong>

                </div>

                <div>

                    <span>
                        🏫 Sala
                    </span>

                    <strong>
                        ${event.classroom?.name ?? 'Sem sala'}
                    </strong>

                </div>

                <div>

                    <span>
                        📅 Início
                    </span>

                    <strong>
                        ${formatDateTime(event.start_datetime)}
                    </strong>

                </div>

                <div>

                    <span>
                        ⏰ Fim
                    </span>

                    <strong>
                        ${formatDateTime(event.end_datetime)}
                    </strong>

                </div>

                <div>

                    <span>
                        Status
                    </span>

                    ${renderStatus(event.status)}

                </div>

            </div>
        `;

        container.classList.add('show');

    }, 120);
};


// ===== HELPERS =====

function formatDateTime(date) {

    if (!date) {
        return '-';
    }

    const d = new Date(date);

    return d.toLocaleString('pt-BR');
}

function renderStatus(status) {

    if (status === 'scheduled') {
        return '<span class="badge bg-primary">Agendado</span>';
    }

    if (status === 'active') {
        return '<span class="badge bg-success">Ativo</span>';
    }

    if (status === 'finished') {
        return '<span class="badge bg-dark">Finalizado</span>';
    }

    if (status === 'cancelled') {
        return '<span class="badge bg-danger">Cancelado</span>';
    }

    return '<span class="badge bg-secondary">-</span>';
}

function renderAdminActions(event) {

    @if(auth()->user()->isAdmin())

        return `

            <div class="actions">

                <a
                    href="/events/${event.id}/edit"
                    class="btn-edit"
                >
                    <i class="fa-solid fa-pen"></i>
                </a>

                <form
                    method="POST"
                    action="/events/${event.id}"
                    onsubmit="return confirm('Deseja excluir este evento?')"
                >

                    <input
                        type="hidden"
                        name="_token"
                        value="{{ csrf_token() }}"
                    >

                    <input
                        type="hidden"
                        name="_method"
                        value="DELETE"
                    >

                    <button
                        type="submit"
                        class="btn-danger"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </form>

            </div>
        `;

    @else

        return '';

    @endif
}


// ===== INIT =====

window.addEventListener('DOMContentLoaded', () => {

    if (events.length) {

        const first = document.querySelector('.event-pill');

        selectEvent(events[0].id, first);
    }
});

</script>

@endsection