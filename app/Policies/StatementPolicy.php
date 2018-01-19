<?php

namespace App\Policies;

use App\User;
use App\Statement;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Statement.
     *
     * @param  \App\User  $user
     * @param  \App\Statement  $statement
     * @return mixed
     */
    public function view(User $user, Statement $statement)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('statements-view')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create Statements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('statements-create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the Statement.
     *
     * @param  \App\User  $user
     * @param  \App\Statement  $statement
     * @return mixed
     */
    public function update(User $user, Statement $statement)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('statements-update')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the Statement.
     *
     * @param  \App\User  $user
     * @param  \App\Statement  $statement
     * @return mixed
     */
    public function delete(User $user, Statement $statement)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('statements-delete')) {
            return true;
        }

        return false;
    }
}
