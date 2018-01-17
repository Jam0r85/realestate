<?php

namespace App\Presenters;

use Carbon\Carbon;

class TenancyPresenter extends BasePresenter
{
	/**
	 * The tenancy name consists of the tenant's names.
	 * 
	 * @return string
	 */
	public function name()
	{
		if (count($this->users)) {
			foreach ($this->users as $user) {
				$names[] = $user->present()->fullName;
			}
		}

		if (isset($names) && count($names)) {
			return implode(' & ', $names);
		} else {
			return 'Tenancy #' . $this->id;
		}
	}

	/**
	 * The name for select dropdown menus.
	 * 
	 * @return  string
	 */
	public function selectName()
	{
		return $this->name . ' (' . $this->property->present()->shortAddress . ')';
	}

	/**
	 * @return mixed
	 */
	public function rentAmount($formatting = true)
	{
		$rent = $this->currentRent ? $this->currentRent->amount : 0;

		if ($formatting == true) {
			return money_formatted($rent);
		}

		return $rent;
	}

	/**
	 * @return int
	 */
	public function rentAmountPlain()
	{
		return pence_to_pounds($this->rentAmount(false));
	}

	/**
	 * @return mixed
	 */
	public function rentBalanceTotal($formatting = true)
	{
		$payments = $this->rent_payments->sum('amount');

		if ($formatting == true) {
			return money_formatted($payments);
		}

		return $payments;
	}

	/**
	 * @return mixed
	 */
	public function rentBalance($formatting = true)
	{
		$balance = $this->rentBalanceTotal(false) - $this->statementTotal(false);

		if ($formatting == true) {
			return money_formatted($balance);
		}

		return $balance;
	}

	/**
	 * @return integer
	 */
	public function rentBalancePlain()
	{
		return $this->rentBalance(false);
	}

	/**
	 * @return  string
	 */
	public function rentBalanceFormatted()
	{
		$class = '';

		if ($this->currentRent) {
			if ($this->rentBalancePlain >= $this->currentRent->amount) {
				$class = 'success';
			} elseif ($this->rentBalancePlain > 0 && $this->rentBalancePlain < $this->currentRent->amount) {
				$class = 'info';
			} elseif ($this->rentBalancePlain < 0) {
				$class = 'danger';
			}
		} else {
			$class = 'warning';
		}

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
	 * @return string
	 */
	public function serviceName()
	{
		if ($this->service) {
			return $this->service->name;
		}
	}

	/**
	 * @return string
	 */
	public function serviceCharge()
	{
		if ($this->service) {
			$charge = $this->service->charge - $this->serviceDiscounts->sum('amount');

	        if ($charge < 1) {
	            return $charge * 100 . '%';
	        } else {
	            return currency($charge);
	        }
	    }
	}

	/**
	 * @return string
	 */
	public function serviceChargeInCurrency()
	{
		return $this->serviceCharge;
	}

	/**
	 * @return int
	 */
	public function serviceReLettingFee()
	{
		if ($this->service) {
			return $this->service->re_letting_fee;
		}
	}

	/**
	 * @return string
	 */
	public function startDate()
	{
		return $this->first_agreement ? $this->first_agreement->starts_at : null;
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
	public function monthlyServiceChargeCost()
	{
		// Get the service charge amount
		$amount = round(calculateServiceCharge($this->entity));
		$tax = round(calculateTax($amount, $this->service->taxRate));

		return money_formatted($amount) . ' (+' . money_formatted($tax) . ')';
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
}