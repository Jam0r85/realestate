<?php

namespace App\Providers;

use App\InvoiceGroup;
use App\Payment;
use App\Permission;
use App\Policies\InvoiceGroupPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\StatementPolicy;
use App\Policies\TenancyPolicy;
use App\Statement;
use App\Tenancy;
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
        Permission::class => PermissionPolicy::class,
        InvoiceGroup::class => InvoiceGroupPolicy::class,
        Statement::class => StatementPolicy::class,
        Tenancy::class => TenancyPolicy::class,
        Payment::class => PaymentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('tenancies', 'TenancyPolicy', [
            'show' => 'show',
            'restore' => 'restore',
            'force-delete' => 'forceDelete'
        ]);
    }
}
