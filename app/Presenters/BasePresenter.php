<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class BasePresenter extends Presenter
{
	/**
	 * Get the branch name.
	 * 
	 * @return string
	 */
	public function branchName()
	{
		if ($this->branch) {
			return $this->branch->name;
		}

		return null;
	}

	/**
	 * Return the given date field as a formatted date or return the alternative value.
	 * 
	 * @param  string  $field
	 * @param  string  $alternative
	 * @return string
	 */
	public function date($field, $alternative = null)
	{
		if (! $this->$field) {
			return $alternative;
		}

		return $this->$field->format(get_setting('date_format', 'Y-m-d'));
	}

	/**
	 * Return the given date column as a date field.
	 * 
	 * @param  string  $field
	 * @param  string  $alternative
	 * @return string
	 */
	public function dateInput($field, $alternative = null)
	{
		if (! $this->$field) {
			return $alternative;
		}

		return $this->$field->format('Y-m-d');
	}

	/**
	 * Get the created at date for this record.
	 * 
	 * @return srting
	 */
	public function dateCreated()
	{
		return $this->date('created_at');
	}

	/**
	 * Get the updated at date for this record.
	 * 
	 * @return srting
	 */
	public function dateUpdated()
	{
		return $this->date('updated_at');
	}

	/**
	 * Get the deleted at date for this record.
	 * 
	 * @return srting
	 */
	public function dateDeleted()
	{
		return $this->date('deleted_at');
	}

	/**
	 * Get the paid date for this record.
	 * 
	 * @return srting
	 */
	public function datePaid($alternative = null)
	{
		return $this->date('paid_at', $alternative);
	}

	/**
	 * Get the sent date for this record.
	 * 
	 * @return srting
	 */
	public function dateSent($alternative = null)
	{
		return $this->date('sent_at', $alternative);
	}

	/**
	 * Get the invoice status label.
	 * 
	 * @return string
	 */
	public function statusLabel()
	{
		if ($this->deleted_at) {
			return 'Archived';
		}

		if ($this->paid_at) {
			return 'Paid';
		}

		if (! $this->paid_at && $this->due_at < Carbon::now()) {
			return 'Overdue';
		}

		if ($this->sent_at) {
			return 'Sent';
		}

		return 'Unpaid';
	}

	/**
	 * Get the invoice status class.
	 * 
	 * @return string
	 */
	public function statusClass()
	{
		if ($this->deleted_at) {
			return 'secondary';
		}
		
		if ($this->paid_at) {
			return 'success';
		}

		if (! $this->paid_at && $this->due_at < Carbon::now()) {
			return 'danger';
		}

		return null;
	}

	/**
	 * Get the html for a badge.
	 * 
	 * @return string
	 */
	public function badge($value = null, $class = 'secondary')
	{
		if (is_null($value)) {
			return null;
		}
		
		return '<span class="badge badge-' . $class . '">' . $value . '</span>';
	}

	/**
	 * Get the amount formatted as money.
	 * 
	 * @param  string  $field
	 * @return string
	 */
	public function money($field)
	{
		// Find the correct field
		if (! $amount = $this->$field) {
			$amount = 0;
		}

		$country = \Countries::where('name.common', get_setting('default_country', 'United Kingdom'))->first();
		$currencyCode = $country->currency[0]['ISO4217Code'];

		$money = new Money ($amount, new Currency ($currencyCode));
		$currencies = new ISOCurrencies();

		$numberFormatter = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
		$moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

		return $moneyFormatter->format($money);
	}
}