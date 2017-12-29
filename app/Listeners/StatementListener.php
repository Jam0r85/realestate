<?php

namespace App\Listeners;

use App\Events\ExpenseWasAttachedToStatement;
use App\Events\InvoiceItemWasDeleted;
use App\Events\InvoiceItemWasUpdated;
use App\Events\StatementPaymentWasSent;
use App\StatementPayment;
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
     * @param  InvoiceItemWasUpdated  $event
     * @return void
     */
    public function invoiceItemWasUpdated(InvoiceItemWasUpdated $event)
    {
        $item = $event->item;
        $invoice = $item->invoice;

        if (count($invoice->statements)) {
            foreach ($invoice->statements as $statement) {
                $repository = new StatementPayment();
                $repository->createInvoicePayment($statement);
                $repository->createLandlordPayment($statement);
            }
        }
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceItemWasDeleted  $event
     * @return void
     */
    public function invoiceItemWasDeleted(InvoiceItemWasDeleted $event)
    {
        $item = $event->item;
        $invoice = $item->invoice;

        if (count($invoice->statements)) {
            foreach ($invoice->statements as $statement) {
                $repository = new StatementPayment();
                $repository->createInvoicePayment($statement);
                $repository->createLandlordPayment($statement);
            }
        }
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
