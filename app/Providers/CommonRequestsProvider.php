<?php

namespace App\Providers;

use App\Branch;
use App\InvoiceGroup;
use App\PaymentMethod;
use App\Permission;
use App\Property;
use App\Service;
use App\Tenancy;
use App\User;
use Illuminate\Support\ServiceProvider;

class CommonRequestsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Permissions
        $this->app->singleton('permissions', function ($app) {
            return cache()->rememberForever('permissions', function () {
                return Permission::orderBy('name')->get();
            });
        });

        // Branches
        $this->app->singleton('branches', function ($app) {
            return cache()->rememberForever('branches', function () {
                return Branch::select('id','name')->orderBy('name')->get();
            });
        });

        // Users
        $this->app->singleton('users', function ($app) {
            return cache()->rememberForever('users', function () {
                return User::select('id','title','first_name','last_name','company_name','email')->latest()->get();
            });
        });

        // Properties
        $this->app->singleton('properties', function ($app) {
            return cache()->rememberForever('properties', function () {
                return Property::select('id','house_name','house_number','address1','address2','address3','town','county','postcode')->with('owners')->latest()->get();
            });
        });

        // Services
        $this->app->singleton('services', function ($app) {
            return cache()->rememberForever('services', function () {
                return Service::select('id','name','charge')->orderBy('name')->get();
            });
        });

        // Invoice Groups
        $this->app->singleton('invoice-groups', function ($app) {
            return cache()->rememberForever('invoice-groups', function () {
                return InvoiceGroup::select('id','name')->orderBy('name')->get();
            });
        });

        // Payment Methods
        $this->app->singleton('payment-methods', function ($app) {
            return cache()->rememberForever('payment-methods', function () {
                return PaymentMethod::select('id','name')->orderBy('name')->get();
            });
        });

        // Tenancies
        $this->app->singleton('tenancies', function ($app) {
            return cache()->rememberForever('tenancies', function () {
               return Tenancy::select('id','name','property_id')->with([
                    'property' => function($query) {
                        $query->select('id','house_name','house_number','address1');
                    }
                ])->latest()->get();
            });
        });
    }
}
