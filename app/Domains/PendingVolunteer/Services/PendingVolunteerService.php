<?php

namespace App\Domains\PendingVolunteer\Services;

use App\Domains\PendingVolunteer\Models\PendingVolunteer;
use App\Domains\User\Models\User;
use App\Domains\Volunteer\Models\Volunteer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PendingVolunteerService
{
    /**
     * CRIAR CANDIDATURA
     */
    public function create(array $data): array
    {
        $exists = PendingVolunteer::where('email', $data['email'])
            ->where('status', 'pending')
            ->exists();

        if ($exists) {

            return [
                'success' => false,
                'message' => 'Já existe uma solicitação pendente para este e-mail.',
            ];

        }

        PendingVolunteer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'birthdate' => $data['birthdate'],
            'phone' => $data['phone'] ?? null,
            'project_id' => $data['project_id'],
            'status' => 'pending',
        ]);

        return [
            'success' => true,
            'message' => 'Solicitação enviada com sucesso.',
        ];
    }

    /**
     * APROVAR CANDIDATO
     */
    public function approve(int $id): array
    {
        $candidate = PendingVolunteer::find($id);

        if (!$candidate) {

            return [
                'success' => false,
                'message' => 'Candidato não encontrado.',
            ];

        }

        if ($candidate->status === 'approved') {

            return [
                'success' => false,
                'message' => 'Este candidato já foi aprovado.',
            ];

        }

        DB::transaction(function () use ($candidate) {

            $user = User::create([
                'name' => $candidate->name,
                'email' => $candidate->email,
                'birthdate' => $candidate->birthdate,
                'password' => Hash::make('123456'),
            ]);

            Volunteer::create([
                'user_id' => $user->id,
                'project_id' => $candidate->project_id,
                'status' => 'approved',
                'applied_at' => $candidate->created_at,
                'approved_at' => now(),
            ]);

            $candidate->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        });

        return [
            'success' => true,
            'message' => 'Voluntário aprovado com sucesso.',
        ];
    }

    /**
     * REJEITAR CANDIDATO
     */
    public function reject(int $id): array
    {
        $candidate = PendingVolunteer::find($id);

        if (!$candidate) {

            return [
                'success' => false,
                'message' => 'Candidato não encontrado.',
            ];

        }

        $candidate->update([
            'status' => 'rejected',
        ]);

        return [
            'success' => true,
            'message' => 'Solicitação rejeitada.',
        ];
    }
}