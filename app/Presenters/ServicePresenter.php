<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class ServicePresenter extends BasePresenter
{
	public function serviceChargeFormatted()
	{
		if ($this->charge < 1) {
			return $this->charge * 100 . '%';
		} else {
			return currency($this->charge);
		}
	}
}