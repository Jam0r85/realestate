<?php

namespace App\Policies;

use App\User;
use App\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function view(User $user, Payment $payment)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('payments-view')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create payments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('payments-create')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function update(User $user, Payment $payment)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('payments-update')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function delete(User $user, Payment $payment)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionIsStaff('payments-delete')) {
            return true;
        }

        return false;
    }
}
