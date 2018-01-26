<?php

namespace App\Presenters;

use Carbon\Carbon;

class TenancyPresenter extends BasePresenter
{
	/**
	 * Get the tenancy name.
	 * 
	 * @return string
	 */
	public function name()
	{
		if ($this->entity->name) {
			return $this->entity->name;
		}

		return 'Tenancy ' . $this->id;
	}

	/**
	 * Show the select name for drop down menus.
	 * 
	 * @return  string
	 */
	public function selectName()
	{
		return $this->name . ' (' . $this->property->present()->shortAddress . ')';
	}

	/**
	 * Get the formatted rent amount.
	 * 
	 * @return string
	 */
	public function rent()
	{
		return $this->money('rent');
	}

	/**
	 * Get the formatted rent balance.
	 * 
	 * @return string
	 */
	public function rentBalance()
	{
		return $this->money('rent_balance');
	}

	/**
	 * Get the correct colour based on the given amounts.
	 * 
	 * @param  int  $amount
	 * @param  int  $compare
	 * @param  string  $class
	 * @return string
	 */
	public function balanceColour($amount, $compare, $class = null)
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

	/**
	 * Get the rent balance card background colour.
	 *
	 * @param  int  $rent
	 * @param  int  $balance
	 * @return string
	 */
	public function rentBalanceCardBackground()
	{
		return 'bg-' . $this->balanceColour($this->rent, $this->rent_balance);
	}

	/**
	 * Get the deposit balance card background colour.
	 *
	 * @param  int  $deposit
	 * @param  int  $balance
	 * @return string
	 */
	public function depositBalanceCardBackground($deposit, $balance)
	{
		return 'bg-' . $this->balanceColour($this->deposit->amount, $this->deposit->balance);
	}

	/**
	 * Get the rent balance with coloured formatting.
	 *
	 * @param  string  $class
	 * @return string
	 */
	public function rentBalanceWithColour($class = null)
	{
		$class = $this->balanceColour($this->rent_balance, $this->rent);

		return '<span class="text-' . $class .'">' . $this->rentBalance() . '</span>';
	}

	/**
	 * @return integer
	 */
	public function statementTotal($formatting = true)
	{
		$statements = $this->statements->sum('amount');

		if ($formatting == true) {
			return currency($statements);
		}

		return $statements;
	}

	/**
	 * The formatted start date for this tenancy.
	 * 
	 * @return string
	 */
	public function startDate()
	{
		return $this->date('started_on');
	}

	/**
	 * @return [type] [description]
	 */
	public function nextStatementStartDate($format = null)
	{
		if (count($this->statements)) {
			$date = $this->statements->first()->period_end->addDay();
		} elseif ($this->firstAgreement) {
			$date = $this->firstAgreement->starts_at;
		} else {
			$date = null;
		}

		if ($format && $date) {
			return $date->format($format);
		}

		return $date;
	}

	/**
	 * @return string
	 */
	public function monthlyServiceChargeWithoutTax()
	{
		return $this->money($this->entity->getMonthlyServiceChargeExcludingTax());
	}

	/**
	 * @return string
	 */
	public function monthlyServiceChargeWithTax()
	{
		return $this->money($this->entity->getMonthlyServiceChargeWithTax());
	}

	/**
	 * Present the status of this tenancy.
	 * 
	 * @param  string  $return
	 * @return  string
	 */
	public function status()
	{
		if (!$this->started_on) {
			if (!$this->firstAgreement) {
				return 'No Agreement';
			} else {
				return 'Starting ' . date_formatted($this->firstAgreement->starts_at);
			}
		}

		if ($this->vacated_on && $this->vacated_on <= Carbon::now()) {
			return 'Vacated';
		}

		if ($this->vacated_on && $this->vacated_on > Carbon::now()) {
			return 'Vacating';
		}

		if ($this->deleted_at) {
			return 'Archived';
		}

		return 'Active';
	}

	/**
	 * Get the landlord names for this tenancy.
	 * 
	 * @return string
	 */
	public function landlordNames($seperator = ' & ')
	{
		return implode($seperator, $this->entity->getLandlordNames());
	}

	/**
	 * Get the landlord address for this tenancy.
	 * 
	 * @return string
	 */
	public function landlordAddress()
	{
		if ($this->entity->getLandlordProperty()) {
			return $this->entity->getLandlordProperty()->present()->letter;
		}

		return null;		
	}

	/**
	 * Get the landlord address with names for this tenancy.
	 * 
	 * @return string
	 */
	public function landlordAddressWithNames($spacer = '<br />')
	{
		$build = $this->landlordNames();

		if ($this->landlordAddress()) {
			$build .= $spacer . $this->landlordAddress();
		}

		return $build;
	}
}