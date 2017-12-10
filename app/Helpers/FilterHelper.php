<?php

class Filter
{
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
		array_filter($newQueryString);

		// Remove pagination from the query
		unset($newQueryString['page']);

		// Add the new query string to the url
		if (count($newQueryString)) {
			$url = $url . '?' . http_build_query($newQueryString);
		}

		return $url;
	}

	/**
	 * Display the clear filter button.
	 * 
	 * @return  string
	 */
	public static function clearButton()
	{
		if (request()->query()) {
			return '
				<li class="nav-item">
					<a class="nav-link" href="' .  url()->current() . '">
						<i class="fa fa-trash"></i> Clear
					</a>
				</li>
			';
		}
	}
}