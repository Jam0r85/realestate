<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
	/**
	 * 
	 * @return string
	 */
	public function parentName()
	{
		return parentModel($this->parent_type);
	}

	/**
	 * @return string
	 */
	public function name()
	{
		if ($this->parentName() == 'Tenancy') {
			return 'Rent';
		}

		return $this->parentName();
	}

	/**
	 * @return string
	 */
	public function badge()
	{
		return '<span class="badge badge-info">' . $this->name() . '</span>';
	}

	/**
	 * @return string
	 */
	public function forName()
	{
		if ($this->parentName() == 'Tenancy') {
			return $this->parent->present()->name;
		} elseif ($this->parentName() == 'Deposit') {
			return $this->parent->tenancy->present()->name;
		} elseif ($this->parentName() == 'Invoice') {
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
		foreach ($this->users as $user) {
			$names[] = '<span class="badge badge-secondary">' . $user->present()->fullName . '</span>';
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