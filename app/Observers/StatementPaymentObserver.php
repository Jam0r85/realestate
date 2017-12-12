<?php

namespace App\Observers;

use App\Events\Invoices\InvoiceUpdateBalancesEvent;
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

	/**
	 * Listen to the StatementPayment saved event.
	 * 
	 * @param \App\StatementPayment $payment
	 * @return void
	 */
	public function saved(StatementPayment $payment)
	{
		if ($payment->present()->parentName == 'Invoice') {
			event (new InvoiceUpdateBalancesEvent($payment->parent));
		}
	}

	/**
	 * Listen to the StatementPayment deleted event.
	 * 
	 * @param \App\StatementPayment $payment
	 * @return void
	 */
	public function deleted(StatementPayment $payment)
	{
		if ($payment->present()->parentName == 'Invoice') {
			event (new InvoiceUpdateBalancesEvent($payment->parent));
		}
	}
}