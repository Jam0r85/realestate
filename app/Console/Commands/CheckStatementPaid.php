<?php

namespace App\Console\Commands;

use App\Repositories\EloquentStatementsRepository;
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
     * \App\Repositories\EloquentStatementsRepository
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
        foreach ($this->statements->getUnpaidList() as $statement) {
            if ($statement->landlord_balance_amount > 0) {
                if (!$statement->hasUnsentPayments()) {
                    $statement->update(['paid_at' => Carbon::now()]);
                }
            }
        }

        $this->info('Statements were checked');
    }
}
