<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Storage;
use Laracasts\Presenter\Presenter;

class ExpensePresenter extends Presenter
{
	/**
	 * @return  string
	 */
	public function contractorName()
	{
		if ($this->contractor) {
			return $this->contractor->present()->fullName;
		}
	}

	/**
	 * @return  integer
	 */
	public function remainingBalance()
	{
		return $this->cost - $this->payments->sum('amount');
	}

	/**
	 * @return  string
	 */
	public function invoiceDownloadButtons()
	{
		foreach ($this->documents as $document) {
			$buttons[] = '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-primary btn-sm">Download</a>';
		}

		if (isset($buttons) && count($buttons)) {
			return implode(' ', $buttons);
		}
	}
}