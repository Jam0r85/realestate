<?php

namespace App\Listeners\Invoices;

use App\Events\Invoices\InvoiceUpdateBalances;
use App\Events\Payments\PaymentRecorded;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBalances
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
     * @param  InvoiceUpdateBalancesEvent  $event
     * @return void
     */
    public function handle(PaymentRecorded $event)
    {
        $payment = $event->payment;

        if ($invoice = class_basename($payment->parent) == 'Invoice') {
            $invoice->net = $invoice->present()->itemsTotalNet;
            $invoice->tax = $invoice->present()->itemsTotalTax;
            $invoice->total = $invoice->present()->itemsTotal;
            $invoice->balance = $invoice->present()->remainingBalanceTotal;

            if ($invoice->balance <= 0 && count($invoice->items)) {
                if (!$invoice->paid_at) {
                    $invoice->paid_at = Carbon::now();
                }
            } else {
                $invoice->paid_at = null;
            }

            $invoice->saveWithMessage('balances updated');
        }
    }
}
