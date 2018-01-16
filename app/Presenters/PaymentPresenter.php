<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function name()
	{
		if (model_name($this->parent) == 'Tenancy') {
			return 'Rent';
		}

		return model_name($this->parent);
	}

	/**
	 * @return string
	 */
	public function nameBadge()
	{
		return $this->badge($this->name);
	}

	/**
	 * @return string
	 */
	public function forName()
	{
		if (model_name($this->parent) == 'Invoice') {
			return $this->parent->present()->name;
		}
	}

	/**
	 * @return string
	 */
	public function branchAddress()
	{
		if ($this->parent_type == 'tenancies') {
			return $this->parent->property->branch->present()->location;
		}
	}

	/**
	 * @return  string
	 */
	public function userBadges()
	{
		if (count($this->users)) {
			foreach ($this->users as $user) {
				$names[] = $this->badge($user->present()->fullName);
			}
		}

		if (isset($names) && count($names)) {
			return implode(' ', $names);
		}
	}

	/**
	 * @return  string
	 */
	public function userNames()
	{
		foreach ($this->users as $user) {
			$names[] = $user->present()->fullName;
		}

		if (isset($names) && count($names)) {
			return implode(' & ', $names);
		}
	}
}