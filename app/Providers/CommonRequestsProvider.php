<?php

namespace App\Providers;

use App\Branch;
use App\InvoiceGroup;
use App\Property;
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
        // Branches
        $this->app->singleton('branches', function ($app) {
            return cache()->rememberForever('branches', function () {
                return Branch::select('id','name')->orderBy('name')->get();
            });
        });

        // Users
        $this->app->singleton('users', function ($app) {
            return cache()->rememberForever('users', function () {
                return User::select('id','title','first_name','last_name','company_name','email')->orderBy('company_name')->orderBy('last_name')->orderBy('first_name')->get();
            });
        });

        // Properties
        $this->app->singleton('properties', function ($app) {
            return cache()->rememberForever('properties', function () {
                return Property::select('id','house_name','house_number','address1','address2','address3','town','county','postcode')->with('owners')->latest()->get();
            });
        });

        // Invoice Groups
        $this->app->singleton('invoice-groups', function ($app) {
            return cache()->rememberForever('invoice-groups', function () {
                return InvoiceGroup::select('id','name')->orderBy('name')->get();
            });
        });
    }
}
