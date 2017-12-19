<?php

class Filter
{

	/**
	 * Get the range of months.
	 * 
	 * @return  array
	 */
	private function months()
	{
		return [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		];
	}

	/**
	 * Get a range of years for the dropdown.
	 * 
	 * @param  [type] $modelNamer [description]
	 * @param  [type] $column     [description]
	 * @return [type]             [description]
	 */
	private function years($modelName, $column)
	{
		// Set the start date and end date to today
		$start = $end = \Carbon\Carbon::now();

		// Set the start year to 10 years ago from today and the end year as this year
		$startYear = $start->subYears(10)->format('Y');
		$endYear = $end->format('Y');

		if ($modelName) {

			$model = new $modelName;

			if ($model) {

				// First and last records found when ordered by the column
				$first = $model->whereNotNull($column)->oldest($column)->first();
				$last = $model->whereNotNull($column)->latest($column)->first();

				// We have a first record, reset the start year
				if ($first) {
					$startYear = $first->$column->format('Y');
				}

				// We have a last record, reset the last year
				if ($last) {
					$endYear = $last->$column->format('Y');
				}

				$tableYears = $model
					->select(DB::raw('YEAR('.$column.') as year'))
					->whereNotNull($column)
					->groupBy('year')
					->get()
					->toArray();

				if ($tableYears) {

					// Loop through the years
					for ($i = $startYear; $i <= $endYear; $i++) {

						// Make sure that there is a record with that year in the table
						if (in_array($i, array_flatten($tableYears))) {
							$years[] = $i;
						}
					}

					return $years;
				}
			}
		}

		return ['2017'];
	}

	/**
	 * Turn a laravel route into a URL with added query string.
	 * 
	 * @param  string  $route  laravel route name
	 * @param  array  $query
	 * @return  string
	 */
	public static function link(array $queries = [])
	{
		// Get the url based on the route name
		$url = url()->current();

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
	 * Show the year dropdown filter.
	 * 
	 * @param  string  $model
	 * @param  string  $columnName
	 * @return  view
	 */
	public function yearDropdown($model = null, $column = 'created_at')
	{
		$years = $this->years($model, $column);

		return view('partials.filter.year-dropdown', ['years' => $years]);
	}

	/**
	 * Show the month dropdown filter.
	 * 
	 * @param  string  $model
	 * @param  string  $columnName
	 * @return  view
	 */
	public function monthDropdown()
	{
		$months = $this->months();
		return view('partials.filter.month-dropdown', ['months' => $months]);
	}

	/**
	 * Show the archive pill.
	 * 
	 * @return  view
	 */
	public static function archivePill()
	{
		return view('partials.filter.archive-pill');
	}

	/**
	 * Show the paid pill.
	 * 
	 * @return  view
	 */
	public static function paidPill()
	{
		return view('partials.filter.paid-pill');
	}

	/**
	 * Show the unpaid pill.
	 * 
	 * @return  view
	 */
	public static function unpaidPill()
	{
		return view('partials.filter.unpaid-pill');
	}

	/**
	 * Show the unsent pill.
	 * 
	 * @return  view
	 */
	public static function unsentPill()
	{
		return view('partials.filter.unsent-pill');
	}

	/**
	 * Show the sent pill.
	 * 
	 * @return  view
	 */
	public static function sentPill()
	{
		return view('partials.filter.sent-pill');
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