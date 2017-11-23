<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;
use Laracasts\Presenter\Presenter;

class AppearancePresenter extends BasePresenter
{
	/**
	 * @return  string
	 */
	public function liveStatus()
	{
		if (!$this->live_at) {
			return 'No Date';
		}

		if ($this->live_at < Carbon::now()) {
			return 'Not Live';
		}

		if ($this->live_at >= Carbon::now()) {
			return 'Live';
		}
	}

	/**
	 * @return  string
	 */
	public function visibility()
	{
		if ($this->hidden) {
			$icon = 'fa-eye-slash';
			$value = 'Hidden';
		} else {
			$icon = 'fa-eye';
			$value = 'Public';
		}

		return '<i class="fa ' . $icon . '"></i> ' . $value;
	}
}