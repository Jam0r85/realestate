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

        if (count($property->tenancies) > 1 && count($tenancy->statements) <= 1) {

            $re_letting_fee = $service->re_letting_fee;

            foreach ($property->owners as $user) {
                if ($fee = $user->settings['tenancy_service_re_letting_fee']) {
                    $re_letting_fee = $fee;
                }
            }

            if ($re_letting_fee > 0) {

                if (!count($statement->invoices)) {
                    $invoice = new Invoice();
                    $invoice->property_id = $tenancy->property->id;
                    $invoice = $statement->storeInvoice($invoice);
                }

                $item = new InvoiceItem();
                $item->name = $service->name;
                $item->description = $service->name . ' Re-Letting Fee';
                $item->amount = $re_letting_fee;
                $item->quantity = 1;
                $item->tax_rate_id = $service->tax_rate_id;

                $invoice->storeItem($item);
            }
        }
    }
}
