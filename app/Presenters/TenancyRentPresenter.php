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
        if ($this->starts_at > Carbon::now()) {
            return 'Pending';
        }

        if ($this->deleted_at) {
            return 'Archived';
        }

        return 'Active';
    }
}