<?php

/**
 * Get a common request by it's name.
 */
if (!function_exists('get_common')) {
    function common($name)
    {
    	if ($common = app($name)) {
    		return $common;
    	}

        return null;
    }
}

/**
 * Get a common request by it's name.
 */
if (!function_exists('commonCount')) {
    function commonCount($name)
    {
    	if ($common = app($name)) {
    		return count($common);
    	}

        return null;
    }
}