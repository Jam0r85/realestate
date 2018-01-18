<?php

namespace App\Policies;

use App\Tenancy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenancyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if a tenancy can be created.
     * 
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given tenancy can be viewed by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Tenancy  $tenancy
     * @return bool
     */
    public function show(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user == $tenancy->owner->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given tenancy can be updated by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Tenancy  $tenancy
     * @return bool
     */
    public function show(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user == $tenancy->owner->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given tenancy can be deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Tenancy  $tenancy
     * @return bool
     */
    public function delete(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user == $tenancy->owner->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given tenancy can be restored by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Tenancy  $tenancy
     * @return bool
     */
    public function restore(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user == $tenancy->owner->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given tenancy can be force deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Tenancy  $tenancy
     * @return bool
     */
    public function forceDelete(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return false;
    }

}
