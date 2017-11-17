<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class BranchPresenter extends Presenter
{
	/**
	 * @return string
	 */
    public function address($letter = true)
    {
    	if ($letter) {
    		return nl2br($this->address);
    	}        
    }
}