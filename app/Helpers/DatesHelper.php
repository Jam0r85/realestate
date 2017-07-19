<?php

function date_formatted($date)
{
	if (!$date) {
		return null;
	}

	return $date->format('d F, Y');
}

function datetime_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d F, Y - g:i a');
}