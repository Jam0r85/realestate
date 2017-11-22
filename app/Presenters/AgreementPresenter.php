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

		if (!$parts[0]) {
			return 'SPT';
		}

		return $parts[0] . ' ' . ucwords($parts[1]);
	}

	/**
	 * @param  string  $return  
	 * @return  string
	 */
	public function status($return = 'label')
	{
		if ($this->starts_at > Carbon::now()) {
			$data['label'] = 'Pending';
			$data['class'] = 'info';
		}

		if ($this->starts_at <= Carbon::now()) {
			$data['label'] = 'Active';
			$data['class'] = 'success';
		}

		if ($this->ends_at && $this->ends_at < Carbon::now()) {
			$data['label'] = 'Ended';
			$data['class'] = 'secondary';
		}

		return $data[$return];
	}
}