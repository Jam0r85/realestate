<?php

namespace App\Observers;

use App\Events\Invoices\InvoiceUpdateBalancesEvent;
use App\Events\Tenancies\TenancyUpdateStatus;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PaymentObserver
{
	/**
	 * Listen to the Payment creating event.
	 * 
	 * @param \App\Payment $payment
	 * @return void
	 */
	public function creating(Payment $payment)
	{
		$payment->user_id = Auth::user()->id;
		$payment->key = str_random(30);
		
		if (request()->input('created_at')) {
			$payment->created_at = $payment->updated_at = Carbon::createFromFormat('Y-m-d', request()->input('created_at'));
		}
	}

	/**
	 * Listen to the Payment saved event.
	 * 
	 * @param \App\Payment $payment
	 * @return void
	 */
	public function saved(Payment $payment)
	{
		if ($payment->present()->parentName == 'Tenancy') {
			event(new TenancyUpdateStatus($payment->parent));
		}

		if ($payment->present()->parentName == 'Invoice') {
			event (new InvoiceUpdateBalancesEvent($payment->parent));
		}
	}

	/**
	 * Listen to the Payment deleted event.
	 * 
	 * @param \App\Payment $payment
	 * @return void
	 */
	public function deleted(Payment $payment)
	{
		if ($payment->present()->parentName == 'Tenancy') {
			event(new TenancyUpdateStatus($payment->parent));
		}

		if ($payment->present()->parentName == 'Invoice') {
			event (new InvoiceUpdateBalancesEvent($payment->parent));
		}
	}
}