<?php

namespace App\Traits;

trait RemindersTrait
{
	/**
	 * Eloquent model has many reminders.
	 */
	public function reminders()
	{
		return $this->morphMany('App\Reminder', 'parent')
			->latest();
	}

	/**
	 * ELoquent model has a latest reminder.
	 */
	public function latestReminder()
	{
		return $this->morphOne('App\Reminder', 'parent')
			->latest();
	}
}