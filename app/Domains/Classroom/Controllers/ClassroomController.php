<?php

namespace App\Domains\Classroom\Controllers;

use App\Domains\Classroom\Models\Classroom;
use App\Domains\Classroom\Requests\ClassroomRequest;
use App\Domains\Classroom\Services\ClassroomServices;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::latest()->paginate(9);

        $classrooms->setCollection(
            $classrooms->getCollection()->transform(function (Classroom $classroom) {
                return (object) [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'description' => $classroom->description,
                    'weekday' => $classroom->weekday,
                    'start_at' => optional($classroom->start_at)->format('d/m/Y H:i') ?? '-',
                    'end_at' => optional($classroom->end_at)->format('d/m/Y H:i') ?? '-',
                ];
            })
        );

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(ClassroomRequest $request, ClassroomServices $service)
    {
        $service->create($request->validated());

        return redirect()
            ->route('classrooms')
            ->with('success', 'Sala de aula criada com sucesso!');
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(
        ClassroomRequest $request,
        Classroom $classroom,
        ClassroomServices $service
    ) {
        $service->update($classroom, $request->validated());

        return redirect()
            ->route('classrooms')
            ->with('success', 'Sala de aula atualizada com sucesso!');
    }

    public function destroy(Classroom $classroom, ClassroomServices $service)
    {
        $service->delete($classroom);

        return redirect()
            ->route('classrooms')
            ->with('success', 'Sala de aula deletada com sucesso!');
    }
}