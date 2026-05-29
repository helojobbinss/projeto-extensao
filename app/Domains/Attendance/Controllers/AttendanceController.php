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
            'classroomEvent.classroom',
        ])
            ->latest()
            ->paginate(10);

        return view(
            'attendances.index',
            compact('attendances')
        );
    }

    public function show(Attendance $attendance) {
        $attendance->load([
            'classroomEvent.classroom.project.participants',
            'presences.participant',
        ]);

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
        $attendance->load(
            'presences.participant'
        );

        return view(
            'attendances.show',
            compact('attendance')
        );
    }

    public function update(Attendance $attendance) {
        foreach (request('presences', []) as $presenceId => $data) {
            $presence =AttendancePresence::find($presenceId);

            if (!$presence) {
                continue;
            }

            $presence->update([
                'present' =>isset($data['present']),]);
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Chamada salva com sucesso!'
            );
    }
}