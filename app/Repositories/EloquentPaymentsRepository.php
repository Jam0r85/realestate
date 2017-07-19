<?php

namespace App\Repositories;

use App\Payment;

class EloquentPaymentsRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\Payment';
	}

	/**
	 * Create a new payment.
	 * 
	 * @param  array  $data
	 * @param  parent $parent
	 * @return mixed
	 */
	public function createPayment(array $data, $parent)
	{
		if (!method_exists($parent, 'payments')) {
			return;
		}

		// Create a random key.
		$data['key'] = str_random(30);

		// Create the payment
		$payment = $parent->payments()->create($data);

		// Attach users
		if (isset($data['user_id'])) {
			$payment->users()->attach($data['user_id']);
		}

		// Flash a success message.
		$this->successMessage('The payment was created');

		// Return the Payment.
		return $payment;
	}
}