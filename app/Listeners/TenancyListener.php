<?php

namespace App\Listeners;

use App\Events\RentPaymentWasCreated;
use App\Events\RentPaymentWasDeleted;
use App\Events\StatementWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TenancyListener
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
     * @param  StatementWasCreated  $event
     * @return void
     */
    public function statementCreated(StatementWasCreated $event)
    {
        $statement = $event->statement;
        $tenancy = $statement->tenancy;

        $tenancy->updateRentBalance();
    }

    /**
     * Handle the event.
     *
     * @param  PaymentWasCreated  $event
     * @return void
     */
    public function rentPaymentCreated(RentPaymentWasCreated $event)
    {
        $payment = $event->payment;
        $tenancy = $payment->parent;

        $tenancy->updateRentBalance();
    }

    /**
     * Handle the event.
     *
     * @param  PaymentWasCreated  $event
     * @return void
     */
    public function rentPaymentDeleted(RentPaymentWasDeleted $event)
    {
        $payment = $event->payment;
        $tenancy = $payment->parent;

        $tenancy->updateRentBalance();
    }    
}
