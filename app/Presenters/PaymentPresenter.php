<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter
{
	/**
	 * Get the type for this payment.
	 * eg. invoices become Invoice
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
		} elseif ($this->parentName() == 'Deposit') {
			return 'Deposit';
		}

		return 'Payment';
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
		if ($this->parentName == 'Tenancy' || $this->parentName == 'Deposit') {
			return $this->tenancyName();
		} elseif ($this->parentName() == 'Invoice') {
			return $this->invoiceName();
		}
	}

	/**
	 * @return string
	 */
	public function propertyNameShort()
	{
		if (method_exists($this->parent, 'property')) {
			return $this->parent->property->present()->shortAddress;
		}
	}

	/**
	 * @return string
	 */
	public function propertyName()
	{
		if (method_exists($this->parent, 'property')) {
			return $this->parent->property->present()->fullAddress;
		}
	}

	/**
	 * @return string
	 */
	public function tenancyName()
	{
		if (class_basename($this->parent) == 'Tenancy') {
			return $this->parent->present()->name;
		}
	}

	/**
	 * @return string
	 */
	public function invoiceName()
	{
		if (class_basename($this->parent) == 'Invoice') {
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
	public function userNames()
	{
		foreach ($this->users as $user) {
			$names[] = '<span class="badge badge-secondary">' . $user->present()->fullName . '</span>';
		}

		if (isset($names) && count($names)) {
			return implode(' ', $names);
		}
	}
}