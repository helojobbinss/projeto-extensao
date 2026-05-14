<?php
namespace App\Domains\Participant\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\User\Models\User;
use App\Domains\Project\Models\Project;
use App\Domains\Participant\Services\ParticipantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Domains\Participant\Models\Participant;
use Illuminate\Pagination\LengthAwarePaginator;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $participants = Participant::with(['user', 'project'])
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

        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $projects = Project::all();

        $users = User::where('role', 'participant')->get();

        return view('participants.create', compact('projects', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
        ]);


        if (!$request->user_id) {

            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Este e-mail já está cadastrado.']);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'password' => Hash::make('123456'),
                'role' => User::ROLE_PARTICIPANT,
            ]);

            $userId = $user->id;

        } else {
            $userId = $request->user_id;
        }

        Participant::create([
            'user_id' => $userId,
            'project_id' => $request->project_id,
            'status' => $request->status,
            'applied_at' => now(),
        ]);

        return redirect()->route('participants')
            ->with('success', 'Participante cadastrado!');
    }

    public function edit(Participant $participant)
    {
        $projects = Project::all();
        $users = User::where('role', 'participant')->get();

        return view('participants.edit', compact('participant', 'projects', 'users'));
    }

    public function update(Request $request, Participant $participant)
    {
        $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $participant->update([
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'applied_at' => $request->applied_at,
            'approved_at' => $request->approved_at,
        ]);

        return redirect()->route('participants')
            ->with('success', 'Participante atualizado!');
    }

    public function destroy($id, ParticipantService $service)
    {
        $participant = Participant::findOrFail($id);

        $service->detach(
            $participant->project_id,
            $participant->user_id
        );

        return redirect()->route('participants')
            ->with('success', 'Participante removido com sucesso!');
    }
}