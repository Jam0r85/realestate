<?php

namespace App\Observers;

use App\Deposit;
use App\Events\DepositWasForceDeleted;

class DepositObserver
{
	/**
	 * Listen to the Document updated event.
	 * 
	 * @param  \App\Document  $document
	 * @return void
	 */
	public function updated(Deposit $deposit)
	{

	}

	/**
	 * Listen to the Document deleted event.
	 * 
	 * @param  \App\Document  $document
	 * @return void
	 */
	public function deleted(Deposit $deposit)
	{
		if ($deposit->forceDeleting) {
            event (new DepositWasForceDeleted($deposit));
		}
	}
}