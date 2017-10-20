<?php

namespace App\Console\Commands;

use App\Expense;
use Illuminate\Console\Command;

class TransferExpenseContractors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:transfer-contractors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer the old contractors to the new contrtactor field';

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
        $expenses = Expense::get();

        foreach ($expenses as $expense) {

            foreach ($expense->contractors as $user) {
                $contractor_id = $user->id;
            }

            if (isset($contractor_id)) {
                $expense->contractor_id = $contractor_id;
                $expense->save();
            }
        }

        $this->info('Expense contractors transfered');
    }
}
