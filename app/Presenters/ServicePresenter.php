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

		return $this->money('charge');
	}

	/**
	 * Get the tax rate name for this service.
	 * 
	 * @return string
	 */
	public function taxRateName()
	{
		if ($this->taxRate) {
			return $this->taxRate->name;
		}

		return null;
	}

	/**
	 * @return  string
	 */
	public function statusLabel()
	{
		parent::statusLabel();

		return 'Active';
	}
}