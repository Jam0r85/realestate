<?php

namespace App\Listeners;

use App\Events\RentPaymentWasCreated;
use App\Notifications\TenancyRentPaymentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserListener
{
    /**
     * Handle the event.
     *
     * @param  RentPaymentWasCreated  $event
     * @return void
     */
    public function rentPaymentCreated(RentPaymentWasCreated $event)
    {
        $payment = $event->payment;
        $tenancy = $payment->parent;

        foreach ($tenancy->users as $user) {
            $user->notify(new TenancyRentPaymentReceived($payment));
        }
    }
}
