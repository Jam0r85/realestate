<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class BranchPresenter extends Presenter
{
	/**
	 * @return string
	 */
    public function location($letter = true)
    {
    	if ($letter) {
    		return nl2br($this->address);
    	}        
    }
}