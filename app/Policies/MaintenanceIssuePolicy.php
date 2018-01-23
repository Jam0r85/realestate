<?php

namespace App\Policies;

use App\Maintenance;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceIssuePolicy
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
        if ($user->hasPermissionIsStaff('maintenances-list')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if a Maintenance can be created.
     * 
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasPermissionIsStaff('maintenances-create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Maintenance can be viewed by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Maintenance  $Maintenance
     * @return bool
     */
    public function view(User $user, Maintenance $Maintenance)
    {
        if ($user->hasPermissionIsStaff('maintenances-view')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Maintenance can be updated by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Maintenance  $Maintenance
     * @return bool
     */
    public function update(User $user, Maintenance $Maintenance)
    {
        if ($user->hasPermissionIsStaff('maintenances-update')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Maintenance can be deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Maintenance  $Maintenance
     * @return bool
     */
    public function delete(User $user, Maintenance $Maintenance)
    {
        if ($user->hasPermissionIsStaff('maintenances-delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Maintenance can be restored by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Maintenance  $Maintenance
     * @return bool
     */
    public function restore(User $user, Maintenance $Maintenance)
    {
        if ($user->hasPermissionIsStaff('maintenances-restore')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Maintenance can be force deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Maintenance  $Maintenance
     * @return bool
     */
    public function forceDelete(User $user, Maintenance $Maintenance)
    {
        if ($user->hasPermissionIsStaff('maintenances-force-delete')) {
            return true;
        }

        return false;
    }

}
