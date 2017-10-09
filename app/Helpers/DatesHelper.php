<?php

function date_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d M, Y');
}

function time_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('H:i');
}

function longdate_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d F Y');
}

function datetime_formatted($date)
{
	if (empty($date)) {
		return null;
	}

	return $date->format('d F, Y - g:i a');
}