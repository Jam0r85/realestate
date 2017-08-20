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
            if ($expense->balance_amount <= 0) {
                $expense->paid_at = Carbon::now();
                $expense->save();
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
            if ($expense->balance_amount > 0) {
                $expense->paid_at = null;
                $expense->save();
            }
        }

        $this->info('Paid expenses were checked');
    }
}
