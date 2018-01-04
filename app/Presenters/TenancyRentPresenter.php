<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class TenancyRentPresenter extends Presenter
{
    /**
     * @return string
     */
    public function status()
    {
        // Record start date is in the future
        if ($this->starts_at > Carbon::now()) {
            return 'Pending';
        }

        // Record has been deleted
        if ($this->deleted_at) {
            return 'Archived';
        }

        // Check whether new records exist
        if ($this->entity->hasNewerRent()) {
            return 'Ended';
        }

        return 'Active';
    }
}