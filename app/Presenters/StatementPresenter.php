<?php

namespace App\Presenters;

class StatementPresenter extends BasePresenter
{
	public function name()
	{
		return 'Statement #' . $this->id;
	}

	/**
	 * Get the statement start date.
	 * 
	 * @return string
	 */
	public function dateStart()
	{
		return $this->date('period_start');
	}

	/**
	 * Get the statement end date.
	 * 
	 * @return string
	 */
	public function dateEnd()
	{
		return $this->date('period_end');
	}
	
	/**
	 * Get the payment method name
	 * 
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
	public function sendByPlain()
	{
		return $this->sendBy(null);
	}

	/**
	 * @return string
	 */
	public function letterRecipient()
	{
		foreach ($this->users as $user) {

			$names[] = $user->present()->fullName;

			if (!isset($home)) {
				if ($user->home) {
					$home = $user->home->present()->letter;
				}
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
		foreach ($this->tenancy->users as $user) {
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
	public function amountFormatted()
	{
		return currency($this->amount);
	}

	/**
	 * Get the statement expense total
	 * 
	 * @return  integer
	 */
	public function expensesTotal()
	{
		return $this->expenses->sum('pivot.amount');
	}

	/**
	 * Get the statement invoice total
	 * 
	 * @param  string  $return
	 * @return  integer
	 */
	public function invoicesTotal($return = 'total')
	{
		$data['total'] = $data['net'] = $data['tax'] = 0;

		foreach ($this->invoices as $invoice) {
			$data['total'] += $invoice->present()->total;
			$data['net'] += $invoice->present()->itemsTotalNet;
			$data['tax'] += $invoice->present()->itemsTotalTax;
		}

		return $data[$return];
	}

	/**
	 * Get the statement net total
	 * 
	 * @return  integer
	 */
	public function netTotal()
	{
		return $this->expensesTotal() + $this->invoicesTotal('net');
	}

	/**
	 * Get the statement tax total
	 * 
	 * @return  integer
	 */
	public function taxTotal()
	{
		return $this->invoicesTotal('tax');
	}

	/**
	 * Get the statement total
	 * 
	 * @return  integer
	 */
	public function total()
	{
		return $this->taxTotal() + $this->netTotal();
	}

	/**
	 * Get the statement landlord balance
	 * 
	 * @return. integer
	 */
	public function landlordBalanceTotal()
	{
		return $this->amount - $this->total();
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
	 * Get the status label for this statement.
	 * 
	 * @return string
	 */
	public function statusLabel()
	{
		if (! $this->paid_at && count($this->unsentPayments)) {
			return 'Unpaid';
		}

		if (! $this->paid_at && count($this->payments)) {
			return 'Pending';
		}

		return parent::statusLabel();
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