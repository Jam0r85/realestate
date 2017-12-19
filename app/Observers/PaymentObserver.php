<?php

namespace App\Observers;

use App\Events\DepositPaymentWasCreated;
use App\Events\InvoicePaymentWasCreated;
use App\Events\InvoicePaymentWasDeleted;
use App\Events\RentPaymentWasCreated;
use App\Events\RentPaymentWasDeleted;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PaymentObserver
{
	/**
	 * Listen to the Payment creating event.
	 * 
	 * @param  \App\Payment  $payment
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
	 * Listen to the Payment created event.
	 * 
	 * @param  \App\Payment  $payment
	 * @return void
	 */
	public function created(Payment $payment)
	{
		if ($payment->present()->parentName == 'Invoice') {
			event(new InvoicePaymentWasCreated($payment));
		}	

		if ($payment->present()->parentName == 'Tenancy') {
			event(new RentPaymentWasCreated($payment));
		}

		if ($payment->present()->parentName == 'Deposit') {
			event(new DepositPaymentWasCreated($payment));
		}
	}

	/**
	 * Listen to the Payment deleted event.
	 * 
	 * @param  \App\Payment  $payment
	 * @return void
	 */
	public function deleted(Payment $payment)
	{
		if ($payment->present()->parentName == 'Invoice') {
			event(new InvoicePaymentWasDeleted($payment));
		}	

		if ($payment->present()->parentName == 'Tenancy') {
			event(new RentPaymentWasDeleted($payment));
		}

		if ($payment->present()->parentName == 'Deposit') {
			event(new DepositPaymentWasDeleted($payment));
		}
	}
}