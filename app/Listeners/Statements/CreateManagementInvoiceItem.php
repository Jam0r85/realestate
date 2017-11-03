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
        $invoice = $statement->invoice;

        if ($tenancy->hasServiceCharge()) {

            if (!$invoice) {
                $invoice = new Invoice();
                $invoice->property_id = $tenancy->property->id;
                $statement->storeInvoice($invoice);
            }

            $description = $service->name . ' service at ' . $service->charge_formatted;
            if ($service->taxRate) {
                $description .= ' plus ' . $service->taxRate->name;
            }

            /**
             * Loop through any invoice items and make sure we do not have a duplicate.
             */
            foreach ($invoice->items as $item) {
                if ($item->description == $description) {
                    return;
                }
            }

            $item = new InvoiceItem();
            $item->name = $service->name;
            $item->description = $description;
            $item->amount = $tenancy->service_charge_amount;
            $item->quantity = 1;
            $item->tax_rate_id = $service->tax_rate_id;

            $invoice->storeItem($item);
        }
    }
}
