<?php

namespace App\Listeners;

use App\Events\StatementWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceItemListener
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
     * @param  StatementWasCreated  $event
     * @return void
     */
    public function statementCreated(StatementWasCreated $event)
    {
        $statement = $event->statement;

        return dd($statement);
    }
}
