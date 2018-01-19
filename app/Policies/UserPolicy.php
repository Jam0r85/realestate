<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine before.
     * 
     * @param  \App\UserUser  $user
     * @param  string  $attributes
     * @return bool
     */
    public function before(User $user, $attributes)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (! $this->global($user)) {
            return false;
        }
    }

    /**
     * Determine whether the user can access the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function global(User $user)
    {
        if ($user->hasPermissionIsStaff('users')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-view')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->hasPermissionIsStaff('users-create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-update')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-restore')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can force delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-force-delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the permissions of the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function updatePermissions(User $user, User $model)
    {
        if ($user->hasPermissionIsStaff('users-update-permissions')) {
            return true;
        }

        return false;
    }
}
