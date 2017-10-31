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

function date_modifier($start, $interval_type, $interval)
{
	$interval_type = 'add' . ucwords($interval_type);

	return $start->$interval_type($interval);
}