<?php

namespace App\Console\Commands;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InvoiceUpdateBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:update-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the the balances for the invoices';

    /**
     * Create a new command instance.
     *
     * @param \App\Repositories\EloquentInvoicesRepository $invoices
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
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
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

            $invoice->save();
        }

        $this->info('Invoices Updated');
    }
}
