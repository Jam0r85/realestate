<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class InvoicePresenter extends Presenter
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
}