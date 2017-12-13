<?php

namespace App\Listeners;

use App\Events\ExpenseStatementPaymentWasSaved;
use App\Events\InvoiceStatementPaymentWasSaved;
use App\Events\LandlordStatementPaymentWasSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StatementListener
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
     * @param  InvoiceStatementPaymentWasSaved  $event
     * @return void
     */
    public function landlordPaymentSaved(InvoiceStatementPaymentWasSaved $event)
    {
        $payment = $event->payment;
        $statement = $payment->statement;
    }

    /**
     * Handle the event.
     *
     * @param  LandlordStatementPaymentWasSaved  $event
     * @return void
     */
    public function expensePaymentSaved(ExpenseStatementPaymentWasSaved $event)
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  LandlordStatementPaymentWasSaved  $event
     * @return void
     */
    public function landlordPaymentSaved(LandlordStatementPaymentWasSaved $event)
    {
        
    }
}
