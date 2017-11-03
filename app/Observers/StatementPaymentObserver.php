<?php

namespace App\Observers;

use App\StatementPayment;
use Illuminate\Support\Facades\Auth;

class StatementPaymentObserver
{
	/**
	 * Listen to the StatementPayment creating event.
	 * 
	 * @param \App\StatementPayment $payment
	 * @return void
	 */
	public function creating(StatementPayment $payment)
	{
		$payment->user_id = Auth::user()->id;
	}
}