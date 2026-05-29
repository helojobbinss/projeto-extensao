<?php

namespace App\Domains\Attendance\Services;

use Illuminate\Support\Facades\DB;

use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendancePresence\Models\AttendancePresence;

class AttendanceService
{
    public function create(array $data): Attendance
    {
        return DB::transaction(function () use ($data) {
            $attendance = Attendance::create([

                'classroom_event_id' =>
                    $data['classroom_event_id'] ?? null,

                'project_id' =>
                    $data['project_id'] ?? null,

                'name' =>
                    $data['name'] ?? 'Chamada',

                'date' =>
                    $data['date'] ?? now(),
            ]);

            return $attendance->fresh();
        });
    }

    public function update(Attendance $attendance,array $data): Attendance {
        return DB::transaction(function () use ($attendance,$data) {

            foreach ($data['presences'] ?? []as $presenceId => $presenceData) {
                $presence =AttendancePresence::find($presenceId);

                if (!$presence) {
                    continue;
                }

                $presence->update([
                    'present' =>isset($presenceData['present']),
                ]);
            }

            return $attendance->fresh();
        });
    }

    public function delete(Attendance $attendance): bool {

        return DB::transaction(function () use ($attendance) {

            $attendance->presences()->delete();
            $attendance->delete();
            return true;
        });
    }
}