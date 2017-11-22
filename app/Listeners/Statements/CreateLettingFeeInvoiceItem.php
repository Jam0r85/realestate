<?php

namespace App\Listeners\Statements;

use App\Events\StatementCreated;
use App\Invoice;
use App\InvoiceItem;
use App\Statement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateLettingFeeInvoiceItem
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
        $invoice = $statement->invoice();

        if (count($property->tenancies) <= 1 && $service->letting_fee && count($tenancy->statements) <= 1) {

            if (!$invoice) {
                $invoice = new Invoice();
                $invoice->property_id = $tenancy->property->id;
                $statement->storeInvoice($invoice);
            }

            $item = new InvoiceItem();
            $item->name = $service->name;
            $item->description = $service->name . ' Letting Fee';
            $item->amount = $service->letting_fee;
            $item->quantity = 1;
            $item->tax_rate_id = $service->tax_rate_id;

            $invoice->storeItem($item);
        }
    }
}
