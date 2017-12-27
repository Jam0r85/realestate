<?php

namespace App\Observers;

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
	}
}