<?php

namespace App\Presenters;

class ReminderTypePresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function selectName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function autoReminderPeriod()
	{
		if (!$this->entity->hasAutoReminders()) {
			return 'None';
		}

		return 'Every ' . $this->entity->getAutoReminderFrequency() . ' ' . str_plural($this->entity->getAutoReminderFrequencyType(), $this->entity->getAutoReminderFrequency());
	}
}