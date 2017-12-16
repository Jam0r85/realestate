<?php

namespace App\Console\Commands;

use App\StatementPayment;
use Illuminate\Console\Command;

class UpdateStatementPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:update-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $company_user = get_setting('company_user_id');

        if ($company_user) {
            StatementPayment::where('parent_type', 'invoices')->chunk(200, function ($payments) use ($company_user) {
                foreach ($payments as $payment) {
                    $payment->users()->sync($company_user);
                }
            });

            $this->info('Payments updated');
        }
    }
}
