<?php

namespace App\Presenters;

use App\BankAccount;
use Illuminate\Support\Facades\Storage;
use Laracasts\Presenter\Presenter;

class ExpensePresenter extends Presenter
{
	/**
	 * Get the formatted name for select dropdown boxes.
	 * 
	 * @return string
	 */
	public function selectName()
	{
		return $this->name . ' (Remaining Balance: ' . $this->money('balance') . ')';
	}

	/**
	 * @return  string
	 */
	public function contractorName()
	{
		if ($this->contractor) {
			return $this->contractor->present()->fullName;
		}
	}

	/**
	 * @return  string
	 */
	public function contractorBadge()
	{
		if ($this->contractor) {
			return '<span class="badge badge-secondary">' . $this->contractor->present()->fullName . '</span>';
		}
	}

	/**
	 * @return  string
	 */
	public function contractorPaymentMethod()
	{
		if ($this->contractor && $this->contractor->getSetting('contractor_bank_account_id')) {
			return BankAccount::findOrFail($this->contractor->getSetting('contractor_bank_account_id'))->present()->inline;
		} else {
			return 'Cash/Cheque';
		}
	}

	/**
	 * @return  string
	 */
	public function contractorPaidNotificationMethod()
	{
		if ($this->contractor && $this->contractor->getSetting('expense_paid_notifications')) {
			return $this->contractor->getSetting('expense_paid_notifications');
		} else {
			return 'n/a';
		}
	}

	/**
	 * @return  int
	 */
	public function remainingBalance()
	{
		return $this->cost - $this->payments->sum('amount');
	}

	/**
	 * @return  int
	 */
	public function remainingStatementBalance()
	{
		return $this->cost - ($this->payments->sum('amount') + $this->statements->sum('pivot.amount'));
	}

	/**
	 * @return  string
	 */
	public function status()
	{
		if ($this->paid_at) {
			return 'Paid';
		}

		if (!$this->paid_at) {
			return 'Unpaid';
		}
	}
}