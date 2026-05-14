<?php

namespace App\Domains\Attendance\Services;

use App\Domains\Attendance\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function create(array $data): Attendance
    {
        return DB::transaction(
            fn () => Attendance::create($data)
        );
    }

    public function update(Attendance $attendance, array $data): Attendance
    {
        return DB::transaction(function () use ($attendance, $data) {

            $attendance->fill($data)->save();

            return $attendance->fresh();
        });
    }

    public function delete(Attendance $attendance): bool
    {
        return DB::transaction(function () use ($attendance) {

            $attendance->delete();

            return true;
        });
    }
}