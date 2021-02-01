<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicies
{
    use HandlesAuthorization;

    public function show(User $user,Project $project)
    {
        // return $project->user->id == Auth::id();
        return $user->is($project->user);
    }

    public function update(User $user,Project $project)
    {
        // return $project->user->id == Auth::id();
        return $user->is($project->user);
    }

    public function create(User $user,Project $project)
    {
        // return $project->user->id == Auth::id();
        return $user->is($project->user);
    }

    public function destroy(User $user,Project $project)
    {
        return $user->is($project->user);
    }
}
