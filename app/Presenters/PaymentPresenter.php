<?php

namespace App\Presenters;

class PaymentPresenter extends BasePresenter
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
	public function for()
	{
		if (model_name($this->parent) == 'Invoice') {
			return $this->parent->present()->name;
		}

		if (model_name($this->parent) == 'Tenancy') {
			return 'Rent';
		}

		if (model_name($this->parent) == 'Deposit') {
			return 'Deposit';
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
		if (count($this->users)) {
			foreach ($this->users as $user) {
				$names[] = $user->present()->fullName;
			}
		}

		if (isset($names) && count($names)) {
			return implode(' & ', $names);
		}
	}
}