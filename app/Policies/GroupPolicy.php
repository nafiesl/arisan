<?php

namespace App\Policies;

use App\Group;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        // Update $user authorization to view $group here.
        return $group->creator_id == $user->id || $group->members->contains($user->id);
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function create(User $user, Group $group)
    {
        // Update $user authorization to create $group here.
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        // Update $user authorization to update $group here.
        return $user->id == $group->creator_id;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        // Update $user authorization to delete $group here.
        return $user->id == $group->creator_id;
    }
}
