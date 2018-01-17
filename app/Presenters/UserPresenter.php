<?php

namespace App\Presenters;

class UserPresenter extends BasePresenter
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

	/**
	 * Get the owner name for this user.
	 * 
	 * @return string
	 */
	public function ownerName()
	{
		if ($this->owner) {
			return $this->owner->present()->fullName();
		}

		return null;
	}

	/**
	 * Get the owner profile link.
	 * 
	 * @return string
	 */
	public function ownerProfileLink()
	{
		if ($this->owner) {
			return '<a href="' . route('users.show', $this->owner_id) . '">' . $this->ownerName . '</a>';
		}

		return null;
	}
}