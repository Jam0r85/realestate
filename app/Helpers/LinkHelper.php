<?php

class Menu
{
	public static function activeRoute($route, $output = "is-active", $alternative = null)
	{
	    if (Route::currentRouteName() == $route) return $output;

	    return $alternative;
	}

	public static function activeRoutes(array $routes, $output = 'is-active')
	{
	    foreach ($routes as $route)
	    {
	        if (Route::currentRouteName() == $route) return $output;
	    }
	}
}