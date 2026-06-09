<?php

namespace App\Domains\Attendance\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendancePresence\Models\AttendancePresence;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with([
            'project',
            'classroomEvent.classroom',
        ])
        ->latest()
        ->paginate(10);

        return view(
            'attendances.index',
            compact('attendances')
        );
    }

    public function show(Attendance $attendance)
    {
        $attendance->load([
            'project.participants.user',
            'presences.participant.user',
        ]);

        $participants = $attendance->project?->participants ?? collect();

        foreach ($participants as $participant) {

            AttendancePresence::firstOrCreate([
                'attendance_id'  => $attendance->id,
                'participant_id' => $participant->id,
            ]);

        }

        $attendance->load([
            'project.participants.user',
            'presences.participant.user',
        ]);

        return view(
            'attendances.show',
            compact('attendance')
        );
    }

    public function update(Attendance $attendance)
    {
        foreach (request('presences', []) as $participantId => $data) {

            $presence = AttendancePresence::where(
                'attendance_id',
                $attendance->id
            )
            ->where(
                'participant_id',
                $participantId
            )
            ->first();

            if (!$presence) {
                continue;
            }

            $presence->update([
                'present' => isset($data['present']),
                'observation' => $data['observation'] ?? null,
            ]);
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Chamada salva com sucesso!'
            );
    }
}