<?php

namespace App\Observers;

use App\Events\Expenses\ExpenseUpdateBalances;
use App\Events\Invoices\InvoiceUpdateBalances;
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
	 * Listen to the StatementPayment updated event.
	 * 
	 * @param \App\StatementPayment $payment
	 * @return void
	 */
	public function saved(StatementPayment $payment)
	{
		if ($payment->parent) {
			if ($payment->present()->parentName == 'Invoice') {
				event (new InvoiceUpdateBalances($payment->parent));
			}
			if ($payment->present()->parentName == 'Expense') {
				event (new ExpenseUpdateBalances($payment->parent));
			}
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
		if ($payment->parent) {
			if ($payment->present()->parentName == 'Invoice' &&) {
				event (new InvoiceUpdateBalances($payment->parent));
			}
			if ($payment->present()->parentName == 'Expense') {
				event (new ExpenseUpdateBalances($payment->parent));
			}
		}
	}
}