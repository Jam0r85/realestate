<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
	/**
	 * The basic name of the user.
	 * 
	 * @return string
	 */
	public function name()
	{
		return $this->fullName();
	}

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
	public function selectName()
	{
		$value = $this->fullName;

		if ($this->email) {
			$value .= ' (' . $this->email . ')';
		}

		return $value;
	}
}