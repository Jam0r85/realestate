<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class MaintenancePresenter extends BasePresenter
{
	/**
	 * Get the status for this maintenance issue.
	 * 
	 * @return string
	 */
	public function statusLabel()
	{
		parent::statusLabel();

		if ($this->completed) {
			return 'Closed';
		}

		return 'Open';
	}
}