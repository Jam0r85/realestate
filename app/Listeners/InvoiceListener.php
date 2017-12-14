<?php

namespace App\Listeners;

use App\Events\InvoiceItemWasCreated;
use App\Events\InvoiceItemWasUpdated;
use App\Events\InvoicePaymentWasCreated;
use App\Events\InvoiceStatementPaymentWasSaved;
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

    /**
     * Handle the event.
     *
     * @param  InvoicePaymentWasCreated  $event
     * @return void
     */
    public function paymentCreated(InvoicePaymentWasCreated $event)
    {
        $payment = $event->payment;
        $invoice = $payment->parent;
        
        $invoice->updateBalances();
    }
}