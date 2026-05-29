<?php

namespace App\Domains\Calendar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $timezone = 'America/Sao_Paulo';

        // Get month and year from request or use current
        $now = Carbon::now($timezone);
        $month = $request->get('month', $now->month);
        $year = $request->get('year', $now->year);

        // Validate month and year
        $month = max(1, min(12, (int)$month));
        $year = max(2000, min(2100, (int)$year));

        // Create date objects in Brazil timezone
        $currentDate = Carbon::createFromDate($year, $month, 1, $timezone);
        $daysInMonth = $currentDate->daysInMonth;
        $startingDayOfWeek = $currentDate->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

        // Build calendar data structure
        $calendarDays = [];
        
        // Fill empty days at the beginning
        for ($i = 0; $i < $startingDayOfWeek; $i++) {
            $calendarDays[] = null;
        }
        
        // Fill days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $calendarDays[$day - 1 + $startingDayOfWeek] = [
                'day' => $day,
                'date' => Carbon::createFromDate($year, $month, $day, $timezone),
                'events' => [],
                'classrooms' => [],
            ];
        }

        // Fetch events for this month
        $events = DB::table('events')
            ->whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month)
            ->where('status', '!=', 'cancelled')
            ->orderBy('start_datetime')
            ->get();

        // Map events to calendar days
        foreach ($events as $event) {
            $eventDate = Carbon::parse($event->start_datetime, $timezone)->setTimezone($timezone);
            $dayIndex = $eventDate->day - 1 + $startingDayOfWeek;
            
            if (isset($calendarDays[$dayIndex]) && $calendarDays[$dayIndex] !== null) {
                $calendarDays[$dayIndex]['events'][] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'start_time' => $eventDate->format('H:i'),
                    'status' => $event->status,
                ];
            }
        }

        // Fetch all classrooms and map to calendar days
        $classrooms = DB::table('classrooms')->get();
        $weekdayMap = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
        ];

foreach ($classrooms as $classroom) {

    $weekdays = $classroom->weekdays;

    // Caso venha JSON string
    if (is_string($weekdays)) {
        $weekdays = json_decode($weekdays, true);
    }

    // Garante array
    $weekdays = is_array($weekdays)
        ? $weekdays
        : [];

    $mappedWeekdays = collect($weekdays)
        ->map(function ($weekday) use ($weekdayMap) {
            return $weekdayMap[$weekday] ?? null;
        })
        ->filter()
        ->values()
        ->toArray();

    // Find all days with matching weekday in this month
    for ($day = 1; $day <= $daysInMonth; $day++) {

        $dateObj = Carbon::createFromDate(
            $year,
            $month,
            $day,
            $timezone
        );

        if (
            in_array(
                $dateObj->dayOfWeek,
                $mappedWeekdays
            )
        ) {

            $dayIndex =
                $day - 1 + $startingDayOfWeek;

            if (
                isset($calendarDays[$dayIndex])
                && $calendarDays[$dayIndex] !== null
            ) {

                $calendarDays[$dayIndex]['classrooms'][] = [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'start_time' => substr(
                        $classroom->starts_on,
                        0,
                        5
                    ),
                    'end_time' => substr(
                        $classroom->ends_on,
                        0,
                        5
                    ),
                ];
            }
        }
    }
}

        // Calculate previous and next months
        $prevDate = $currentDate->copy()->subMonth();
        $nextDate = $currentDate->copy()->addMonth();

        // Day names for header
        $dayNames = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        $todayDate = Carbon::now($timezone)->startOfDay();

        return view('calendar.index', [
            'calendarDays' => $calendarDays,
            'dayNames' => $dayNames,
            'currentDate' => $currentDate,
            'currentMonth' => $month,
            'currentYear' => $year,
            'prevMonth' => $prevDate->month,
            'prevYear' => $prevDate->year,
            'nextMonth' => $nextDate->month,
            'nextYear' => $nextDate->year,
            'monthName' => $currentDate->locale('pt_BR')->monthName,
            'timezone' => $timezone,
            'todayDate' => $todayDate,
        ]);
    }
}
