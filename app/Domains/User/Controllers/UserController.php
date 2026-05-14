<?php

namespace App\Domains\User\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\User\Services\UserService;
use App\Domains\User\Requests\UserRequest;
use App\Domains\User\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function store(UserRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('users.index');
    }

    public function show($id)
    {
        if (!auth()->user()->isAdmin() && auth()->id() != $id) {
            abort(403);
        }

        return response()->json(
            $this->service->find($id)
        );
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:admin,volunteer,participant',
        ]);

        // ✔ dados normais
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // ✔ senha opcional (SEM Hash!)
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
}