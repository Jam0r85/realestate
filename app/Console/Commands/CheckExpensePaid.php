<?php

namespace App\Console\Commands;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpensePaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:check-paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check whether expenses have been paid or not';

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
        $this->unpaid();
        $this->paid();
    }

    /**
     * Check the unpaid expenses.
     * 
     * @return void
     */
    protected function unpaid()
    {
        $expenses = Expense::whereNull('paid_at')->get();

        foreach ($expenses as $expense) {

            $balance = $expense->cost - $expense->payments->sum('amount');

            if ($balance <= 0) {

                // We automatically set the statements as having been paid.
                $statements_paid = true;

                // Loop through each of the statements attached to the expense and check whether they have been paid.
                foreach ($expense->statements as $statement) {
                    if (is_null($statement->paid_at)) {
                        $statements_paid = false;
                    }
                }

                // Should all statements attached to this expense be paid, we mark the expense as being paid.
                if ($statements_paid == true) {
                    $expense->paid_at = Carbon::now();
                    $expense->save();
                }
            }
        }

        $this->info('Unpaid expenses were checked');
    }

    /**
     * Check the paid expenses.
     * 
     * @return void
     */
    protected function paid()
    {
        $expenses = Expense::whereNotNull('paid_at')->get();

        foreach ($expenses as $expense) {

            $balance = $expense->cost - $expense->payments->sum('amount');

            if ($balance > 0) {
                $expense->paid_at = null;
                $expense->save();
            }
        }

        $this->info('Paid expenses were checked');
    }
}
