<?php

namespace App\Domains\Participant\Services;

use App\Domains\Project\Models\Project;
use App\Domains\User\Models\User;
use Illuminate\Support\Facades\DB;

class ParticipantService
{
    public function attach(int $projectId, int $userId): array
    {
        $project = Project::findOrFail($projectId);
        User::findOrFail($userId); // garante que o user existe

        if ($project->participants()->where('user_id', $userId)->exists()) {
            return [
                'success' => false,
                'message' => 'Usuário já é participante deste projeto.',
            ];
        }

        return DB::transaction(function () use ($project, $userId) {
            $project->participants()->attach($userId);

            return [
                'success' => true,
                'message' => 'Participante adicionado com sucesso.',
            ];
        });
    }

    public function detach(int $projectId, int $userId): array
    {
        $project = Project::findOrFail($projectId);

        $removed = $project->participants()->detach($userId);

        if ($removed === 0) {
            return [
                'success' => false,
                'message' => 'Usuário não é participante deste projeto.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Participante removido com sucesso.',
        ];
    }
}
