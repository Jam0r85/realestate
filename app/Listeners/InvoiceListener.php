<?php

namespace App\Listeners;

use App\Events\InvoiceItemWasCreated;
use App\Events\InvoiceItemWasUpdated;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Events\StatementWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoiceListener
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
        $statement->createInvoiceItems();
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceItemWasCreated  $event
     * @return void
     */
    public function itemCreated(InvoiceItemWasCreated $event)
    {
        $item = $event->item;
        $invoice = $item->invoice;

        $invoice->updateBalances();
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceItemWasUpdated  $event
     * @return void
     */
    public function itemUpdated(InvoiceItemWasUpdated $event)
    {
        $item = $event->item;
        $invoice = $item->invoice;

        $invoice->updateBalances();
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceStatementPaymentWasSaved  $event
     * @return void
     */
    public function statementPaymentSaved(InvoiceStatementPaymentWasSaved $event)
    {
        $payment = $event->payment;
        $invoice = $payment->parent;
        
        $invoice->updateBalances();
    }
}