<?php

namespace App\Domains\Project\Services;

use App\Domains\Project\Models\Project;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProjectService
{
    public function create(array $data): Project
    {
        return DB::transaction(fn () => Project::create($data));
    }

    public function update(Project $project, array $data): Project
    {
        return DB::transaction(function () use ($project, $data) {
            $project->fill($data)->save();
            return $project->fresh();
        });
    }

    public function delete(Project $project): bool
    {
        return DB::transaction(function () use ($project) {
            $project->participants()->detach();
            $project->delete();
            return true;
        });
    }
}
