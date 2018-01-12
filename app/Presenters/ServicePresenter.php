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
	public function monthlyChargeFormatted()
	{
		if ($this->is_percent) {
			return $this->charge . '%';
		}

		return money_formatted($this->charge);
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