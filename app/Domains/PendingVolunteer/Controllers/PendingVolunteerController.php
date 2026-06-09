<?php

namespace App\Domains\PendingVolunteer\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\PendingVolunteer\Models\PendingVolunteer;
use App\Domains\PendingVolunteer\Services\PendingVolunteerService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PendingVolunteerController extends Controller
{
    public function __construct(
        private PendingVolunteerService $service
    ) {}

    /**
     * LISTAR PENDENTES
     */
    public function index(): View
    {
        $volunteers = PendingVolunteer::with('project')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view(
            'pending-volunteers.index',
            compact('volunteers')
        );
    }

    /**
     * FORMULÁRIO DO SITE
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'birthdate' => [
                'required',
                'date',
                'before:today',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'project_id' => [
                'required',
                'exists:projects,id',
            ],
        ]);

        $result = $this->service->create(
            $validated
        );

        if (!$result['success']) {

            return back()
                ->withInput()
                ->withErrors([
                    'email' => $result['message']
                ]);
        }

        return back()
            ->with(
                'success',
                $result['message']
            );
    }

    /**
     * APROVAR
     */
    public function approve(int $id): RedirectResponse
    {
        $result = $this->service->approve($id);

        return back()->with(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );
    }

    /**
     * REJEITAR
     */
    public function reject(int $id): RedirectResponse
    {
        $result = $this->service->reject($id);

        return back()->with(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );
    }
}