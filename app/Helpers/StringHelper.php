<?php

/**
 * Truncate a string
 */
if (!function_exists('truncate')) {
	function truncate($value, $characters = '25')
	{
		return str_limit($value, $characters);
	}
}

/**
 * Convert a slug into a name.
 */
if (!function_exists('slug_to_name')) {
	function slug_to_name($slug)
	{
		return ucwords(str_replace('-', ' ', $slug));
	}
}