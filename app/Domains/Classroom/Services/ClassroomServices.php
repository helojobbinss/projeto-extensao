<?php

namespace App\Domains\Classroom\Services;

use App\Domains\Classroom\Models\Classroom;

use App\Domains\ClassroomEvent\Services\ClassroomEventGenerator;

use Illuminate\Support\Facades\DB;

class ClassroomServices
{
    public function create(array $data): Classroom
    {
        return DB::transaction(function () use ($data) {
            $classroom = Classroom::create([

                'project_id' => $data['project_id'],

                'name' => $data['name'],

                'description' => $data['description'] ?? null,

                'weekdays' => $data['weekdays'],

                'starts_on' => $data['starts_on'],

                'ends_on' => $data['ends_on'],

                'start_time' => $data['start_time'],

                'end_time' => $data['end_time'],
            ]);
            app(ClassroomEventGenerator::class)
                ->generate($classroom);

            return $classroom->fresh();
        });
    }

    public function update(Classroom $classroom,array $data): Classroom {

        return DB::transaction(function () use (
            $classroom,
            $data
        ) {

            $classroom->fill([

                'project_id' => $data['project_id'],

                'name' => $data['name'],

                'description' => $data['description'] ?? null,

                'weekdays' => $data['weekdays'],

                'starts_on' => $data['starts_on'],

                'ends_on' => $data['ends_on'],

                'start_time' => $data['start_time'],

                'end_time' => $data['end_time'],
            ]);

            $classroom->save();

            $classroom->events()->delete();

            app(ClassroomEventGenerator::class)
                ->generate($classroom);

            return $classroom->fresh();
        });
    }

    public function delete(Classroom $classroom): bool 
    {
        return DB::transaction(function () use ($classroom) {

            $classroom->events()->delete();
            $classroom->delete();

            return true;
        });
    }
}