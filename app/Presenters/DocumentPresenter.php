<?php

namespace App\Presenters;

class DocumentPresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function status()
	{
		if ($this->deleted_at) {
			return 'Hidden';
		} else {
			return 'Visible';
		}
	}

	/**
	 * @return string
	 */
	public function statusIcon()
	{
		if ($this->deleted_at) {
			return 'hidden';
		} else {
			return 'visible';
		}
	}
}