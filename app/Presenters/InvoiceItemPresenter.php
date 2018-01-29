<?php

namespace App\Presenters;

class InvoiceItemPresenter extends BasePresenter
{
	/**
	 * Get the item name with the invoice number
	 * 
	 * @return string
	 */
	public function nameWithInvoiceNumber()
	{
		return $this->entity->name . ' (' . $this->entity->invoice->present()->name . ')';
	}

	/**
	 * Get the item description with discounts.
	 * 
	 * @return string
	 */
	public function descriptionWithDiscounts(array $discounts = [])
	{
		// Set the description
		$description = $this->entity->description;

		// Check whether the item has any discounts attached to it
		if (count($this->entity->discounts)) {
			foreach ($this->entity->discounts as $discount) {
				$discounts[] = 'Including ' . $discount->present()->nameWithAmount;
			}
		}

		return $description . '<br /> ' . implode('<br />', $discounts);
	}
}