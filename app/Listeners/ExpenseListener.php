<?php

namespace App\Listeners;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\ExpenseStatementPaymentWasSent;
use App\Events\ExpenseWasCreated;
use App\Notifications\ExpenseWasPaidToContractor;
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

        // Notify contractor that the expense was recorded
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

        // Notifiy contractor that the expense has been paid in full.
        if ($expense->canSendPaidNotification()) {
            $expense->contractor->notify(new ExpenseWasPaidToContractor($payment, $expense));
        }
    }
}
