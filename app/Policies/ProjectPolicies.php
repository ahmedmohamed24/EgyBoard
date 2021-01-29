<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicies
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user,Project $project)
    {
        // return $project->user->id == Auth::id();
        return $user->is($project->user);
    }
}
