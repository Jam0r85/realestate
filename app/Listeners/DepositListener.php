<?php

namespace App\Listeners;

use App\Events\DepositPaymentWasCreated;
use App\Events\DepositPaymentWasDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DepositListener
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
     * @param  DepositPaymentWasCreated  $event
     * @return void
     */
    public function paymentCreated(DepositPaymentWasCreated $event)
    {
        $payment = $event->payment;
        $deposit = $payment->parent;

        $deposit->updateBalance();
    }

    /**
     * Handle the event.
     *
     * @param  DepositPaymentWasDeleted  $event
     * @return void
     */
    public function paymentDeleted(DepositPaymentWasDeleted $event)
    {
        $payment = $event->payment;
        $deposit = $payment->parent;

        $deposit->updatebalance();
    }
}
