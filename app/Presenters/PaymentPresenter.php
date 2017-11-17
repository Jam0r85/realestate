<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function name()
	{
		if ($this->parent_type == 'tenancies') {
			return 'Rent';
		} elseif ($this->parent_type == 'deposits') {
			return 'Deposit';
		}
	}

	/**
	 * @return string
	 */
	public function propertyName()
	{
		if (method_exists($this->parent, 'property')) {
			return $this->parent->property->present()->fullAddress;
		}
	}

	/**
	 * @return string
	 */
	public function tenancyName()
	{
		if ($this->parent_type == 'tenancies') {
			return $this->parent->present()->name;
		}
	}

	/**
	 * @return string
	 */
	public function branchAddress()
	{
		if ($this->parent_type == 'tenancies') {
			return $this->parent->property->branch->present()->location;
		}
	}
}