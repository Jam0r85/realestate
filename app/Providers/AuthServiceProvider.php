<?php

namespace App\Providers;

use App\InvoiceGroup;
use App\Policies\InvoiceGroupPolicy;
use App\Policies\StatementPolicy;
use App\Statement;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        InvoiceGroup::class => InvoiceGroupPolicy::class,
        Statement::class => StatementPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
