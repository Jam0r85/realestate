<?php

namespace App\Providers;

use App\Branch;
use App\InvoiceGroup;
use App\Property;
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

        // Properties
        $this->app->singleton('properties', function ($app) {
            return cache()->rememberForever('properties', function () {
                return Property::select('id')->latest()->get();
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
