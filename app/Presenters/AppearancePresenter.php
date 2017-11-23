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
			return 'Live on ' . date_formatted($this->live_at);
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

	/**
	 * @return  string
	 */
	public function statusLabel()
	{
		if ($this->deleted_at) {
			return 'Archived';
		}

		return $this->status->name;
	}
}