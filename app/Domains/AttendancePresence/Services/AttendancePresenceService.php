<?php

namespace App\Domains\AttendancePresence\Services;

use Illuminate\Support\Facades\DB;

use App\Domains\Attendance\Models\Attendance;

use App\Domains\AttendancePresence\Models\AttendancePresence;

class AttendancePresenceService
{

    public function generate(Attendance $attendance): void {
        $attendance->load(
            'classroomEvent.classroom.project.participants'
        );

        $participants =
            $attendance
                ->classroomEvent
                ->classroom
                ->project
                ->participants;

        foreach ($participants as $participant) {

            AttendancePresence::firstOrCreate([

                'attendance_id' => $attendance->id,

                'participant_id' => $participant->id,
            ]);
        }
    }

    public function update(AttendancePresence $attendancePresence, array $data ): AttendancePresence {

        return DB::transaction(function () use (
            $attendancePresence,
            $data
        ) {

            $attendancePresence->update([

                'present' =>
                    $data['present']
                    ?? false,

                'observation' =>
                    $data['observation']
                    ?? null,
            ]);

            return $attendancePresence->fresh();
        });
    }

    public function bulkUpdate(Attendance $attendance, array $data): void {
        foreach ($data['presences'] ?? [] as $presenceId => $presenceData) {

            $presence =
                AttendancePresence::find(
                    $presenceId
                );

            if (!$presence) {
                continue;
            }

            $presence->update([

                'present' =>
                    isset(
                        $presenceData['present']
                    ),

                'observation' =>
                    $presenceData['observation']
                    ?? null,
            ]);
        }
    }
}