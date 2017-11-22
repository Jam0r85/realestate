<?php

namespace App\Presenters;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class TenancyRentPresenter extends Presenter
{
    /**
     * @return string
     */
    public function status($return = 'label')
    {
        if ($this->starts_at > Carbon::now()) {
            $data['label'] = 'Pending';
            $data['class'] = 'info';
        } elseif ($this->deleted_at) {
            $data['label'] = 'Archived';
            $data['class'] = 'secondary';
        } else {
            $data['label'] = 'Active';
            $data['class'] = 'success';
        }

        return $data[$return];
    }
}