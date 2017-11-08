<?php

namespace App\Jobs;

use App\Notifications\InvoiceSentNotification;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInvoiceToUsers
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The invoice we are sending.
     * 
     * @var \App\Invoice
     */
    public $invoice;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->invoice->users as $user) {
            $user->notify(new InvoiceSentNotification($this->invoice, $user));
        }
    }
}
