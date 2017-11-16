<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function fullName()
	{
		return $this->company_name ?? $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * @return string
	 */
	public function location($length = 'short')
	{
		$length = $length . 'Address';

		foreach ($this->tenancies as $tenancy) {
			if ($tenancy->isActive()) {
				return $tenancy->property->present()->$length;
			}
		}

		if ($this->home) {
			return $this->home->present()->$length;
		}
	}

	/**
	 * @return string
	 */
	public function selectName()
	{
		$value = $this->fullName;

		if ($this->email) {
			$value .= ' (' . $this->email . ')';
		}

		return $value;
	}
}