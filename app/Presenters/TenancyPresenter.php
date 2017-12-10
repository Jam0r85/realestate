<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class TenancyPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function name()
	{
		if (count($this->tenants)) {
			foreach ($this->tenants as $user) {
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
	 * @return mixed
	 */
	public function rentAmount($formatting = true)
	{
		$rent = $this->currentRent ? $this->currentRent->amount : 0;

		if ($formatting == true) {
			return currency($rent);
		}

		return $rent;
	}

	/**
	 * @return int
	 */
	public function rentAmountPlain()
	{
		return $this->rentAmount(false);
	}

	/**
	 * @return mixed
	 */
	public function rentBalanceTotal($formatting = true)
	{
		$payments = $this->rent_payments->sum('amount');

		if ($formatting == true) {
			return currency($payments);
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
			return currency($balance);
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
		return $this->service->name;
	}

	/**
	 * @return string
	 */
	public function serviceCharge()
	{
		$charge = $this->service->charge - $this->serviceDiscounts->sum('amount');

        if ($charge < 1) {
            return $charge * 100 . '%';
        } else {
            return currency($charge);
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
		return $this->service->re_letting_fee;
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
	 * Present the status of this tenancy.
	 * 
	 * @param  string  $return
	 * @return  string
	 */
	public function status($return = 'value')
	{
		if ($this->vacated_on && $this->vacated_on <= Carbon::now()) {
			$data['value'] = 'Vacated';
		}

		if ($this->vacated_on && $this->vacated_on > Carbon::now()) {
			$data['value'] = 'Vacating';
		}

		if (!$this->vacated_on) {
			$data['value'] = 'Active';
		}

		if ($this->deleted_at) {
			$data['value'] = 'Archived';
			$data['class'] = 'secondary';
		}

		return $data[$return];
	}
}