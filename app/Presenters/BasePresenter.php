<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class BasePresenter extends Presenter
{
	/**
	 * Get the branch name.
	 * 
	 * @return string
	 */
	public function branchName()
	{
		if ($this->branch) {
			return $this->branch->name;
		}

		return null;
	}

	/**
	 * Get the created at date for this record.
	 * 
	 * @return srting
	 */
	public function createdDate()
	{
		if ($this->created_at) {
			return $this->created_at->format(get_setting('date_format'));
		}

		return null;
	}


}