<?php

namespace App\Presenters;

class InvoicePresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function name()
	{
		return $this->number;
	}

	/**
	 * @return string
	 */
	public function letterRecipient()
	{
		if (count($this->statements)) {
			$statement = $this->statements->first();
			return $statement->present()->letterRecipient;
		}

		return $this->usersList . '<br />' . nl2br($this->recipient);
	}

	/**
	 * @return string
	 */
	public function usersList()
	{
		foreach ($this->users as $user) {
			$names[] = $user->present()->fullName;
		}

		if (isset($names) && count($names)) {
			return implode(' & ', $names);
		}
	}

	/**
	 * @return string
	 */
	public function fullDate($date = 'created_at')
	{
		return longdate_formatted($this->$date);
	}

	/**
	 * Get the invoice total
	 * 
	 * @return  integer
	 */
	public function total()
	{
		return $this->itemsTotal();
	}

	/**
	 * Get the invoice items total
	 * 
	 * @return  integer
	 */
	public function itemsTotal()
	{
		return $this->items->sum('total');
	}

	/**
	 * Get the invoice items net total
	 * 
	 * @return  integer
	 */
	public function itemsTotalNet()
	{
		return $this->items->sum('total_net');
	}

	/**
	 * Get the invoice items tax total
	 * 
	 * @return  integer
	 */
	public function itemsTotalTax()
	{
		return $this->items->sum('total_tax');
	}

	/**
	 * Get the invoice payments total
	 * 
	 * @return  integer
	 */
	public function paymentsTotal()
	{
		return $this->payments->sum('amount') + $this->statement_payments->sum('amount');
	}

	/**
	 * Get the invoice remaining balance total
	 * 
	 * @return  integer
	 */
	public function remainingBalanceTotal()
	{
		return $this->total() - $this->paymentsTotal();
	}

	/**
	 * @return string
	 */
	public function paperTerms()
	{
		return $this->terms;
	}

	/**
	 * @return string
	 */
	public function propertyAddress($length = 'short')
	{
		$method = $length . 'Address';

		if ($this->property) {
			return $this->property->present()->$method;
		}
	}

	/**
	 * @return string
	 */
	public function branchAddress()
	{
		if ($this->property) {
			return $this->property->branch->present()->location;
		}
	}

	/**
	 * @return string
	 */
	public function branchVatNumber()
	{
		if ($this->property) {
			return 'VAT No. ' . $this->property->branch->vat_number;
		}
	}

	/**
	 * @return string
	 */
	public function status($return = 'value')
	{
		if ($this->statement && $this->statement->paid_at) {
			$data['value'] = 'Paid';
			$data['class'] = 'text-success';
		} elseif ($this->statement && !$this->statement->paid_at) {
			$data['value'] = 'Unpaid';
			$data['class'] = '';
		} elseif ($this->paid_at) {
			$data['value'] = 'Paid';
			$data['class'] = 'text-success';
		} elseif ($this->deleted_at) {
			$data['value'] = 'Archived';
			$data['class'] = 'secondary';
		} else {
			$data['value'] = 'Unpaid';
			$data['class'] = '';
		}

		return $data[$return];
	}
}