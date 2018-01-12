<?php

use App\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Get a setting by it's key from the global settings table.
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $value = null)
    {
    	if ($setting = array_get(app('settings'), $key)) {
    		return $setting;
    	}

        return $value;
    }
}

/**
 * Store a settin in the global settings table.
 */
if (!function_exists('set_setting')) {
	function set_setting($key, $value = null)
	{
		if (Setting::where('key', $key)->exists()) {
			Setting::where('key', $key)
				->update(['value' => $value]);
		} else {
			Setting::create(['key' => $key, 'value' => $value]);
		}

		Cache::forget('app_settings');
	}
}