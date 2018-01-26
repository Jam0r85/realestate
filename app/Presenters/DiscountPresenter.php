<?php

namespace App\Presenters;

class DiscountPresenter extends BasePresenter
{
	/**
	 * Show the formatted discount amount.
	 * 
	 * @return string
	 */
	public function amount()
	{
        if ($this->entity->amount < 1) {
            return $this->entity->amount * 100 . '%';
        } else {
            return $this->money('amount');
        }
	}

	/**
	 * Show the name with the amount.
	 * 
	 * @return string
	 */
	public function nameWithAmount()
	{
		return $this->name . ' (' . $this->amount . ')';
	}
}