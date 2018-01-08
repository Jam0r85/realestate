<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;
use Laracasts\Presenter\Presenter;

class AgreementPresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function startDateFormatted()
	{
		return date_formatted($this->starts_at);
	}

	/**
	 * @return string
	 */
	public function endDateFormatted()
	{
		if (!$this->ends_at) {
			return '-';
		}

		return date_formatted($this->ends_at);
	}

	/**
	 * @return string
	 */
	public function lengthFormatted()
	{
		$parts = explode('-', $this->length);

		if (! $parts[0]) {
			return 'SPT';
		}

		return $parts[0] . ' ' . ucwords($parts[1]);
	}

	/**
	 * @param  string  $return  
	 * @return string
	 */
	public function status()
	{
		if ($this->starts_at > Carbon::now()) {
			return 'Pending';
		}

		if ($this->deleted_at) {
			return 'Archived';
		}

		return 'Active';
	}
}