@extends('layouts.app')

@section('content')
<div class="card-box">
    <div class="page-header">
        <div>
            <h2>{{ $monthName }} {{ $currentYear }}</h2>
            <div class="subtitle">Calendário de aulas e eventos do mês</div>
        </div>

        <div class="actions">
            <a href="{{ route('calendar', ['month' => $prevMonth, 'year' => $prevYear]) }}" class="btn btn-outline">← Anterior</a>
            <a href="{{ route('calendar', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="btn btn-outline">Próximo →</a>
        </div>
    </div>

    <table class="calendar-table">
        <thead>
            <tr>
                @foreach ($dayNames as $dayName)
                    <th>{{ $dayName }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $cells = $calendarDays;
                $total = count($cells);
                $rows = (int)ceil($total / 7);
            @endphp

            @for ($r = 0; $r < $rows; $r++)
                <tr>
                    @for ($c = 0; $c < 7; $c++)
                        @php $i = $r * 7 + $c; @endphp
                        @if (isset($cells[$i]) && $cells[$i] !== null)
                            <td class="calendar-cell">
                                <div class="calendar-day-header">
                                    <span class="calendar-day-number {{ $cells[$i]['date']->isSameDay($todayDate) ? 'calendar-today' : '' }}">{{ $cells[$i]['day'] }}</span>
                                </div>

                                @foreach ($cells[$i]['events'] as $event)
                                    <div class="calendar-entry calendar-entry-event">
                                        <a href="{{ route('events.edit', $event['id']) }}">{{ $event['start_time'] }} - {{ $event['name'] }}</a>
                                    </div>
                                @endforeach

                                @foreach ($cells[$i]['classrooms'] as $classroom)
                                    <div class="calendar-entry calendar-entry-classroom">
                                        <a href="{{ route('classrooms.edit', $classroom['id']) }}">{{ $classroom['start_time'] }} - {{ $classroom['name'] }}</a>
                                    </div>
                                @endforeach

                                @if (empty($cells[$i]['events']) && empty($cells[$i]['classrooms']))
                                    <div class="calendar-empty">Sem eventos</div>
                                @endif
                            </td>
                        @else
                            <td class="calendar-cell empty"></td>
                        @endif
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="actions" style="margin-top: 18px;">
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ Novo Evento</a>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary">+ Nova Aula</a>
    </div>
</div>
@endsection
