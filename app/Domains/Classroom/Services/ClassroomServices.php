<?php

namespace App\Domains\Classroom\Services;

use App\Domains\Classroom\Models\Classroom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClassroomServices
{
    public function create(array $data): Classroom
    {
        $data['start_at'] = $this->parseDate($data['start_at']);
        $data['end_at'] = $this->parseDate($data['end_at']);

        return DB::transaction(fn () => Classroom::create($data));
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        $data['start_at'] = $this->parseDate($data['start_at']);
        $data['end_at'] = $this->parseDate($data['end_at']);

        return DB::transaction(function () use ($classroom, $data) {
            $classroom->fill($data)->save();

            return $classroom->fresh();
        });
    }

    public function delete(Classroom $classroom): bool
    {
        return DB::transaction(function () use ($classroom) {
            $classroom->delete();

            return true;
        });
    }

    private function parseDate(string $date): string
    {
        return Carbon::createFromFormat(
            'Y-m-d\TH:i',
            $date
        )->format('Y-m-d H:i:s');
    }
}