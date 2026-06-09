<?php

namespace App\Domains\Volunteer\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\User\Models\User;
use App\Domains\Project\Models\Project;
use App\Domains\Volunteer\Models\Volunteer;
use App\Domains\Volunteer\Services\VolunteerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
    /**
     * LISTAGEM
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $volunteers = Volunteer::with(['user', 'project'])

            ->when($search, function ($query) use ($search) {

                $query->whereHas('user', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");

                })

                ->orWhereHas('project', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                });

            })

            ->paginate(10)
            ->withQueryString();

        return view('volunteers.index', compact('volunteers'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $projects = Project::all();

        $users = User::where('role', 'volunteer')->get();

        return view('volunteers.create', compact('projects', 'users'));
    }

    /**
     * SALVAR
     */
    public function store(Request $request)
    {
        $request->validate([

            'project_id' => 'required',

        ]);

        // CRIA USUÁRIO CASO NÃO EXISTA
        if (!$request->user_id) {

            $existingUser = User::where('email', $request->email)
                ->first();

            if ($existingUser) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'email' => 'Este e-mail já está cadastrado.'
                    ]);

            }

            $user = User::create([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'password' => Hash::make('123456'),
                'role' => User::ROLE_VOLUNTEER,

            ]);

            $userId = $user->id;

        } else {

            $userId = $request->user_id;

        }

        // CRIA VOLUNTÁRIO
        Volunteer::create([

            'user_id' => $userId,
            'project_id' => $request->project_id,
            'status' => $request->status,
            'applied_at' => now(),

        ]);

        return redirect()
            ->route('volunteers')
            ->with('success', 'Voluntário cadastrado!');
    }

    /**
     * FORM EDIT
     */
    public function edit(Volunteer $volunteer)
    {
        $projects = Project::all();

        $users = User::where('role', 'volunteer')->get();

        return view(
            'volunteers.edit',
            compact('volunteer', 'projects', 'users')
        );
    }

    /**
     * ATUALIZAR
     */
    public function update(Request $request, Volunteer $volunteer)
    {
        $request->validate([

            'project_id' => 'required',
            'user_id' => 'required',
            'status' => 'required|in:pending,approved,rejected',

        ]);

        $volunteer->update([

            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'applied_at' => $request->applied_at,
            'approved_at' => $request->approved_at,

        ]);

        return redirect()
            ->route('volunteers')
            ->with('success', 'Voluntário atualizado!');
    }

    /**
     * TELA DELETE
     */
    public function delete($id)
    {
        $volunteer = Volunteer::with(['user', 'project'])
            ->findOrFail($id);

        return view('volunteers.delete', compact('volunteer'));
    }

    /**
     * EXCLUIR
     */
    public function destroy($id, VolunteerService $service)
    {
        $volunteer = Volunteer::findOrFail($id);

        $service->detach(
            $volunteer->project_id,
            $volunteer->user_id
        );

        return redirect()
            ->route('volunteers')
            ->with('success', 'Voluntário removido com sucesso!');
    }
}