<?php

namespace App\Domains\Attendance\Controllers;

use App\Domains\Attendance\Models\Attendance;
use App\Domains\Attendance\Services\AttendanceService;
use App\Domains\Attendance\Requests\AttendanceRequest;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('participant')
            ->latest()
            ->paginate(9);

        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $admins = User::where('role', 'admin')->get();

        return view('attendances.create', compact('admins'));
    }
    public function store(AttendanceRequest $request, AttendanceService $service)
    {
        $service->create($request->validated());

        return redirect()
            ->route('attendances')
            ->with('success', 'Chamada registrada com sucesso!');
    }   
    public function edit(Attendance $attendance)
    {
        $admins = User::where('role', 'admin')->get();

        return view('attendances.edit', compact('attendance', 'admins'));
    }

    public function update(AttendanceRequest $request, Attendance $attendance, AttendanceService $service)
    {
        $service->update($attendance, $request->validated());

        return redirect()
            ->route('attendances')
            ->with('success', 'Chamada atualizada com sucesso!');
    }

    public function destroy(Attendance $attendance, AttendanceService $service)
    {
        $service->delete($attendance);

        return redirect()
            ->route('attendances')
            ->with('success', 'Chamada deletada com sucesso!');
    }
}