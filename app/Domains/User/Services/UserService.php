<?php

namespace App\Domains\User\Services;

use App\Domains\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data)
    {
        if (User::where('email', $data['email'])->exists()) {
            return [
                'success' => false,
                'message' => 'Este e-mail já está cadastrado.',
                'user'    => null,
            ];
        }

        return DB::transaction(function () use ($data) {

            if (!auth()->user()?->isAdmin()) {
                $data['role'] = User::ROLE_PARTICIPANT; 
            }

 
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = User::create($data);

            return [
                'success' => true,
                'message' => 'Usuário criado com sucesso.',
                'user'    => $user,
            ];
        });
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);

        
        if (!empty($data['email']) && $data['email'] !== $user->email) {
            $exists = User::where('email', $data['email'])
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return [
                    'success' => false,
                    'message' => 'Este e-mail já está cadastrado por outro usuário.',
                    'user'    => null,
                ];
            }
        }

        return DB::transaction(function () use ($user, $data) {
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            if (!auth()->user()?->isAdmin()) {
                unset($data['role']);
            }

            $user->update($data);

            return [
                'success' => true,
                'message' => 'Usuário atualizado com sucesso.',
                'user'    => $user->fresh(),
            ];
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            User::findOrFail($id)->delete();
            return true;
        });
    }

    public function list(array $filters = [])
    {
        $query = User::query();

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function find(int $id)
    {
        return User::findOrFail($id);
    }
}
