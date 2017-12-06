<?php

namespace App\Listeners\Statements;

use App\Events\StatementCreated;
use App\Invoice;
use App\InvoiceItem;
use App\Statement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateManagementInvoiceItem
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

        // Do we have a valid service charge amount?
        if ($tenancy->getServiceChargeNetAmount() > 0) {

            if (!count($statement->invoices)) {
                $invoice = $statement->storeInvoice();
            } else {
                $invoice = $statement->invoices->first();
            }

            // Format the description
            $description = $service->name . ' service at ' . $service->charge_formatted;

            // If there is a tax rate add it to the description as well
            if ($service->taxRate) {
                $description .= ' plus ' . $service->taxRate->name;
            }

            // Loop through each of the current invoice items and check for duplicates
            foreach ($invoice->items as $item) {
                if ($item->description == $description) {
                    return;
                }
            }

            $item = new InvoiceItem();
            $item->name = $service->name;
            $item->description = $description;
            $item->amount = $tenancy->getServiceChargeNetAmount($statement->amount);
            $item->quantity = 1;
            $item->tax_rate_id = $service->tax_rate_id;

            $invoice->storeItem($item);
        }
    }
}
