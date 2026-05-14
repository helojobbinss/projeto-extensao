<?php

namespace App\Domains\Volunteer\Services;

use App\Domains\Project\Models\Project;
use App\Domains\User\Models\User;
use Illuminate\Support\Facades\DB;

class VolunteerService
{
    public function attach(int $projectId, int $userId): array
    {
        $project = Project::findOrFail($projectId);
        User::findOrFail($userId); // garante que o user existe

        if ($project->volunteers()->where('user_id', $userId)->exists()) {
            return [
                'success' => false,
                'message' => 'Usuário já é voluntário deste projeto.',
            ];
        }

        return DB::transaction(function () use ($project, $userId) {
            $project->volunteers()->attach($userId);

            return [
                'success' => true,
                'message' => 'Voluntário adicionado com sucesso.',
            ];
        });
    }

    public function detach(int $projectId, int $userId): array
    {
        $project = Project::findOrFail($projectId);

        $removed = $project->volunteers()->detach($userId);

        if ($removed === 0) {
            return [
                'success' => false,
                'message' => 'Usuário não é voluntário deste projeto.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Voluntário removido com sucesso.',
        ];
    }
}
