<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class ServicePresenter extends BasePresenter
{
	/**
	 * @return  string
	 */
	public function selectName()
	{
		$name = $this->name;

		if ($this->serviceChargeFormatted) {
			$name .= ' ' . $this->serviceChargeFormatted;
		}

		return $name;
	}

	/**
	 * @return  string
	 */
	public function serviceChargeFormatted()
	{
		if ($this->charge < 1) {
			return $this->charge * 100 . '%';
		} else {
			return currency($this->charge);
		}
	}

	/**
	 * @return  string
	 */
	public function status()
	{
		if ($this->deleted_at) {
			return 'Archived';
		}

		if (!$this->deleted_at) {
			return 'Active';
		}
	}
}