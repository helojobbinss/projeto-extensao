<?php

namespace App\Domains\Project\Controllers;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Services\ProjectService;
use App\Domains\Project\Requests\ProjectRequest;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('coordinator')
            ->latest()
            ->paginate(9);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $admins = User::where('role', 'admin')->get();

        return view('projects.create', compact('admins'));
    }
    public function store(ProjectRequest $request, ProjectService $service)
    {
        $service->create($request->validated());

        return redirect()
            ->route('projects')
            ->with('success', 'Projeto criado com sucesso!');
    }
    public function edit(Project $project)
    {
        $admins = User::where('role', 'admin')->get();

        return view('projects.edit', compact('project', 'admins'));
    }

    public function update(ProjectRequest $request, Project $project, ProjectService $service)
    {
        $service->update($project, $request->validated());

        return redirect()
            ->route('projects')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Project $project, ProjectService $service)
    {
        $service->delete($project);

        return redirect()
            ->route('projects')
            ->with('success', 'Projeto deletado com sucesso!');
    }
}