<?php

namespace App\Console\Commands;

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
     * \App\Repositories\EloquentInvoicesRepository
     */
    public $invoices;

    /**
     * Create a new command instance.
     *
     * @param \App\Repositories\EloquentInvoicesRepository $invoices
     * @return void
     */
    public function __construct(EloquentInvoicesRepository $invoices)
    {
        parent::__construct();
        $this->invoices = $invoices;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->invoices->getUnpaidList() as $invoice) {
            if ($invoice->total_balance <= 0) {
                $invoice->update(['paid_at' => Carbon::now()]);
            }
        }

        $this->info('Invoices were checked');
    }
}
