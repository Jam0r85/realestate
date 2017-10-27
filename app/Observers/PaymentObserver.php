<?php

namespace App\Observers;

use App\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentObserver
{
	/**
	 * Listen to the Payment creating event.
	 * 
	 * @param \App\paymentq $payment
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
}