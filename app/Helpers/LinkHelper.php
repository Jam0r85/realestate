<?php

class Menu
{
	public static function activeRoute($route, $output = "active", $alternative = null)
	{
	    if (Route::currentRouteName() == $route) return $output;

	    return $alternative;
	}

	public static function activeRouteWithShow($route, $show, $output = "active")
	{
		$segments = Request::segments();

	    if (Route::currentRouteName() == $route) {

	    	if (in_array($show, $segments)) {
	    		return $output;
	    	}	
	    }
	}

	public static function activeRoutes(array $routes, $output = 'active')
	{
	    foreach ($routes as $route)
	    {
	        if (Route::currentRouteName() == $route) return $output;
	    }
	}

	public static function route($routeName, $id, $show = null)
	{
		return route($routeName, [$id, 'show' => $show]);
	}

	public static function showLink($title, $routeName, $id, $show = null)
	{
		return '<a href="' . Menu::route($routeName, $id, $show) . '" class="nav-link ' . Menu::activeRouteWithShow($routeName, $show) . '">' . $title . '</a>';
	}

	/**
	 * Turn a laravel route into a URL with added query string.
	 * 
	 * @param  string  $route  laravel route name
	 * @param  array  $query
	 * @return  string
	 */
	public static function link($route, array $queries = [])
	{
		// Get the url based on the route name
		$url = route($route);

		// Get the current query string as an array or create a new array
		$currentQueryString = request()->query() ?? [];

		// Merge the new queries with the current query string
		$newQueryString = array_merge($currentQueryString, $queries);

		// Remove null values from the query
		$newQueryString = array_filter($newQueryString);

		// Add the new query string to the url
		if (count($newQueryString)) {
			$url = $url . '?' . http_build_query($newQueryString);
		}

		return $url;
	}
}