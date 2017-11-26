<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ExpensePresenter extends Presenter
{
	/**
	 * @return  string
	 */
	public function contractorName()
	{
		if ($this->contractor) {
			return $this->contractor->present()->fullName;
		}
	}

	/**
	 * @return  integer
	 */
	public function remainingBalance()
	{
		return $this->cost - $this->payments->sum('amount');
	}
}