<?php

/**
 * Format a date.
 * 
 * @param \Carbon\Carbon $date
 * @return string
 */
function date_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d M, Y');
}

/**
 * Format a time.
 * 
 * @param \Carbon\Carbon $date
 * @return string
 */
function time_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('H:i');
}

/**
 * Format a long date.
 * 
 * @param \Carbon\Carbon $date
 * @return string
 */
function longdate_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d F Y');
}

/**
 * Format a date and time.
 * 
 * @param \Carbon\Carbon $date
 * @return string
 */
function datetime_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d F, Y - g:i a');
}

/**
 * Calculate the end date when given the start date and a length.
 * 
 * @param \Carbon\Carbon $start
 * @param string $length
 * @return \Carbon\Carbon
 */
function calculate_end_date($start, $length)
{
    list($number, $modifier) = explode('-', $length);

    if ($number == 0) {
        return null;
    }

    if ($modifier == 'months' && $number > 0) {
        $ends_at = clone $start;
        return $ends_at->addMonth($number)->subDay();
    }
}

function date_modifier($start, $interval_type, $interval)
{
	$interval_type = 'add' . ucwords($interval_type);

	return $start->$interval_type($interval);
}

/**
 * Month names.
 * 
 * @return  array
 */
function months()
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

function years($modelName = null, $column = 'created_at')
{
	$start = $end = \Carbon\Carbon::now();
	$startYear = $start->subYears(10)->format('Y');
	$endYear = $end->format('Y');

	if ($modelName) {
		$model = new $modelName;
		if ($model) {
			$first = $model->oldest($column)->first();
			$last = $model->latest($column)->first();

			$startYear = $first->created_at->format('Y');
			$endYear = $last->created_at->format('Y');
		}
	}

	for ($i = $startYear; $i <= $endYear; $i++) {
		$years[] = $i;
	}

	return $years;
}