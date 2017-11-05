<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $value = null)
    {
    	if ($setting = array_get(app('settings'), $key)) {
    		return $setting;
    	}

        return $value;
    }
}

function user_setting($setting, $user = null)
{
    if (is_null($user)) {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            return;
        }
    }

	if (array_has($user->settings, $setting)) {
		if ($value = $user->settings[$setting]) {
			return $value;
		}
	}

	return false;
}