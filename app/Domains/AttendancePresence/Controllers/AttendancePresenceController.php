<?php

namespace App\Domains\AttendancePresence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendancePresence\Models\AttendancePresence;

class AttendancePresenceController extends Controller
{
    public function edit($attendanceId)
    {
        $attendance = Attendance::with([
            'project.participants.user',
            'presences'
        ])->findOrFail($attendanceId);

        return view(
            'attendance-presences.edit',
            compact('attendance')
        );
    }

    public function update(Request $request, $attendanceId)
    {
        $attendance = Attendance::with([
            'project.participants'
        ])->findOrFail($attendanceId);

        $presences = $request->input(
            'presences',
            []
        );

        foreach (
            $attendance->project?->participants ?? collect()
            as $participant
        ) {

            $data = $presences[$participant->id] ?? [];

            AttendancePresence::updateOrCreate(
                [
                    'attendance_id' => $attendance->id,
                    'participant_id' => $participant->id,
                ],
                [
                    'present' => isset($data['present']),
                    'observation' => $data['observation'] ?? null,
                ]
            );
        }

        return redirect()
            ->route(
                'attendances.report.edit',
                $attendance->id
            )
            ->with(
                'success',
                'Presenças salvas com sucesso.'
            );
    }
}