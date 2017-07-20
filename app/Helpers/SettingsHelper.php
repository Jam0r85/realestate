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
