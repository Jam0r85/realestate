<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class ServicePresenter extends BasePresenter
{
	/**
	 * The name for select drop down menus.
	 * 
	 * @return string
	 */
	public function selectName()
	{
		return $this->nameWithCharge();
	}

	/**
	 * The monthly charge formatted.
	 * 
	 * @return string
	 */
	public function monthlyCharge()
	{
		if ($this->is_percent) {
			return $this->charge . '%';
		}

		return $this->money('charge');
	}

	/**
	 * Show the service name with the charge.
	 * 
	 * @return string
	 */
	public function nameWithCharge()
	{
		return $this->name . ' (' . $this->monthlyCharge . ')';
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
	 * Show the status label for this service.
	 * 
	 * @return  string
	 */
	public function statusLabel()
	{
		parent::statusLabel();

		return 'Active';
	}
}