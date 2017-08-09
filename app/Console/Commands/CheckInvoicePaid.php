<?php

namespace App\Console\Commands;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckInvoicePaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:check-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check whether unpaid invoices have been paid.';

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
        $unpaid_invoices = Invoice::whereNull('paid_at')->get();

        foreach ($unpaid_invoices as $invoice) {
            if ($invoice->total_balance <= 0) {
                $invoice->paid_at = Carbon::now();
                $invoice->save();
            }
        }

        $this->info('Invoices were checked');
    }
}
