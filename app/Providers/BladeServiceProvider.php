<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // @icon
        Blade::directive('icon', function ($icon) {
            $icon = __('icons.'. str_replace("'", "", $icon));
        	return "<?php echo '<i class=\"fa fa-fw fa-{$icon}\"></i>'; ?>";
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}