<?php

namespace App\Jobs;

use App\Invoice;
use App\InvoiceRecurring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateRecurringInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recurring_invoices = InvoiceRecurring::invoiceDue()->get();

        foreach ($recurring_invoices as $recur) {

            $invoice = $recur->invoice;

            $new_invoice = $invoice->clone([
                'recur_id' => $recur->id
            ]);

            $recur->next_invoice = date_modifier(
                $recur->next_invoice,
                $recur->interval_type,
                $recur->interval
            );
            
            $recur->save();
        }
    }
}
