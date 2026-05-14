<?php

namespace App\Domains\Event\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Event\Models\Event;
use App\Domains\Event\Requests\EventRequest;
use App\Domains\Event\Services\EventService;
use App\Domains\Project\Models\Project;
use App\Domains\Classroom\Models\Classroom;
use App\Domains\User\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with([
                'project',
                'classroom',
            ])
            ->latest()
            ->paginate(9);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $projects = Project::all();
        $classrooms = Classroom::all();
         $admins = User::where('role', 'admin')->get();

        return view('events.create', compact(
            'projects',
            'classrooms',
            'admins'
        ));
    }

    public function store(
        EventRequest $request,
        EventService $service
    ) {
        $service->create($request->validated());

        return redirect()
            ->route('events')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Event $event)
    {
        $projects = Project::all();
        $classrooms = Classroom::all();

        return view('events.edit', compact(
            'event',
            'projects',
            'classrooms'
        ));
    }

    public function update(
        EventRequest $request,
        Event $event,
        EventService $service
    ) {
        $service->update($event, $request->validated());

        return redirect()
            ->route('events')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(
        Event $event,
        EventService $service
    ) {
        $service->delete($event);

        return redirect()
            ->route('events')
            ->with('success', 'Evento deletado com sucesso!');
    }
}