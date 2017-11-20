<?php

namespace App\Presenters;

class SmsPresenter extends BasePresenter
{
	/**
	 * @return srting
	 */
	public function messageIds()
	{
		if ($this->getMessageIds()) {
			return implode(', ', $this->getMessageIds());
		}
	}
}