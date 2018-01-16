<?php

namespace App\Policies;

use App\Statement;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can have access to all of the actions.
     * 
     * @param  \App\User  $user
     * @param  string  $ability
     * @return bool
     */
    public function before (User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given statement can be force deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Statement  $statement
     * @return bool
     */
    public function forceDelete(User $user, Statement $statement)
    {
        //
    }
}
