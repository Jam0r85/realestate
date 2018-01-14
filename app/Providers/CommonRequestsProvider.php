<?php

namespace App\Providers;

use App\Branch;
use App\InvoiceGroup;
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

        // Invoice Groups
        $this->app->singleton('invoice-groups', function ($app) {
            return cache()->rememberForever('invoice-groups', function () {
                return InvoiceGroup::select('id','name')->orderBy('name')->get();
            });
        });
    }
}
