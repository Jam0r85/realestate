<?php

namespace App\Presenters;

class InvoicePresenter extends BasePresenter
{
	/**
	 * Get the name for this invoice.
	 * 
	 * @return string
	 */
	public function name()
	{
		return 'Invoice ' . str_replace('{{number}}', $this->number, $this->invoiceGroup->format);
	}

	/**
	 * Get the recipient for this invoice.
	 * 
	 * @return string
	 */
	public function recipient()
	{
		return nl2br($this->entity->recipient);
	}

	/**
	 * Get the user badges for this invoice.
	 * 
	 * @return string
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
	 * Get the invoice terms for the letter.
	 * 
	 * @return string
	 */
	public function termsLetter()
	{
		return nl2br($this->entity->terms);
	}

	/**
	 * Get the property address for property that this invoice is linked to.
	 * 
	 * @return string
	 */
	public function propertyAddress()
	{
		if ($this->property) {
			return $this->property->present()->inline;
		}

		return null;
	}

	/**
	 * Get the branch address for this invoice.
	 * 
	 * @return string
	 */
	public function branchAddress()
	{
		return $this->invoiceGroup->branch->present()->location;
	}

	/**
	 * Get the VAT number for this invoice.
	 * 
	 * @return string
	 */
	public function vatNumber()
	{
		if ($number = $this->invoiceGroup->branch->vat_number) {
			return '<b>VAT No.</b> ' . $number;
		}

		return null;
	}
}