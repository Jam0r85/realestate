<?php

namespace App\Repositories;

use App\Calendar;

class EloquentCalendarsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Calendar';
	}

	/**
	 * Get the archived events for the calendar.
	 * 
	 * @param  integer $calendar_id
	 * @return 
	 */
	public function archivedEvents($calendar_id)
	{
		$calendar = $this->find($calendar_id);
		return $calendar->archivedEvents()->count();
	}
}