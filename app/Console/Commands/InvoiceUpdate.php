<?php

namespace App\Console\Commands;

use App\Events\Invoices\InvoiceUpdateBalances;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InvoiceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:update';

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
            event(new InvoiceUpdateBalances($invoice));
        }

        $this->info('Invoices Updated');
    }
}
