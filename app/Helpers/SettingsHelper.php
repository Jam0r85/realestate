<?php

if (!function_exists('getSetting')) {
    function getSetting($key, $value = null)
    {
    	if ($setting = array_get(app('settings'), $key)) {
    		return $setting;
    	}

        return $value;
    }
}
