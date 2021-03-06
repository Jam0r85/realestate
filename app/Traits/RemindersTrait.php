<?php

namespace App\Traits;

use App\Reminder;
use App\ReminderType;
use Illuminate\Support\Facades\Auth;

trait RemindersTrait
{
	/**
	 * Get the reminder types for this eloquent model.
	 * 
	 * @return \App\ReminderType
	 */
	public function reminderTypes()
	{
		return ReminderType::where('parent_type', plural_from_model($this))->get();
	}

	/**
	 * Get the reminder type ID's.
	 * 
	 * @return array
	 */
	public function reminderTypeIds()
	{
		return $this->reminderTypes()->pluck('id')->toArray();
	}

	/**
	 * Get the reminders for this eloquent model.
	 * 
	 * @return \App\Reminder
	 */
	public function reminders()
	{
		return $this
			->morphMany('App\Reminder', 'parent')
			->whereIn('reminder_type_id', $this->reminderTypeIds());
	}

	/**
	 * Store a reminder to the model.
	 * 
	 * @param  \App\Reminder  $reminder
	 * @return \App\Reminder
	 */
	public function storeReminder(Reminder $reminder)
	{
		$reminder->user_id = Auth::user()->id;
		
		return $this->reminders()->save($reminder);
	}
}