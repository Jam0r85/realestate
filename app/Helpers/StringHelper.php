<?php

if (!function_exists('truncate')) {
	function truncate($value, $characters = '25')
	{
		return str_limit($value, $characters);
	}
}