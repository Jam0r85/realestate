<?php

namespace App\Console\Commands;

use App\Invoice;
use Illuminate\Console\Command;

class InvoiceSetRecipientAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:set-recipient';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the invoice recipients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all of the invoices
        $invoices = Invoice::withTrashed()->get();

        // Check for attached users to the invoice
        foreach ($invoices as $invoice) {
            if (! $invoice->recipient) {
                $invoice->setRecipient();
                $invoice->save();
            }
        }

        $this->info('Invoices updated');
    }
}
