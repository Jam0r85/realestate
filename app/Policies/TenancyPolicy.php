<?php

namespace App\Policies;

use App\Tenancy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenancyPolicy
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
    }

    /**
     * Determine if the list of tenancies can be viewed by this user.
     * 
     * @param  \App\User  $user
     * @return bool
     */
    public function list(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermission('tenancies-list')) {
            return true;
        }

        return false;
    }

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
    public function view(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsOwner('tenancies-view', $tenancy)) {
            return true;
        }

        if ($user->hasPermissionIsStaff('tenancies-view')) {
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
    public function update(User $user, Tenancy $tenancy)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsOwner('tenancies-update', $tenancy)) {
            return true;
        }

        if ($user->hasPermissionIsStaff('tenancies-update')) {
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

        if ($user->hasPermissionIsOwner('tenancies-delete', $tenancy)) {
            return true;
        }

        if ($user->hasPermissionIsStaff('tenancies-delete')) {
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

        if ($user->hasPermissionIsStaff('tenancies-restore')) {
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

        if ($user->hasPermissionIsStaff('tenancies-force-delete')) {
            return true;
        }

        return false;
    }

}
