<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenancyPolicy
{
    use HandlesAuthorization;

    /**
     * Global policy instance.
     * 
     * @param  \App\User  $user
     * @param  string  $attribute
     * @return mixed
     */
    public function before(User $user, $attribute)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

}
