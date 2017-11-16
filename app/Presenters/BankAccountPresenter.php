<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class BankAccountPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function inline($separator = ' - ')
	{
        return $this->account_name . $separator . $this->bank_name . $separator . $this->account_number . $separator . $this->sort_code;
	}
}