<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

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
	 * Return the given date field as a formatted date and time or return the alternative value.
	 * 
	 * @param  string  $field
	 * @param  string  $alternative
	 * @return string
	 */
	public function dateTime($field, $alternative = null)
	{
		if (! $this->$field) {
			return $alternative;
		}

		return $this->$field->format(get_setting('date_time_format', 'Y-m-d H:i'));
	}

	/**
	 * Return the time since the given date field.
	 * 
	 * @param  string  $field
	 * @return string
	 */
	public function timeSince($field)
	{
		if (! $this->$field) {
			return null;
		}

		return $this->$field->diffForHumans();
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
	 * Get the created at date for this record.
	 * 
	 * @return srting
	 */
	public function dateTimeCreated()
	{
		return $this->dateTime('created_at');
	}

	/**
	 * Get the updated at date for this record.
	 * 
	 * @return srting
	 */
	public function dateUpdated()
	{
		return $this->dateTime('updated_at');
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

		if ($this->due_at) {
			if (! $this->paid_at && $this->due_at < Carbon::now()) {
				return 'Overdue';
			}
		}	

		if ($this->sent_at) {
			return 'Sent';
		}
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
	 * @param  string  $item
	 * @return string
	 */
	public function money($item)
	{
		if (! is_numeric($item)) {
			// Find the correct field
			if (! $item = $this->entity->$item) {
				$item = 0;
			}
		}

		return money_formatted($item);
	}

	/**
	 * Turn the given field name value into pounds from pence.
	 * 
	 * @param  mixed  $item 
	 * @return string
	 */
	public function pounds($item)
	{
		if (! is_numeric($item)) {
			if (! $item = $this->entity->$item) {
				$item = 0;
			}
		}

		return pence_to_pounds($item);
	}

	/**
	 * Get the correct colour based on the given amounts.
	 * 
	 * @param  int  $amount
	 * @param  int  $compare
	 * @param  string  $class
	 * @return string
	 */
	public function compareAmountsGetClass($amount, $compare, $class = null)
	{
		if ($this->amount >= $this->compare) {
			$class = 'success';
		} elseif ($this->amount > 0 && $this->amount < $this->compare) {
			$class = 'info';
		} elseif ($this->amount < 0) {
			$class = 'danger';
		}

		return $class;
	}
}