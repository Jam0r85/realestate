<?php

namespace App\Presenters;

class DepositPresenter extends BasePresenter
{
	/**
	 * Get the formatted balance for this deposit.
	 * 
	 * @return string
	 */
	public function balance()
	{
		return $this->money('balance');
	}
}