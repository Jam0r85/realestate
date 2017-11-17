<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class StatementPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function paymentMethod()
	{
		if ($account = $this->tenancy->property->bank_account) {
			return $account->present()->inlineShort(' / ');
		}

		return 'Cash or Cheque';
	}

	/**
	 * @return string
	 */
	public function sendBy($prefix = 'Send by ')
	{
		if ($this->send_by == 'email') {
			return $prefix . 'E-Mail';
		} elseif ($this->send_by == 'post') {
			return $prefix . 'Post';
		}
	}

	/**
	 * @return string
	 */
	public function recipient()
	{
		foreach ($this->users as $user) {

			$names[] = $user->present()->fullName;

			if (!isset($home)) {
				$home = $user->home->present()->letter;
			}
		}

		if (isset($names) && count($names)) {
			$names = implode(' & ', $names);
		} else {
			$names = null;
		}

		if (isset($home)) {
			$home = '<br />' . $home;
		} else {
			$home = null;
		}

		return $names . $home;
	}

	/**
	 * @return string
	 */
	public function fullDate($date = 'created_at')
	{
		return longdate_formatted($this->$date);
	}

	/**
	 * @return string
	 */
	public function period()
	{
		return $this->fullDate('period_start') . ' - ' . $this->fullDate('period_end');
	}

	/**
	 * @return string
	 */
	public function tenants()
	{
		foreach ($this->tenancy->tenants as $user) {
			$names[] = $user->present()->fullName;
		}

		return implode(' & ', $names);
	}

	/**
	 * @return string
	 */
	public function tenancyName()
	{
		return $this->tenancy->present()->name;
	}

	/**
	 * @return string
	 */
	public function propertyAddress($length = 'short')
	{
		$length = $length . 'Address';

		return $this->tenancy->property->present()->$length;
	}

	/**
	 * @return string
	 */
	public function formattedAmount()
	{
		return currency($this->amount);
	}

	/**
	 * @return string
	 */
	public function branchAddress()
	{
		return $this->tenancy->property->branch->present()->location;	
	}

	/**
	 * @return string
	 */
	public function branchVatNumber()
	{
		return 'VAT No. ' . $this->tenancy->property->branch->vat_number;
	}

	/**
	 * @return string
	 */
	public function status()
	{
		if ($this->sent_at) {
			return 'Sent';
		} elseif ($this->paid_at) {
			return 'Paid';
		} elseif (!count($this->payments)) {
			return 'No Payments';
		} else {
			return 'Unpaid';
		}
	}

	/**
	 * @return string
	 */
	public function statusWithDate()
	{
		if ($this->status == 'Sent') {
			return $this->status . ' ' . date_formatted($this->sent_at);
		}
		
		return $this->status;
	}
}