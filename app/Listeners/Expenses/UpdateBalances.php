<?php

namespace App\Listeners\Expenses;

use App\Events\Expenses\ExpenseUpdateBalances;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBalances
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExpenseUpdateBalances  $event
     * @return void
     */
    public function handle(ExpenseUpdateBalances $event)
    {
        $expense = $event->expense;

        $expense->balance = $expense->cost - $expense->paymentsSent->sum('amount');

        if ($expense->balance <= 0) {
            if (!$expense->paid_at) {
                $expense->paid_at = Carbon::now();
            }
        } else {
            $expense->paid_at = null;
        }

        $expense->saveWithMessage('balance updated');
    }
}
