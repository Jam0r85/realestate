<?php

namespace App\Listeners;

use App\Events\InvoiceItemWasCreated;
use App\Events\InvoiceItemWasDeleted;
use App\Events\InvoiceItemWasUpdated;
use App\Events\InvoicePaymentWasCreated;
use App\Events\InvoicePaymentWasDeleted;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Events\InvoiceStatementPaymentWasSent;
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
    public function itemWasCreated(InvoiceItemWasCreated $event)
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
    public function itemWasUpdated(InvoiceItemWasUpdated $event)
    {
        $item = $event->item;
        $invoice = $item->invoice;

        $invoice->updateBalances();
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceItemWasDeleted  $event
     * @return void
     */
    public function itemWasDeleted(InvoiceItemWasDeleted $event)
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
     * @param  InvoiceStatementPaymentWasSent  $event
     * @return void
     */
    public function statementPaymentSent(InvoiceStatementPaymentWasSent $event)
    {
        $payment = $event->payment;
        $invoice = $payment->parent;

        $invoice->sent_at = $payment->sent_at;
        $invoice->saveWithMessage('set as sent');
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

    /**
     * Handle the event.
     *
     * @param  InvoicePaymentWasCreated  $event
     * @return void
     */
    public function paymentDeleted(InvoicePaymentWasDeleted $event)
    {
        $payment = $event->payment;
        $invoice = $payment->parent;
        
        $invoice->updateBalances();
    }
}