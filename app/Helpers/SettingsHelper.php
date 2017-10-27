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

function user_setting($user, $setting)
{
	if (array_has($user->settings, $setting)) {
		if ($value = $user->settings[$setting]) {
			return $value;
		}
	}

	return false;
}