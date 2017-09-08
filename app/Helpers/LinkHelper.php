<?php

class Menu
{

	public static function activeRoute($route, $output = "is-active")
	{
	    if (Route::currentRouteName() == $route) return $output;
	}
}