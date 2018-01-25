<?php

namespace App\Policies;

use App\Invoice;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine before.
     * 
     * @param  \App\User  $user
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
        if ($user->hasPermissionIsStaff('invoices-list')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if a Invoice can be created.
     * 
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasPermissionIsStaff('invoices-create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Invoice can be viewed by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return bool
     */
    public function view(User $user, Invoice $invoice)
    {
        if ($user->hasPermissionIsStaff('invoices-view')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Invoice can be updated by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return bool
     */
    public function update(User $user, Invoice $invoice)
    {
        if ($user->hasPermissionIsStaff('invoices-update')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Invoice can be deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return bool
     */
    public function delete(User $user, Invoice $invoice)
    {
        if ($user->hasPermissionIsStaff('invoices-delete')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Invoice can be restored by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return bool
     */
    public function restore(User $user, Invoice $invoice)
    {
        if ($user->hasPermissionIsStaff('invoices-restore')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the given Invoice can be force deleted by the user.
     * 
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return bool
     */
    public function forceDelete(User $user, Invoice $invoice)
    {
        if ($user->hasPermissionIsStaff('invoices-force-delete')) {
            return true;
        }

        return false;
    }

}