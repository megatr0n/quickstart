<?php

namespace App\Repositories;

use App\User;
use App\Project;

class ProjectRepository
{
    /**
     * Get all of the projects for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Project::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
