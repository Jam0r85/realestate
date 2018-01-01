<?php

namespace App\Presenters;

class DocumentPresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function parentName()
	{
		if (model_name($this->parent) == 'Expense') {
			return $this->parent->name;
		}

		if (model_name($this->parent) == 'Tenancy') {
			return $this->parent->present()->name;
		}

		if (model_name($this->parent) == 'Deposit') {
			return $this->parent->tenancy->present()->name;
		}
	}

	/**
	 * @return string
	 */
	public function parentBadge()
	{
		return model_name($this->parent);
	}

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