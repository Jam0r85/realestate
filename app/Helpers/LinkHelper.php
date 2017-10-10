<?php

class Menu
{
	public static function activeRoute($route, $output = "is-active")
	{
	    if (Route::currentRouteName() == $route) return $output;
	}

	public static function activeRoutes(array $routes, $output = 'is-active')
	{
	    foreach ($routes as $route)
	    {
	        if (Route::currentRouteName() == $route) return $output;
	    }
	}
}