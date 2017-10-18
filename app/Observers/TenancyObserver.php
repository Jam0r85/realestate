<?php

namespace App\Observers;

use App\Tenancy;

class TenancyObserver
{
    /**
     * Listen to the tenancy deleting event.
     * 
     * @param tenancy $tenancy
     */
    public function deleting(Tenancy $tenancy)
    {
        $tenancy::disableSearchSyncing();
    }

    /**
     * Listen to the tenancy deleted event.
     * 
     * @param tenancy $tenancy
     */
    public function deleted(Tenancy $tenancy)
    {
        $tenancy::enableSearchSyncing();
        $tenancy->searchable();
    }
}