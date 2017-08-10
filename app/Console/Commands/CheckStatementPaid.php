<?php

namespace App\Console\Commands;

use App\Statement;
use App\StatementPayment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStatementPaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:check-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update unpaid statements to see if they have been paid.';

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
        // Get all unpaid statements.
        $statements = Statement::whereNull('paid_at')->get();

        foreach ($statements as $statement) {

            // Get all the sent statement payments.
            $payments = StatementPayment::where('statement_id', $statement->id)->whereNotNull('sent_at')->get();
            $payments_total = $payments->sum('amount');

            if (count($payments)) {
                
                // Calculate the statement total.
                $statement_total = $statement->invoice_total_amount + $statement->landlord_balance_amount + $statement->expense_total_amount;

                if ($payments_total == $statement_total) {
                    $statement->paid_at = Carbon::now();
                    $statement->save();
                }
            }
        }

        $this->info('Statements were checked');
    }
}
