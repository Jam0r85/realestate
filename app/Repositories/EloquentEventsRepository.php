<?php

namespace App\Repositories;

use Carbon\Carbon;

class EloquentEventsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Event';
	}

	/**
	 * Return a fullcalendar style feed of events.
	 *
	 * @param 	integer 	$calendar_id
	 * @return 	collection
	 */
	public function feed($calendar_id = null)
	{
		$collection = $this->getInstance()->select('id','calendar_id','title','start','end','allDay');

		if ($calendar_id) {
			$collection->where('calendar_id', $calendar_id);
		}

		return $collection->get()->toArray();
	}

	/**
	 * Event feed for trashed items.
	 * 
	 * @param  integer $calendar_id [description]
	 * @return collection
	 */
	public function feedTrashed($calendar_id = null)
	{
		$collection = $this->getInstance()->select('id','calendar_id','title','start','end','allDay');

		if ($calendar_id) {
			$collection->where('calendar_id', $calendar_id);
		}

		return $collection->onlyTrashed()->get()->toArray();
	}

	/**
	 * Create a new event.
	 * 
	 * @param  array  $data
	 * @return user
	 */
	public function createEvent(array $data)
	{
		$data['start'] = Carbon::parse($data['start']);
		$data['end'] = Carbon::parse($data['end']);

		return $this->create($data);
	}

	/**
	 * Create a new event.
	 * 
	 * @param  array  $data
	 * @return user
	 */
	public function updateEvent(array $data, $id)
	{
		$data['start'] = Carbon::parse($data['start']);
		$data['end'] = Carbon::parse($data['end']);

		return $this->update($data, $id);
	}
}