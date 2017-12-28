<?php

namespace App\Listeners;

use App\Events\ExpenseWasAttachedToStatement;
use App\Events\StatementWasCreated;
use App\Events\StatementWasDeleted;
use App\Events\StatementWasUpdated;
use App\StatementPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StatementPaymentListener
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

        $repository = new StatementPayment();
        $repository->createPayments($statement);
    }

    /**
     * Handle the event.
     *
     * @param  StatementWasUpdated  $event
     * @return void
     */
    public function statementWasUpdated(StatementWasUpdated $event)
    {
        $statement = $event->statement;

        $repository = new StatementPayment();
        $repository->createPayments($statement);
    }

    /**
     * Handle the event.
     *
     * @param  StatementWasDeleted  $event
     * @return void
     */
    public function statementDeleted(StatementWasDeleted $event)
    {
        $statement = $event->statement;

    }

    /**
     * Handle the event.
     *
     * @param  StatementWasCreated  $event
     * @return void
     */
    public function expenseWasAttached(ExpenseWasAttachedToStatement $event)
    {
        $statement = $event->statement;

        $repository = new StatementPayment();
        $repository->createPayments($statement);
    }
}
