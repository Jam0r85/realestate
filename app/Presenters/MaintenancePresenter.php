<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class MaintenancePresenter extends BasePresenter
{
	public function status()
	{
		if ($this->deleted_at) {
			return 'Deleted';
		}

		if ($this->completed) {
			return 'Closed';
		}

		return 'Open';
	}
}