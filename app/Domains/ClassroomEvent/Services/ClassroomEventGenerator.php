<?php

namespace App\Domains\ClassroomEvent\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Domains\Classroom\Models\Classroom;

use App\Domains\ClassroomEvent\Models\ClassroomEvent;

use App\Domains\Attendance\Models\Attendance;

class ClassroomEventGenerator{
    public function generate(Classroom $classroom): void{

        $classroom->events()->delete();

        $period = CarbonPeriod::create(
            $classroom->starts_on,
            $classroom->ends_on
        );

        foreach ($period as $date) {

            $currentDay = strtolower($date->englishDayOfWeek);

            if (!in_array($currentDay, $classroom->weekdays ?? [])) {
                continue;
            }

            $start = Carbon::parse(
                $date->format('Y-m-d') . ' ' . $classroom->start_time
            );

            $end = Carbon::parse(
                $date->format('Y-m-d') . ' ' . $classroom->end_time
            );

            $event = ClassroomEvent::create([
                'classroom_id' => $classroom->id,
                'starts_at' => $start,
                'ends_at' => $end,
                'status' => 'scheduled',
            ]);

            Attendance::create([
                'classroom_event_id' => $event->id,
                'project_id' => $classroom->project_id,
                'date' => $start,
                'name' => $classroom->name . ' - ' . $start->format('d/m/Y'),
            ]);
        }
    }
}