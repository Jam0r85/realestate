<?php

namespace App\Listeners;

use App\Events\DepositPaymentWasCreated;
use App\Events\DepositPaymentWasDeleted;
use App\Events\RentPaymentWasCreated;
use App\Events\RentPaymentWasDeleted;
use App\Events\StatementWasCreated;
use App\Events\StatementWasSent;
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
     * @param  StatementWasSent  $event
     * @return void
     */
    public function statementSent(StatementWasSent $event)
    {
        $statement = $event->statement;
        $tenancy = $statement->tenancy;

        $tenancy->is_overdue = $tenancy->checkWhetherOverdue();
        $tenancy->saveWithMessage('overdue checked');  
    }

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

        $tenancy->updateRentBalance();
    }

    /**
     * Handle the event.
     *
     * @param  RentPaymentWasDeleted  $event
     * @return void
     */
    public function rentPaymentDeleted(RentPaymentWasDeleted $event)
    {
        $payment = $event->payment;
        $tenancy = $payment->parent;

        $tenancy->updateRentBalance();
    }

    /**
     * Handle the event.
     *
     * @param  DepositPaymentWasCreated  $event
     * @return void
     */
    public function depositPaymentCreated(DepositPaymentWasCreated $event)
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
    public function depositPaymentDeleted(DepositPaymentWasDeleted $event)
    {
        $payment = $event->payment;
        $deposit = $payment->parent;

        $deposit->updateBalance();
    }  
}
