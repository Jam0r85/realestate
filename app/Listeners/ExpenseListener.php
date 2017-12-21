<?php

namespace App\Listeners;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\ExpenseStatementPaymentWasSent;
use App\Events\ExpenseWasCreated;
use App\Notifications\ExpensePaidToContractor;
use App\Notifications\ExpenseWasReceivedToContractor;
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
     * @param  ExpenseWasCreated  $event
     * @return void
     */
    public function created(ExpenseWasCreated $event)
    {
        $expense = $event->expense;

        if ($expense->canSendReceivedNotification()) {
            $expense->contractor->notify(new ExpenseWasReceivedToContractor($expense));
        }
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

    /**
     * Handle the event.
     *
     * @param  ExpenseStatementPaymentSaved  $event
     * @return void
     */
    public function statementPaymentSent(ExpenseStatementPaymentWasSent $event)
    {
        $payment = $event->payment;
        $expense = $payment->parent;

        if ($expense->canSendPaidNotificationToContractor()) {
            $expense->contractor->notify(new ExpensePaidToContractor($payment, $expense));
        }
    }
}
