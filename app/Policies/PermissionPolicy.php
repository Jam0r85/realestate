<?php

namespace App\Policies;

use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine before whether the user can see access permissions.
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

        return false;
    }

    /**
     * Determine whether the user can see the list of permissions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        //        
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function view(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function update(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param  \App\User  $user
     * @param  \App\Permission  $permission
     * @return mixed
     */
    public function delete(User $user, Permission $permission)
    {
        //
    }
}
