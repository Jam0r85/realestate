<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * The user we are dealing with.
     * 
     * @var \App\User
     */
    public $user;

    /**
     * Create a new policy instance.
     *
     * @param  \App\User  $user
     * @param  \App\InvoiceGroup  $invoice_group
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}