<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class TenancyPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function name()
	{
		if (count($this->tenants)) {
			foreach ($this->tenants as $user) {
				$names[] = $user->present()->fullName;
			}
		}

		if (isset($names) && count($names)) {
			return implode(' & ', $names);
		} else {
			return 'Tenancy #' . $this->id;
		}
	}

	/**
	 * @return integer
	 */
	public function rentAmount()
	{
		return $this->currentRent ? $this->currentRent->amount : 0;
	}

	/**
	 * @return integer
	 */
	public function rentTotal()
	{
		return $this->rent_payments->sum('amount');
	}

	/**
	 * @return integer
	 */
	public function statementTotal()
	{
		return $this->statements->sum('amount');
	}

	/**
	 * @return integer
	 */
	public function rentBalance()
	{
		return $this->rentTotal - $this->statementTotal;
	}

	/**
	 * @return string
	 */
	public function serviceName()
	{
		return $this->service ? $this->service->name : 'None';
	}

	/**
	 * @return string
	 */
	public function startDate()
	{
		return $this->first_agreement ? $this->first_agreement->starts_at : null;
	}

	/**
	 * @return string
	 */
	public function propertyAddress()
	{
		return $this->property->present()->fullAddress();
	}
}