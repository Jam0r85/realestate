<?php

namespace App\Presenters;

class BranchPresenter extends BasePresenter
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

   	/**
	 * @return string
	 */
	public function addressInline()
	{
		return str_replace('<br />', ', ', nl2br($this->address));
	}
}