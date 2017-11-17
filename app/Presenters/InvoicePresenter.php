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
		if ($this->statement) {
			return $this->statement->present()->recipient;
		}

		return $this->usersList . '<br />' . $this->recipient;
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
	public function trashedIcon()
	{
		if ($this->deleted_at) {
			return '<i class="fa fa-trash"></i>';
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
		} else {
			$data['value'] = 'Unpaid';
			$data['class'] = '';
		}

		return $data[$return];
	}
}