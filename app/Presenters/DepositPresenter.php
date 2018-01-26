<?php

namespace App\Presenters;

class DepositPresenter extends BasePresenter
{
	/**
	 * Get the formatted amount for this deposit.
	 * 
	 * @return string
	 */
	public function amount()
	{
		return $this->money('amount');
	}

	/**
	 * Get the formatted balance for this deposit.
	 * 
	 * @return string
	 */
	public function balance()
	{
		return $this->money('balance');
	}

	/**
	 * Get the deposit balance card background colour.
	 *
	 * @return string
	 */
	public function depositBalanceCardBackground()
	{
		return 'bg-' . $this->compareAmountsGetClass($this->balance, $this->amount);
	}
}