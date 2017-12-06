<?php

namespace App\Listeners\Statements;

use App\Events\StatementCreated;
use App\Invoice;
use App\InvoiceItem;
use App\Statement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateReLettingFeeInvoiceItem
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
     * @param  StatementCreated  $event
     * @return void
     */
    public function handle(StatementCreated $event)
    {
        $statement = Statement::findOrFail($event->statement->id);
        $tenancy = $statement->tenancy;
        $service = $tenancy->service;
        $property = $tenancy->property;

        // Is this the first tenancy for this property?
        if (count($property->tenancies) > 1) {

            // Is this the first statement for this tenancy?
            if (count($tenancy->statements) <= 1) {

                // Set the re-letting fee from the service
                $reLettingFee = $service->re_letting_fee;

                // Loop through the property owners and see whether there is a custom letting fee instead
                foreach ($property->owners as $user) {
                    if ($fee = $user->getSetting('tenancy_service_re_letting_fee')) {
                        $reLettingFee = $fee;
                    }
                }

                // Is the letting fee a valid amount?
                if ($reLettingFee > 0) {

                    // Grab the statement invoice or create one if not present.
                    if (!count($statement->invoices)) {
                        $invoice = $statement->storeInvoice();
                    } else {
                        $invoice = $statement->invoices->first();
                    }

                    $item = new InvoiceItem();
                    $item->name = $service->name;
                    $item->description = $service->name . ' Re-Letting Fee';
                    $item->amount = $reLettingFee;
                    $item->quantity = 1;
                    $item->tax_rate_id = $service->tax_rate_id;

                    $invoice->storeItem($item);
                }
            }
        }
    }
}
