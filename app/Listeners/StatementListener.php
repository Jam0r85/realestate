<?php

namespace App\Listeners;

use App\Events\StatementPaymentWasSent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StatementListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StatementPaymentWasSent  $event
     * @return void
     */
    public function paymentSent(StatementPaymentWasSent $event)
    {
    	$payment = $event->payment;
    	$statement = $payment->statement;

    	// Update the statement paid date
		if ($statement->hasBeenPaidInFull()) {
			$statement->paid_at = Carbon::now();
			$statement->saveWithMessage('set as paid');
		}
    }
}
