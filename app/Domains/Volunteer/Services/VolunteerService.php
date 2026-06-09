<?php

namespace App\Domains\Volunteer\Services;

use App\Domains\Volunteer\Models\Volunteer;

class VolunteerService
{
    /**
     * CRIAR VOLUNTÁRIO
     */
    public function attach(int $projectId, int $userId): array
    {
        $exists = Volunteer::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->exists();

        if ($exists) {

            return [
                'success' => false,
                'message' => 'Usuário já é voluntário deste projeto.',
            ];

        }

        Volunteer::create([

            'project_id' => $projectId,
            'user_id' => $userId,
            'status' => 'pending',
            'applied_at' => now(),

        ]);

        return [

            'success' => true,
            'message' => 'Voluntário adicionado com sucesso.',

        ];
    }

    /**
     * REMOVER VOLUNTÁRIO
     */
    public function detach(int $projectId, int $userId): array
    {
        $volunteer = Volunteer::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if (!$volunteer) {

            return [
                'success' => false,
                'message' => 'Usuário não é voluntário deste projeto.',
            ];

        }

        $volunteer->delete();

        return [

            'success' => true,
            'message' => 'Voluntário removido com sucesso.',

        ];
    }

    public function approve($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Voluntário aprovado!');
    }
}