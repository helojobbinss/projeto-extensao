<?php

namespace App\Domains\Classroom\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Project\Models\Project;

use App\Domains\Classroom\Models\Classroom;
use App\Domains\Classroom\Requests\ClassroomRequest;
use App\Domains\Classroom\Services\ClassroomServices;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('project')
            ->latest()
            ->paginate(9);

        return view(
            'classrooms.index',
            compact('classrooms')
        );
    }

    public function create()
    {
        $projects = Project::orderBy('name')
            ->get();

        return view(
            'classrooms.create',
            compact('projects')
        );
    }

    public function store(ClassroomRequest $request, ClassroomServices $service) {

        $service->create($request->validated());

        return redirect()
            ->route('classrooms')
            ->with('success', 'Sala de aula criada com sucesso!');
    }

    public function edit(Classroom $classroom) {
        $projects = Project::orderBy('name')->get();

        return view('classrooms.edit',compact('classroom','projects'));
    }

    public function update(ClassroomRequest $request,Classroom $classroom,ClassroomServices $service) {

        $service->update( $classroom,$request->validated());

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