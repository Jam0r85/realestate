<?php

namespace App\Listeners\Tenancies;

use App\Events\Tenancies\TenancyUpdateStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckBalances
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
     * @param  UpdateStatus  $event
     * @return void
     */
    public function handle(TenancyUpdateStatus $event)
    {
        $tenancy = $event->tenancy;

        if ($tenancy) {
            $tenancy->rent_balance = $tenancy->getRentBalance();
            $tenancy->is_overdue = $tenancy->checkWhetherOverdue();
            $tenancy->saveWithMessage('balances updated');
        }
    }
}
