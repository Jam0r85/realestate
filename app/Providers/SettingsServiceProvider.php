<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
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
        // Global Settings
        App::singleton('settings', function ($app) {
            return Cache::rememberForever('app_settings', function () {
                return Setting::pluck('value', 'key')->all();
            });
        });
    }
}
