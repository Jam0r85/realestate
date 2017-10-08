<?php

namespace App\Console\Commands;

use App\Statement;
use Illuminate\Console\Command;

class UpdateInvoicePaidDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:update-paid-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the invoice paid date (fixes bug)';

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
        $statements = Statement::get();

        foreach ($statements as $statement) {
            if ($invoice = $statement->invoice) {
                $invoice->paid_at = $statement->paid_at;
                $invoice->save();
            }
        }

        $this->info('Invoices were updated');
    }
}
