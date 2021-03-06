<?php

namespace App\Listeners;

use App\Events\InvoicePaymentWasCreated;
use App\Events\RentPaymentWasCreated;
use App\Notifications\InvoicePaymentReceivedNotification;
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

        // Check whether we can send the user a notification
        if ($payment->canSendUserNotification()) {
            foreach ($payment->users as $user) {
                $user->notify(new TenancyRentPaymentReceived($payment));
            }
        }
    }

    /**
     * Handle the event.
     *
     * @param  InvoicePaymentWasCreated  $event
     * @return void
     */
    public function invoicePaymentCreated(InvoicePaymentWasCreated $event)
    {
        $payment = $event->payment;

        // Check whether we can send the user a notification
        if ($payment->canSendUserNotification()) {
            foreach ($payment->users as $user) {
                $user->notify(new InvoicePaymentReceivedNotification($payment, $invoice));
            }
        }
    }
}
