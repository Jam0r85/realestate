<?php

namespace App\Console\Commands;

use App\Jobs\GenerateRecurringInvoices;
use Illuminate\Console\Command;

class CheckForRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:check-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for recurring invoices and generate them on the dot';

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
        GenerateRecurringInvoices::dispatch();
        $this->info('Processed recurring invoices');
    }
}
