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
        $statements = Statement::whereNull('paid_at')->get();

        foreach ($statements as $statement) {

            $amount_paid = $statement->payments()->whereNotNull('sent_at')->sum('amount');

            if ($amount_paid >= $statement->amount) {
                $statement->paid_at = Carbon::now();
                $statement->save();
            }
        }

        $this->info('Statements were checked');
    }
}
