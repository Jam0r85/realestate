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
	public function recipient()
	{
		if ($this->statement) {
			return $this->statement->present()->recipient;
		}

		foreach ($this->users as $user) {
			$names[] = $user->present()->fullName;
			if (!isset($home)) {
				$home = $user->home->present()->letter;
			}
		}

		return implode(' & ', $names) . '<br />' . $this->recipient;
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
	public function branchAddress()
	{
		if ($this->property->branch->address) {
			return $this->property->branch->present()->address;
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