<?php

namespace App\Console\Commands;

use App\Repositories\EloquentStatementsRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatementBackgroundChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:background-checks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process statement related background checks.';

    /**
     * @var App\Repositories\EloquentStatementsRepository
     */
    public $statements;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EloquentStatementsRepository $statements)
    {
        parent::__construct();

        $this->statements = $statements;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->statements->getUnsetList() as $statement) {

            if (count($statement->payments)) {

                $paid = true;

                // Loop through each of the statement payments and see whether it has been sent.
                foreach ($statement->payments as $payment) {
                    if (is_null($payment->sent_at)) {
                        $paid = false;
                    }
                }

                if (is_null($statement->paid_at) && $paid == true) {
                    $statement->update(['paid_at' => Carbon::now()]);
                }
            }
        }

         $this->info('Statement background checks processed');
    }
}
