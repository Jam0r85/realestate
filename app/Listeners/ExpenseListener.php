<?php

namespace App\Listeners;

use App\Events\ExpenseStatementPaymentWasSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExpenseListener
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
     * @param  ExpenseStatementPaymentSaved  $event
     * @return void
     */
    public function statementPaymentSaved(ExpenseStatementPaymentWasSaved $event)
    {
        $payment = $event->payment;
        $expense = $payment->parent;
        
        $expense->updateBalances();
    }
}
