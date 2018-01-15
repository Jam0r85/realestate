<?php

namespace App\Policies;

use App\InvoiceGroup;

class InvoiceGroupPolicy extends BasePolicy
{
    /**
     * Determine if the given invoice group can be force deleted.
     * 
     * @return bool
     */
    public function forceDelete(InvoiceGroup $invoice_group)
    {
        //
    }
}
