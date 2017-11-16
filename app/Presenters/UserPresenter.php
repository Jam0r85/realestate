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
	public function location()
	{

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